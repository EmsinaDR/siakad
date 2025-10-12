<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\User;
use App\Models\Admin\Ekelas;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\QrCodeGenerates;
use Illuminate\Support\Facades\DB;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\User\Siswa\Detailsiswa;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\QrCodeController;
use App\Models\WakaKesiswaan\Ekstra\Ekstra;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\WakaKesiswaan\PPDB\DataSiswaTarget;

class ExcelController extends Controller
{
    public function showForm()
    {



        $title = 'Tespage';
        $breadcrumb = 'Data / Data Testpage';
        $ekstras = Ekstra::select('id', 'ekstra')->get();
        $ekstras = Ekstra::get();
        return view('admin.testpage', compact('title', 'breadcrumb', 'ekstras'));
    }

    public function uploadExcel(Request $request)
    {

        try {
            $NewName = 'pegawai.xls';
            $file = $request->file('file'); //file : name pada form upload
            $fileName = $file->getClientOriginalName();
            $tempDirectory = public_path('temp/') . $file->getClientOriginalName();

            // Mengecek File eksist
            if (File::exists($tempDirectory)) {
                $pesan = 'exsiting';
                // unlink(public_path('temp/') . $fileName); // Menghapus File dari deirektori sementara
            } else {
                $pesan = 'no exsiting';
                $file->move(public_path('temp/'), $fileName); //Memindahkan file ke direktori sementara untuk dibaca datanya
            }
            $spreadsheet = IOFactory::load('' . public_path('temp/') . $file->getClientOriginalName() . '');
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();
            // Proses data dari excel di baca dan dimasukkan kedalam database
            foreach ($data as $index => $row) {
                if ($index == 0) continue; // Lewati baris header (judul kolom)

                //Buat Pengecekan untuk data error
                //Pengecekan Email Uniq
                $cekemail = User::select('email')->where('email', $row[2])->pluck('email')->count();
                // dd($cekemail);
                if ($cekemail > 0) {
                    continue;
                    // return Redirect::back()->with('Title', 'Terdapat duplicate email')->with('gagal', 'Email Ganda untuk email ' . $row[2]);
                } else {
                    //Pengecekan Nis
                    $ceknis = Detailsiswa::where('nis', $row[10])->orWhere('nisn', $row[11])->exists();
                    if ($ceknis) continue;
                    else {
                        //Pengecekan Nisn

                        // Simpan ke database (sesuaikan dengan struktur tabel Anda)
                        $user = new User();
                        $user->posisi = $row[4]; //Row Menyatakan kolom dalam excel
                        $user->aktiv = $row[5];
                        $user->name = $row[1];
                        $user->email = $row[2];
                        $user->password = Hash::make($row[3]);
                        $user->save();

                        // creat data detailsiswa sambil ambil data user->id terakhir untuk kolom user_id
                        $cekuserAkhir = User::select('id')->pluck('id')->max();
                        $Detailuser = new Detailsiswa();
                        $Detailuser->user_id = $cekuserAkhir;
                        $Detailuser->nama_siswa = $row[9];
                        $Detailuser->nis = $row[10];
                        $Detailuser->nisn = $row[11];
                        $Detailuser->nokk = $row[12];
                        $Detailuser->tahun_masuk = $row[15];
                        $Detailuser->agama = $row[17];
                        $Detailuser->nohp_siswa = $row[18];
                        $Detailuser->jml_saudara = $row[19];
                        $Detailuser->save();

                        // Updat detailsiswa_id di tabel user
                        $DetailuserAkhir = Detailsiswa::select('id')->pluck('id')->max();
                        $user = User::findOrFail($cekuserAkhir);
                        $user->detailsiswa_id = $DetailuserAkhir;
                        $user->update();

                        // Proses pembuatan QrCode NIS
                        $path = public_path('/img/qrcode_siswa/' . $Detailuser->nis . '.png'); // Tentukan path penyimpanan
                        QrCode::size(300)->format('png')->generate($Detailuser->nis, $path);
                    }

                    $tempDirectory = public_path('temp/') . $file->getClientOriginalName();
                    // unlink(public_path('temp/') . $fileName); // Menghapus File dari deirektori sementara
                    // dd($data);

                    $file = $request->file('file');
                    // return Redirect::back()->with('Title', 'Upload Logo')->with('Success', 'Upload Logo Sukses dan telah disimpan');
                }
            }
            unlink(public_path('temp/') . $fileName); // Menghapus File dari deirektori sementara
            return Redirect::back()->with('Title', 'Upload Data')->with('Success', 'Data telah selesai diproses');
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Upload gagal' . $e->getMessage() . '');
        }
        // return Redirect::back()->with('Title', 'Upload Logo')->with('Success', 'Upload Logo Sukses dan telah disimpan');
        // Contoh: Proses file atau simpan ke database
        // $data = Excel::toArray([], $file);
        // dd($data);
        // return response()->json(['data' => $file]);
    }
    public function SiswaInKelas(Request $request)
    {


        // dd($request->all(), $KelasTarget, $KelasTarget->id, $KelasTarget->tingkat_id);
        // try {

        DB::beginTransaction();
        // Request untuk melihat kelas_id
        $KelasTarget = Ekelas::where('id', $request->kelas_id)->first();
        // dd($KelasTarget);
        $file = $request->file('datasiswa'); //file : name pada form upload
        $fileName = $file->getClientOriginalName();
        $tempDirectory = public_path('temp/') . $file->getClientOriginalName();
        // Mengecek File eksist
        if (File::exists($tempDirectory)) {
            $pesan = 'exsiting';
            // dd($pesan);
            unlink(public_path('temp/') . $fileName); // Menghapus File dari deirektori sementara
        } else {
            $pesan = 'no exsiting';
            $file->move(public_path('temp/'),  $fileName); //Memindahkan file ke direktori sementara untuk dibaca datanya
        }
        //Membuka data di temp
        $spreadsheet = IOFactory::load('' . public_path('temp/') . $file->getClientOriginalName() . '');
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();
        $dataKe = 1; // Mulai dari baris ke-1 (atau ke-2 kalau ada header)
        // dd($data, $KelasTarget);

        //Mulai cek data
        foreach ($data as $index => $row) {

            if ($index === 0) continue; // Lewati baris judul Excel
            // dd($row);
            $KolomKe = 0;
            // dd(ucwords($row[4]));

            // Ambil data awal untuk pengecekan ganda
            $email = $row[0];
            $nis   = $row[1];
            $nisn  = $row[2];
            $password  = $row[3];

            // Cek apakah email atau NIS/NISN sudah ada

            $emailExists = User::where('email', $email)->exists();
            $nisExists   = Detailsiswa::where('status_siswa', 'aktif')->where('nis', $nis)->orWhere('nisn', $nisn)->exists();
            $duplikatData = []; // Untuk menampung semua data duplikat
            if ($emailExists || $nisExists) {

                $duplikat[] = compact('email', 'nis', 'nisn', 'emailExists', 'nisExists');
                // dd('data duplikat', $email, $nisExists);
                continue; // Skip siswa duplikat
            }

            // ======================
            // 1. Buat akun User
            // ======================
            $nama                       = $row[4]; // 4
            $nama_panggilan             = $row[5]; // 5
            $tingkat_id                 = $KelasTarget->tingkat_id; //$row[$KolomKe++]; // 6
            $tingkat_id_bayangan        = $row[6];
            $UserSave = User::create([
                'email'                 => $email,
                'name'                  => ucwords($nama),
                'tingkat_id'            => $tingkat_id,
                'posisi'                => 'siswa',
                'aktiv'                 => 1,
                'password'              => Hash::make($password),
            ]);
            // $user->nama_panggilan       = $nama_panggilan;
            // $user->kelas_id             = $nama_panggilan;
            $LatesUser = User::orderBy('id', 'desc')->value('id');
            // ======================
            // 2. Buat Detailsiswa
            // ======================
            $KolomKe = 6;
            $CekTapel = Etapel::where('tapel', $row[51])->where('semester', 'I')->value('id');
            $detailsiswa = Detailsiswa::create([
                'user_id' => $LatesUser,
                'status_siswa'           => 'aktif',
                'nama_siswa'             => ucwords(strtolower($row[4])),
                'nama_panggilan'         => ucwords(strtolower($nama_panggilan)),
                'nis'                    => $nis,
                'nisn'                   => $nisn,
                'nik'                    => $row[7] ?? null, // 7 Artinya kolom ke 8
                'nokk'                   => $row[8] ?? null, // 8
                'hobi'                   => $row[9] ?? null, // 9
                'cita_cita'              => ucwords($row[10]) ?? null, // 10
                'jenis_kelamin'          => $row[11] ?? null, // 11
                'tempat_lahir'           => ucwords(strtolower($row[12])) ?? null, // 12
                'tanggal_lahir'          => $row[13] !== null ? format_tanggal_lahir($row[13]) : null, // 13
                'nohp_siswa'             => $row[14] !== null ? format_no_hp($row[14]) : null, // 14
                'agama'                  => $row[15] ?? null, // 15
                'kewarganegaraan'        => ucwords($row[16]) ?? null, // 16
                'anak_ke'                => ucwords($row[17]) ?? null, // 17
                'jml_saudara'            => $row[18] ?? null, // 18
                'jumlah_saudara_tiri'    => $row[19] ?? null, // 19
                'jumlah_saudara_angkat'  => $row[20] ?? null, // 20
                'status_anak'            => $row[21] ?? null, // 21
                'status_yatim_piatu'     => $row[22] ?? null, // 22
                'bahasa'                 => $row[23] ?? null, // 23
                'alamat_siswa'           => $row[24] ?? null, // 24
                'jalan'                  => $row[25] ?? null, // 25
                'rt'                     => strpad($row[26]) ?? null, // 26
                'rw'                     => strpad($row[27]) ?? null, // 27
                'desa'                   => ucwords($row[28]) ?? null, // 28
                'kecamatan'              => ucwords($row[29]) ?? null, // 29
                'kabupaten'              => ucwords($row[30]) ?? null, // 30
                'provinsi'               => ucwords($row[31]) ?? null, // 31
                'kode_pos'               => $row[32] ?? null, // 32
                'tinggal_bersama'        => $row[33] ?? null, // 33
                'jarak_sekolah'          => $row[34] ?? null, // 34            // kesehatan
                'golongan_darah'         => $row[35] ?? null, // 35
                'riwayat_penyakit'       => $row[36] ?? null, // 36
                'kelainan_jasmani'       => $row[37] ?? null, // 37
                'tinggi_badan'           => $row[38] ?? null, // 38
                'berat_badan'            => $row[39] ?? null, // 39
                // // D. Pendidikan
                'namasek_asal'            => $row[40] ?? null, // 40
                'alamatsek_asal'          => $row[41] ?? null, // 41
                'tanggal_ijazah_sd'       => $row[42] !== null ? format_tanggal_lahir($row[42]) : null, // 42
                'nomor_ijazah_sd'         => $row[43] ?? null, // 43
                'lama_belajar'            => $row[44] ?? null, // 44
                'asal_pindahan'           => $row[45] ?? null, // 45
                'alasan_pindahan'         => $row[46] ?? null, // 46
                'kelas_penerimaan'        => $row[47] ?? null, // 47
                'kelompok_penerimaan'     => $row[48] ?? null, // 48
                'jurusan_penerimaan'      => $row[49] ?? null, // 49
                'tanggal_penerimaan'      => $row[50] !== null ? format_tanggal_lahir($row[50]) : null, // 50
                'tahun_masuk'             => $CekTapel ?? null, // 51
                // 'tahun_masuk'             => null, // 51
                'tahun_lulus'             => null,
                // // E. Posisi Kelas
                'tingkat_id'             => $KelasTarget->tingkat_id,
                'kelas_id'               => $KelasTarget->id,
                'jabatan_kelas'          => $row[52] ?? null, // 52
                'piket_kelas'            => $row[53] ?? null, // 53
                'petugas_upacara'        => $row[54] ?? null, // 54

                // // ==== Data Orang Tua / Wali ====
                'ayah_nama'              => ucwords($row[55]) ?? null, // 55
                'ayah_keadaan'           => $row[56] ?? null, // 56
                'ayah_agama'             => $row[57] ?? null, // 57
                'ayah_kewarganegaraan'   => ucwords($row[58]) ?? null, // 58
                'ayah_pendidikan'        => $row[59] ?? null, // 59
                'ayah_pekerjaan'         => ucwords($row[60]) ?? null, // 60
                'ayah_penghasilan'       => $row[61] ?? null, // 61
                'ayah_alamat'            => $row[62] ?? null, // 62
                'ayah_rt'                => strpad($row[63]) ?? null, // 63
                'ayah_rw'                => strpad($row[64]) ?? null, // 64
                'ayah_desa'              => $row[65] ?? null, // 65
                'ayah_kecamatan'         => $row[66] ?? null, // 66
                'ayah_kabupaten'         => $row[67] ?? null, // 67
                'ayah_provinsi'          => $row[68] ?? null, // 68
                'ayah_kodepos'           => $row[69] ?? null, // 69
                'ayah_nohp'              => $row[70] !== null ? format_no_hp($row[70]) : null, // 70

                'ibu_nama'              => ucwords($row[71]) ?? null, // 71
                'ibu_keadaan'           => $row[72] ?? null, // 72
                'ibu_agama'             => $row[73] ?? null, // 73
                'ibu_kewarganegaraan'   => ucwords($row[74]) ?? null, // 74
                'ibu_pendidikan'        => $row[75] ?? null, // 75
                'ibu_pekerjaan'         => ucwords($row[76]) ?? null, // 76
                'ibu_penghasilan'       => $row[77] ?? null, // 77
                'ibu_alamat'            => $row[78] ?? null, // 78
                'ibu_rt'                => strpad($row[79]) ?? null, // 79
                'ibu_rw'                => strpad($row[80]) ?? null, // 80
                'ibu_desa'              => $row[81] ?? null, // 81
                'ibu_kecamatan'         => $row[82] ?? null, // 82
                'ibu_kabupaten'         => $row[83] ?? null, // 83
                'ibu_provinsi'          => $row[84] ?? null, // 84
                'ibu_kodepos'           => $row[85] ?? null, // 85
                'ibu_nohp'              => $row[86] !== null ? format_no_hp($row[86]) : null, // 86


                'wali_nama'              => ucwords($row[87]) ?? null, // 87
                'wali_keadaan'           => $row[88] ?? null, // 88
                'wali_agama'             => $row[89] ?? null, // 89
                'wali_kewarganegaraan'   => ucwords($row[90]) ?? null, // 90
                'wali_pendidikan'        => $row[91] ?? null, // 91
                'wali_pekerjaan'         => ucwords($row[92]) ?? null, // 92
                'wali_penghasilan'       => $row[93] ?? null, // 93
                'wali_alamat'            => $row[94] ?? null, // 94
                'wali_rt'                => strpad($row[95]) ?? null, // 95
                'wali_rw'                => strpad($row[96]) ?? null, // 96
                'wali_desa'              => $row[97] ?? null, // 97
                'wali_kecamatan'         => $row[98] ?? null, // 98
                'wali_kabupaten'         => $row[99] ?? null, // 99
                'wali_provinsi'          => $row[100] ?? null, // 100
                'wali_kodepos'           => $row[101] ?? null, // 101
                'wali_nohp'              => $row[102] ?? null, // 102
            ]);
            // $detail->save();

            // ======================
            // 3. Update user → detailsiswa_id
            // ======================
            $LatestDetail = Detailsiswa::orderBy('id', 'desc')->value('id');
            $UserUpdate = User::updated([
                'detailsiswa_id' => $LatestDetail
            ]);


            // ======================
            // 4. Generate QR NIS (jika ada fungsi)
            // ======================
            if (function_exists('GQrNis')) {
                $qrPath = GQrNis($nis);
            }
            $dataKe++;
            DB::commit(); // Semua berhasil
        }
        // dd($UserSave, $detailsiswa);
        // dd($request->kelas_id);
        unlink(public_path('temp/') . $fileName); // Menghapus File dari deirektori sementara

        HapusCacheDenganTag('DataSiswa');
        return Redirect::back()->with('Title', 'Berhasil')->with('success', 'Data telah diproses');
        // return Redirect::back()->with([
        //     'Title' => 'Berhasil!',
        //     'success' => 'Data telah diproses',
        // ]);
        // return redirect()->back()->with('success', 'Data berhasil disimpan');
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     // dd("❌ Gagal di baris ke-" . ($index + 1), $e->getMessage());
        //     // dd("❌ Gagal di baris ke-" . $dataKe, $e->getMessage());
        //     return redirect()->back()->with('error', 'Gagal tidak dikenali');
        // }
    }
    // public function SiswaInKelas(Request $request)
    // {


    //     // dd($request->all(), $KelasTarget, $KelasTarget->id, $KelasTarget->tingkat_id);
    //     try {

    //         DB::beginTransaction();
    //         // Request untuk melihat kelas_id
    //         $KelasTarget = Ekelas::where('id', $request->kelas_id)->first();
    //         // dd($KelasTarget);
    //         $file = $request->file('datasiswa'); //file : name pada form upload
    //         $fileName = $file->getClientOriginalName();
    //         $tempDirectory = public_path('temp/') . $file->getClientOriginalName();
    //         // Mengecek File eksist
    //         if (File::exists($tempDirectory)) {
    //             $pesan = 'exsiting';
    //             // dd($pesan);
    //             unlink(public_path('temp/') . $fileName); // Menghapus File dari deirektori sementara
    //         } else {
    //             $pesan = 'no exsiting';
    //             $file->move(public_path('temp/'),  $fileName); //Memindahkan file ke direktori sementara untuk dibaca datanya
    //         }
    //         //Membuka data di temp
    //         $spreadsheet = IOFactory::load('' . public_path('temp/') . $file->getClientOriginalName() . '');
    //         $sheet = $spreadsheet->getActiveSheet();
    //         $data = $sheet->toArray();
    //         $dataKe = 1; // Mulai dari baris ke-1 (atau ke-2 kalau ada header)
    //         // dd($data, $KelasTarget);

    //         //Mulai cek data
    //         foreach ($data as $index => $row) {

    //             if ($index === 0) continue; // Lewati baris judul Excel
    //             // dd($row);
    //             $KolomKe = 0;
    //             // dd(ucwords($row[4]));

    //             // Ambil data awal untuk pengecekan ganda
    //             $email = $row[0];
    //             $nis   = $row[1];
    //             $nisn  = $row[2];
    //             $password  = $row[3];

    //             // Cek apakah email atau NIS/NISN sudah ada

    //             $emailExists = User::where('email', $email)->exists();
    //             $nisExists   = Detailsiswa::where('status_siswa', 'aktif')->where('nis', $nis)->orWhere('nisn', $nisn)->exists();
    //             $duplikatData = []; // Untuk menampung semua data duplikat
    //             if ($emailExists || $nisExists) {

    //                 $duplikat[] = compact('email', 'nis', 'nisn', 'emailExists', 'nisExists');
    //                 // dd('data duplikat', $email, $nisExists);
    //                 continue; // Skip siswa duplikat
    //             }

    //             // ======================
    //             // 1. Buat akun User
    //             // ======================
    //             $nama                       = $row[4]; // 4
    //             $nama_panggilan             = $row[5]; // 5
    //             $tingkat_id                 = $KelasTarget->tingkat_id; //$row[$KolomKe++]; // 6
    //             $tingkat_id_bayangan        = $row[6];
    //             $UserSave = User::create([
    //                 'email'                 => $email,
    //                 'name'                  => ucwords($nama),
    //                 'tingkat_id'            => $tingkat_id,
    //                 'posisi'                => 'siswa',
    //                 'aktiv'                 => 1,
    //                 'password'              => Hash::make($password),
    //             ]);
    //             // $user->nama_panggilan       = $nama_panggilan;
    //             // $user->kelas_id             = $nama_panggilan;
    //             $LatesUser = User::orderBy('id', 'desc')->value('id');
    //             // ======================
    //             // 2. Buat Detailsiswa
    //             // ======================
    //             $KolomKe = 6;
    //             $CekTapel = Etapel::where('tapel', $row[51])->where('semester', 'I')->value('id');
    //             $detailsiswa = Detailsiswa::create([
    //                 'user_id' => $LatesUser,
    //                 'status_siswa'           => 'aktif',
    //                 'nama_siswa'             => ucwords($row[4]),
    //                 'nama_panggilan'         => ucwords($nama_panggilan),
    //                 'nis'                    => $nis,
    //                 'nisn'                   => $nisn,
    //                 'nik'                    => $row[7] ?? null, // 7 Artinya kolom ke 8
    //                 'nokk'                   => $row[8] ?? null, // 8
    //                 'hobi'                   => $row[9] ?? null, // 9
    //                 'cita_cita'              => ucwords($row[10]) ?? null, // 10
    //                 'jenis_kelamin'          => $row[11] ?? null, // 11
    //                 'tempat_lahir'           => ucwords($row[12]) ?? null, // 12
    //                 'tanggal_lahir'          => $row[13] !== null ? format_tanggal_lahir($row[13]) : null, // 13
    //                 'nohp_siswa'             => $row[14] !== null ? format_no_hp($row[14]) : null, // 14
    //                 'agama'                  => $row[15] ?? null, // 15
    //                 'kewarganegaraan'        => ucwords($row[16]) ?? null, // 16
    //                 'anak_ke'                => ucwords($row[17]) ?? null, // 17
    //                 'jml_saudara'            => $row[18] ?? null, // 18
    //                 'jumlah_saudara_tiri'    => $row[19] ?? null, // 19
    //                 'jumlah_saudara_angkat'  => $row[20] ?? null, // 20
    //                 'status_anak'            => $row[21] ?? null, // 21
    //                 'status_yatim_piatu'     => $row[22] ?? null, // 22
    //                 'bahasa'                 => $row[23] ?? null, // 23
    //                 'alamat_siswa'           => $row[24] ?? null, // 24
    //                 'jalan'                  => $row[25] ?? null, // 25
    //                 'rt'                     => strpad($row[26]) ?? null, // 26
    //                 'rw'                     => strpad($row[27]) ?? null, // 27
    //                 'desa'                   => ucwords($row[28]) ?? null, // 28
    //                 'kecamatan'              => ucwords($row[29]) ?? null, // 29
    //                 'kabupaten'              => ucwords($row[30]) ?? null, // 30
    //                 'provinsi'               => ucwords($row[31]) ?? null, // 31
    //                 'kode_pos'               => $row[32] ?? null, // 32
    //                 'tinggal_bersama'        => $row[33] ?? null, // 33
    //                 'jarak_sekolah'          => $row[34] ?? null, // 34            // kesehatan
    //                 'golongan_darah'         => $row[35] ?? null, // 35
    //                 'riwayat_penyakit'       => $row[36] ?? null, // 36
    //                 'kelainan_jasmani'       => $row[37] ?? null, // 37
    //                 'tinggi_badan'           => $row[38] ?? null, // 38
    //                 'berat_badan'            => $row[39] ?? null, // 39
    //                 // // D. Pendidikan
    //                 'namasek_asal'            => $row[40] ?? null, // 40
    //                 'alamatsek_asal'          => $row[41] ?? null, // 41
    //                 'tanggal_ijazah_sd'       => $row[42] !== null ? format_tanggal_lahir($row[42]) : null, // 42
    //                 'nomor_ijazah_sd'         => $row[43] ?? null, // 43
    //                 'lama_belajar'            => $row[44] ?? null, // 44
    //                 'asal_pindahan'           => $row[45] ?? null, // 45
    //                 'alasan_pindahan'         => $row[46] ?? null, // 46
    //                 'kelas_penerimaan'        => $row[47] ?? null, // 47
    //                 'kelompok_penerimaan'     => $row[48] ?? null, // 48
    //                 'jurusan_penerimaan'      => $row[49] ?? null, // 49
    //                 'tanggal_penerimaan'      => $row[50] !== null ? format_tanggal_lahir($row[50]) : null, // 50
    //                 'tahun_masuk'             => $CekTapel ?? null, // 51
    //                 // 'tahun_masuk'             => null, // 51
    //                 'tahun_lulus'             => null,
    //                 // // E. Posisi Kelas
    //                 'tingkat_id'             => $KelasTarget->tingkat_id,
    //                 'kelas_id'               => $KelasTarget->id,
    //                 'jabatan_kelas'          => $row[52] ?? null, // 52
    //                 'piket_kelas'            => $row[53] ?? null, // 53
    //                 'petugas_upacara'        => $row[54] ?? null, // 54

    //                 // // ==== Data Orang Tua / Wali ====
    //                 'ayah_nama'              => ucwords($row[55]) ?? null, // 55
    //                 'ayah_keadaan'           => $row[56] ?? null, // 56
    //                 'ayah_agama'             => $row[57] ?? null, // 57
    //                 'ayah_kewarganegaraan'   => ucwords($row[58]) ?? null, // 58
    //                 'ayah_pendidikan'        => $row[59] ?? null, // 59
    //                 'ayah_pekerjaan'         => ucwords($row[60]) ?? null, // 60
    //                 'ayah_penghasilan'       => $row[61] ?? null, // 61
    //                 'ayah_alamat'            => $row[62] ?? null, // 62
    //                 'ayah_rt'                => strpad($row[63]) ?? null, // 63
    //                 'ayah_rw'                => strpad($row[64]) ?? null, // 64
    //                 'ayah_desa'              => $row[65] ?? null, // 65
    //                 'ayah_kecamatan'         => $row[66] ?? null, // 66
    //                 'ayah_kabupaten'         => $row[67] ?? null, // 67
    //                 'ayah_provinsi'          => $row[68] ?? null, // 68
    //                 'ayah_kodepos'           => $row[69] ?? null, // 69
    //                 'ayah_nohp'              => $row[70] !== null ? format_no_hp($row[70]) : null, // 70

    //                 'ibu_nama'              => ucwords($row[71]) ?? null, // 71
    //                 'ibu_keadaan'           => $row[72] ?? null, // 72
    //                 'ibu_agama'             => $row[73] ?? null, // 73
    //                 'ibu_kewarganegaraan'   => ucwords($row[74]) ?? null, // 74
    //                 'ibu_pendidikan'        => $row[75] ?? null, // 75
    //                 'ibu_pekerjaan'         => ucwords($row[76]) ?? null, // 76
    //                 'ibu_penghasilan'       => $row[77] ?? null, // 77
    //                 'ibu_alamat'            => $row[78] ?? null, // 78
    //                 'ibu_rt'                => strpad($row[79]) ?? null, // 79
    //                 'ibu_rw'                => strpad($row[80]) ?? null, // 80
    //                 'ibu_desa'              => $row[81] ?? null, // 81
    //                 'ibu_kecamatan'         => $row[82] ?? null, // 82
    //                 'ibu_kabupaten'         => $row[83] ?? null, // 83
    //                 'ibu_provinsi'          => $row[84] ?? null, // 84
    //                 'ibu_kodepos'           => $row[85] ?? null, // 85
    //                 'ibu_nohp'              => $row[86] !== null ? format_no_hp($row[86]) : null, // 86


    //                 'wali_nama'              => ucwords($row[87]) ?? null, // 87
    //                 'wali_keadaan'           => $row[88] ?? null, // 88
    //                 'wali_agama'             => $row[89] ?? null, // 89
    //                 'wali_kewarganegaraan'   => ucwords($row[90]) ?? null, // 90
    //                 'wali_pendidikan'        => $row[91] ?? null, // 91
    //                 'wali_pekerjaan'         => ucwords($row[92]) ?? null, // 92
    //                 'wali_penghasilan'       => $row[93] ?? null, // 93
    //                 'wali_alamat'            => $row[94] ?? null, // 94
    //                 'wali_rt'                => strpad($row[95]) ?? null, // 95
    //                 'wali_rw'                => strpad($row[96]) ?? null, // 96
    //                 'wali_desa'              => $row[97] ?? null, // 97
    //                 'wali_kecamatan'         => $row[98] ?? null, // 98
    //                 'wali_kabupaten'         => $row[99] ?? null, // 99
    //                 'wali_provinsi'          => $row[100] ?? null, // 100
    //                 'wali_kodepos'           => $row[101] ?? null, // 101
    //                 'wali_nohp'              => $row[102] ?? null, // 102
    //             ]);
    //             // $detail->save();

    //             // ======================
    //             // 3. Update user → detailsiswa_id
    //             // ======================
    //             $LatestDetail = Detailsiswa::orderBy('id', 'desc')->value('id');
    //             $UserUpdate = User::updated([
    //                 'detailsiswa_id' => $LatestDetail
    //             ]);


    //             // ======================
    //             // 4. Generate QR NIS (jika ada fungsi)
    //             // ======================
    //             if (function_exists('GQrNis')) {
    //                 $qrPath = GQrNis($nis);
    //             }
    //             $dataKe++;
    //             DB::commit(); // Semua berhasil
    //         }
    //         // dd($UserSave, $detailsiswa);
    //         // dd($request->kelas_id);
    //         unlink(public_path('temp/') . $fileName); // Menghapus File dari deirektori sementara
    //         return Redirect::back()->with('Title', 'Berhasil')->with('success', 'Data telah diproses');
    //         // return Redirect::back()->with([
    //         //     'Title' => 'Berhasil!',
    //         //     'success' => 'Data telah diproses',
    //         // ]);
    //         // return redirect()->back()->with('success', 'Data berhasil disimpan');
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         // dd("❌ Gagal di baris ke-" . ($index + 1), $e->getMessage());
    //         // dd("❌ Gagal di baris ke-" . $dataKe, $e->getMessage());
    //         return redirect()->back()->with('error', 'Gagal tidak dikenali');
    //     }
    // }
    public function upload_materi(Request $request)
    {
        dd($request->all());
    }
    public function UploadGuru(Request $request)
    {
        DB::beginTransaction();
        $file = $request->file('data_guru');
        if (!$file) {
            return response()->json(['error' => 'File tidak ditemukan.'], 400);
        }

        $dataResult = UploadDataExcel($file);

        if (!$dataResult['success']) {
            return response()->json(['error' => $dataResult['message']], 400);
        }

        $data = $dataResult['data'];
        $sukses = 0;
        $gagal = 0;

        foreach ($data as $index => $row) {
            if ($index === 0) continue; // Lewati header
            try {
                User::create([
                    'email'                => $row[0],
                    'name'                 => $row[0],
                    'posisi'               => $row[0],
                    'aktiv'                => 1,
                    'password'                => Hash::make($row[0]),
                ]);
                Detailguru::create([
                    'tapel_id'              => $row[0],
                    'nama_siswa'            => $row[0],
                    'asal_sekolah'          => $row[1],
                    'nomor_hp'              => $row[2],
                    'tempat_lahir'          => $row[3],
                    'tanggal_lahir'         => $row[4],
                    'jenis_kelamin'         => $row[5],
                ]);

                $sukses++;
            } catch (\Throwable $e) {
                $gagal++;
                // Optional: log error atau masukkan ke report gagal
            }
        }
        DB::commit(); // Semua berhasil
        return response()->json([
            'message' => 'Import selesai.',
            'sukses' => $sukses,
            'gagal'  => $gagal
        ]);
    }
    // Usahakan ini terhubung dengan pembuatan kartu NISN
    public function UploadTargetSosialisasi(Request $request)
    {
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $file = $request->file('data_siswa');

        if (!$file) {
            return response()->json(['error' => 'File tidak ditemukan.'], 400);
        }

        $dataResult = UploadDataExcel($file);

        if (!$dataResult['success']) {
            return response()->json(['error' => $dataResult['message']], 400);
        }

        $data = $dataResult['data'];
        $sukses = 0;
        $gagal = 0;

        foreach ($data as $index => $row) {
            if ($index === 0) continue; // Lewati header
            try {
                DataSiswaTarget::create([
                    'tapel_id'              => $etapels->id,
                    'nama_siswa'            => $row[0],
                    'asal_sekolah'          => $row[1],
                    'nomor_hp'              => $row[2],
                    'tempat_lahir'          => $row[3],
                    'tanggal_lahir'         => $row[4],
                    'jenis_kelamin'         => $row[5],
                ]);

                $sukses++;
            } catch (\Throwable $e) {
                $gagal++;
                // Optional: log error atau masukkan ke report gagal
            }
        }

        return response()->json([
            'message' => 'Import selesai.',
            'sukses' => $sukses,
            'gagal'  => $gagal
        ]);
    }
}
