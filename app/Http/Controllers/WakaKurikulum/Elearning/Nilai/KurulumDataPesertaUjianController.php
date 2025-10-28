<?php

namespace App\Http\Controllers\WakaKurikulum\Elearning\Nilai;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\Elearning\Nilai;
use App\Models\WakaKurikulum\Elearning\Nilai\KurulumDataPesertaUjian;

class KurulumDataPesertaUjianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view role.waka.kurikulum.nilai.data-peserta-ujian
php artisan make:view role.waka.kurikulum.nilai.data-peserta-ujian-single
php artisan make:seeder WakaKurikulum/Elearning/Nilai/KurulumDataPesertaUjianSeeder
php artisan make:model WakaKurikulum/Elearning/Nilai/KurulumDataPesertaUjian
php artisan make:controller WakaKurikulum/Elearning/Nilai/KurulumDataPesertaUjianController --resource

App\Http\Controllers\WakaKurikulum$Folder$namaController


php artisan make:migration WakaKurulumMigration_PesertaUjian




*/
    /*
    KurulumDataPesertaUjian
    $wakapesertaujuan
    role.waka.kurikulum.nilai
    role.waka.kurikulum.nilai.data-peserta-ujian
    role.waka.kurikulum.nilai.blade_show
    Index = Data Peserta Ujian
    Breadcume Index = 'Waka Kurikulum / Data Peserta Ujian';
    Single = Data Peserta Ujian
    php artisan make:view role.waka.kurikulum.nilai.data-peserta-ujian
    php artisan make:view role.waka.kurikulum.nilai.data-peserta-ujian-single
    php artisan make:seed KurulumDataPesertaUjianSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Peserta Ujian';
        $arr_ths = [
            'Nomor Ujian',
            'Ruang',
            'Nama Siswa',
        ];
        $breadcrumb = 'Waka Kurikulum / Data Peserta Ujian';
        $titleviewModal = 'Lihat Data Peserta Ujian';
        $titleeditModal = 'Edit Data Peserta Ujian';
        $titlecreateModal = 'Create Data Peserta Ujian';
        $datas = KurulumDataPesertaUjian::get();
        //KurulumDataPesertaUjian


        return view('role.waka.kurikulum.nilai.data-peserta-ujian', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.waka.kurikulum.nilai.data-peserta-ujian

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Peserta Ujian';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kurikulum / Data Peserta Ujian';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = KurulumDataPesertaUjian::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.nilai.data-peserta-ujian-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.kurikulum.nilai.data-peserta-ujian-single
    }

    public function store(Request $request)
    {
        // Ambil Tahun Pelajaran Aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        if (!$etapels) {
            return redirect()->back()->with('error', 'Tidak ada tahun pelajaran aktif!');
        }

        // Tambahkan `tapel_id` ke request
        $request->merge(['tapel_id' => $etapels->id]);

        // Validasi request
        $validator = Validator::make($request->all(), [
            'tapel_id'      => 'required|integer',
            'jenjang'       => 'required|string',
            'kode_provinsi' => 'required|string',
            'kode_kabupaten' => 'required|string',
            'kode_sekolah'  => 'required|string',
            'digit_siswa'   => 'required|string|regex:/^\d{1,9}$/', // String angka maksimal 9 digit
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ambil data siswa yang akan diberi nomor ujian
        $siswas = Detailsiswa::where('tingkat_id', 9)
            ->orderBy('kelas_id', 'ASC')
            ->orderBy('nama_siswa', 'ASC')
            ->get();

        if ($siswas->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada siswa yang ditemukan!');
        }

        // Ambil 2 digit terakhir dari tahun ini
        $tahunLulus = date('y');

        // Ambil data dari request
        $jenjang       = $request->jenjang;
        $kodeProvinsi  = $request->kode_provinsi;
        $kodeKabupaten = $request->kode_kabupaten;
        $kodeSekolah   = $request->kode_sekolah;
        $digitSiswa    = (int) $request->digit_siswa; // Pastikan integer
        $maxDigit      = 9; // Maksimal 9 digit

        // Inisialisasi nomor urut
        $counter = 1;
        $nomorRuangan = 1; // Nomor ruangan pertama

        // **Buat format kode untuk setiap siswa**
        $siswas->chunk(20)->each(function ($chunkSiswa) use (&$counter, &$digitSiswa, $maxDigit, &$nomorRuangan, $etapels, $jenjang, $tahunLulus, $kodeProvinsi, $kodeKabupaten, $kodeSekolah) {
            foreach ($chunkSiswa as $siswa) {
                // Nomor urut selalu 3 digit (001, 002, 003, dst)
                $nomorUrut = str_pad($counter, 3, '0', STR_PAD_LEFT);

                // Format kode
                $formatKode = "{$jenjang} - {$tahunLulus} - {$kodeProvinsi} - {$kodeKabupaten} - {$kodeSekolah} - {$nomorUrut} - {$digitSiswa}";

                // Cek apakah sudah ada data untuk siswa ini
                $cekDuplikasi = DB::table('enilai_ujian_peserta')
                    ->where('detailsiswa_id', $siswa->id)
                    ->where('tapel_id', $etapels->id)
                    ->exists();

                if (!$cekDuplikasi) {
                    // Simpan data ke database
                    DB::table('enilai_ujian_peserta')->insert([
                        'tapel_id'      => $etapels->id,
                        'nomor_ujian'   => $formatKode,
                        'nomor_ruangan' => $nomorRuangan,
                        'detailsiswa_id' => $siswa->id,
                        'kelas_id'      => $siswa->kelas_id,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);
                }

                $counter++; // **Nomor urut tetap naik**

                // 🔄 **Digit siswa berubah dari 2-9, lalu kembali ke 2**
                $digitSiswa = ($digitSiswa >= 9) ? 1 : $digitSiswa + 1;
            }

            // Setelah 20 siswa, nomor ruangan bertambah
            $nomorRuangan++;
        });



        // Beri notifikasi sukses
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }



    public function update(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'detailsiswa_id'   => 'required|array',
            'detailsiswa_id.*' => 'integer', // Pastikan setiap ID adalah integer
            'nomor_ruangan'    => 'required|integer',
        ]);
        // 🚀 Jalankan update nomor ruangan
        KurulumDataPesertaUjian::whereIn('id', $request->detailsiswa_id)
            ->update(['nomor_ruangan' => $request->nomor_ruangan]);
        return redirect()->back()->with('success', 'Nomor ruangan berhasil diperbarui!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //KurulumDataPesertaUjian
        // dd($id);
        // dd($request->all());
        $data = KurulumDataPesertaUjian::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
    public function updateBatch(Request $request)
    {
        // Validasi data
        $request->validate([
            'detailsiswa_id'   => 'required|array',
            'detailsiswa_id.*' => 'integer|exists:enilai_ujian_peserta,detailsiswa_id',
            'nomor_ruangan'    => 'required|integer',
        ]);

        // Update nomor ruangan untuk semua siswa yang dipilih
        DB::table('enilai_ujian_peserta')
            ->whereIn('detailsiswa_id', $request->detailsiswa_id)
            ->update(['nomor_ruangan' => $request->nomor_ruangan]);

        return redirect()->back()->with('success', 'Nomor ruangan berhasil diperbarui!');
    }
    public function HapusSemuaPeserta()
    {
        $etapels = Etapel::where('aktiv', 'Y')->first();

        if (!$etapels) {
            return Redirect::back()->with('error', 'Tidak ada tahun pelajaran aktif!');
        }

        // Hapus semua peserta berdasarkan tapel_id
        KurulumDataPesertaUjian::where('tapel_id', $etapels->id)->delete();

        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Semua Data Berhasil Dihapus');
    }
}
