<?php

namespace App\Http\Controllers\User\Siswa;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Elist;
use App\Models\Emengajar;
use App\Models\EnilaiTugas;
use Faker\Factory as Faker;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Absensi\Eabsen;
use App\Models\Admin\Identitas;
use App\Models\Learning\Enilai;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\Learning\Jurnalmengajar;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Types\Null_;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DetailsiswaController extends Controller
{
    //
    public function index(User $user)
    {
        $arr_ths = [
            'Nama',
            'NIS',
            'Kelas',
            'Jenis Kelamin',
            'No HP',
            'No HP Ayah',
            'No HP Ibu',
            'Alamat',
        ];

        $title = 'Data Siswa';
        $breadcrumb = "Data User / Data Siswa";
        $DataSiswa = Cache::tags(['Cache_DataSiswa'])->remember('Remember_DataSiswa', now()->addMinutes(10), function () {
            return Detailsiswa::With('KelasOne.Guru')->whereNotNull('kelas_id')->orderBy('kelas_id', 'ASC')->get();
        });
        $titleviewModal = 'Lihat Data Siswa';
        $titleeditModal = 'Edit Data Siswa';
        $titlecreateModal = 'Create Data Siswa';
        $DataList = Cache::tags(['Chace_DataList'])->remember('remember_DataList', now()->addHours(2), function () {
            return Elist::get();
        });
        return view('admin.user.siswa', compact(
            'title',
            'DataSiswa',
            'breadcrumb',
            'arr_ths',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DataList',
        ));
    }
    public function update($id, Request $request)
    {
        try {
            $data = $request->except(['_token', '_method']);
            $data = Detailsiswa::find($id);
            $data->nama_siswa = $request->nama_siswa;
            $data->nis = $request->nis;
            $data->nisn = $request->nisn;
            $data->nik = $request->nik;
            $data->nokk = $request->nokk;
            $data->hobi = $request->hobi;
            $data->cita_cita = $request->cita_cita;
            $data->tahun_masuk = $request->tahun_masuk;
            $data->tahun_lulus = $request->tahun_lulus;
            $data->agama = $request->agama;
            $data->nohp_siswa = $request->nohp_siswa;
            $data->jml_saudara = $request->jml_saudara;
            $data->jenis_kelamin = $request->jenis_kelamin;
            $data->anak_ke = $request->anak_ke;
            $data->status_anak = $request->status_anak;
            $data->tempat_lahir = $request->tempat_lahir;
            $data->tanggal_lahir = $request->tanggal_lahir;
            //Data Alamat
            $data->rt = $request->rt;
            $data->rw = $request->rw;
            $data->desa = $request->desa;
            $data->kecamatan = $request->kecamatan;
            $data->kabupaten = $request->kabupaten;
            $data->provinsi = $request->provinsi;
            $data->jalan = $request->jalan;
            //Data Kelas
            $data->jabatan_kelas = $request->jabatan_kelas;
            $data->piket_kelas = $request->piket_kelas;
            $data->petugas_upacara = $request->petugas_upacara;
            //Data Sekolah Asal
            $data->namasek_asal = $request->namasek_asal;
            $data->alamatsek_asal = $request->alamatsek_asal;
            //Data Ayah
            $data->nama_ayah = $request->nama_ayah;
            $data->pekerjaan_ayah = $request->pekerjaan_ayah;
            $data->penghasilan_ayah = $request->penghasilan_ayah;
            $data->nohp_ayah = $request->nohp_ayah;
            $data->alamat_ayah = $request->alamat_ayah;
            //Data Ibu
            $data->nama_ibu = $request->nama_ibu;
            $data->pekerjaan_ibu = $request->pekerjaan_ibu;
            $data->penghasilan_ibu = $request->penghasilan_ibu;
            $data->nohp_ibu = $request->nohp_ibu;
            $data->alamat_ibu = $request->alamat_ibu;
            //Data Wali
            $data->nama_wali = $request->nama_wali;
            $data->pekerjaan_wali = $request->pekerjaan_wali;
            $data->penghasilan_wali = $request->penghasilan_wali;
            $data->nohp_wali = $request->nohp_wali;
            $data->alamat_wali = $request->alamat_wali;
            $data->update();
            $data = Detailsiswa::find($id);
            HapusCacheDenganTag('Chace_DataList');

            return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  berhasil diperbaharui');
        } catch (Exception $e) {
            // Tindakan jika terjadi exception
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }
    public function destroy($data)
    {
        // try {
        $VarDetailsiswa = User::findOrFail($data);
        $VarDetailsiswa->delete();
        HapusCacheDenganTag('Chace_DataList');
        HapusCacheDenganTag('Cache_DataSiswa');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
    }
    public function store(Request $request)
    {
        $faker = Faker::create();
        try {
            // dd($request->all());

            $data = $request->except(['_token', '_method']);
            $datauser = new User();
            $datauser->posisi = 'Siswa';
            $datauser->aktiv = 'Y';
            $datauser->name = $request->nama_siswa;
            $datauser->email = $faker->unique()->safeEmail;
            $datauser->password = Hash::make('Password');
            $datauser->detailsiswa_id = Null;
            $datauser->tingkat_id = 7;
            $datauser->kelas_id = 4;
            $datauser->save();
            // sleep(5);
            $cekuserAkhir = User::select('id')->pluck('id')->max();
            $data = new Detailsiswa();
            $data->user_id = $cekuserAkhir;
            $data->status_siswa = $request->status_siswa;
            $data->nama_siswa = $request->nama_siswa;
            $data->nis = $request->nis;
            $data->nisn = $request->nisn;
            $data->nokk = $request->nokk;
            $data->hobi = $request->hobi;
            $data->cita_cita = $request->cita_cita;

            $data->agama = $request->agama;
            $data->nohp_siswa = $request->nohp_siswa;
            $data->jml_saudara = $request->jml_saudara;
            $data->jenis_kelamin = $request->jenis_kelamin;
            $data->anak_ke = $request->anak_ke;
            $data->status_anak = $request->status_anak;
            $data->tempat_lahir = $request->tempat_lahir;
            $data->tanggal_lahir = $request->tanggal_lahir;
            // Data Alamat
            $data->rt = $request->rt;
            $data->rw = $request->rw;
            $data->desa = $request->desa;
            $data->kecamatan = $request->kecamatan;
            $data->provinsi = $request->provinsi;  //Relasi Elist
            $data->jalan = $request->jalan;
            //Data Kelas
            $datauser->kelas_id = 4;
            $data->jabatan_kelas = $request->jabatan_kelas;
            $data->piket_kelas = $request->piket_kelas;
            $data->petugas_upacara = $request->petugas_upacara;
            //Data Sekolah Asal
            $data->namasek_asal = $request->namasek_asal;
            $data->alamatsek_asal = $request->alamatsek_asal;
            //Data Ayah
            $data->nama_ayah = $request->nama_ayah;
            $data->pekerjaan_ayah = $request->pekerjaan_ayah;
            $data->penghasilan_ayah = $request->penghasilan_ayah;
            $data->nohp_ayah = $request->nohp_ayah;
            $data->alamat_ayah = $request->alamat_ayah;
            //Data Ibu
            $data->nama_ibu = $request->nama_ibu;
            $data->pekerjaan_ibu = $request->pekerjaan_ibu;
            $data->penghasilan_ibu = $request->penghasilan_ibu;
            $data->nohp_ibu = $request->nohp_ibu;
            $data->alamat_ibu = $request->alamat_ibu;
            //Data Wali
            $data->nama_wali = $request->nama_wali;
            $data->pekerjaan_wali = $request->pekerjaan_wali;
            $data->penghasilan_wali = $request->penghasilan_wali;
            $data->nohp_wali = $request->nohp_wali;
            $data->alamat_wali = $request->alamat_wali;
            $data->save();
            //Generate QRCode
            $path = public_path('/img/qrcode_siswa/' . $data->nis . '.png'); // Tentukan path penyimpanan
            QrCode::size(300)->format('png')->generate($data->nis, $path);
            //Update detailsiswa_id di user
            $DetailuserAkhir = Detailsiswa::select('id')->pluck('id')->max();
            $user = User::findOrFail($cekuserAkhir);
            $user->detailsiswa_id = $DetailuserAkhir;
            $user->update();
            HapusCacheDenganTag('Chace_DataList');
        } catch (Exception $e) {
            // Tindakan jika terjadi exception
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }
    public function SiswaCetak($id)
    {
        $data = Detailsiswa::find($id);
        $title = 'Edit Data';
        $breadcrumb = "Data Siswa / Detail Siswa";
        return view('admin.user.siswa-cetak', compact(
            'title',
            'data',
            'breadcrumb',
        ));
    }
    public function edit($id)
    {
        $data = Detailsiswa::With('KelasOne', 'DetailsiswaToElistsJabatanKelas', 'DetailsiswaToElistsPiketKelas', 'DetailsiswaToElistsPetugasUpacaraKelas')->find($id);
        $title = 'Edit Data';
        $breadcrumb = "Data Siswa / Detail Siswa";
        HapusCacheDenganTag('Chace_DataList');
        return view('admin.user.siswa-edit', compact(
            'title',
            'data',
            'breadcrumb',
        ));
    }
    //Ajax
    public function getSiswa($id)
    {
        $siswa = \App\Models\User\Siswa\Detailsiswa::with('Detailsiswatokelas')->find($id);
        return response()->json($siswa);
    }

    public function getByNis(Request $request)
    {
        $nis = $request->input('nis');

        $siswa = Detailsiswa::with('KelasOne')->where('nis', $nis)->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.'
            ]);
        }
        $tanggal_lahir = Carbon::create($siswa->tanggal_lahir)->toDateString();
        // hasil: "2025-09-27"
        $wali_kelas = ($siswa->KelasOne->Guru->jenis_kelamin === 'Perempuan' ? 'Ibu' : 'Bapak') . "." . $siswa->KelasOne->Guru->nama_guru . "," . $siswa->KelasOne->Guru->gelar;
        $alamat_siswa =
            "Rt " . ($siswa->rt ?? '-')
            . ", Rw " . ($siswa->rw ?? '-')
            . ",<br> Desa " . ($siswa->desa ?? '')
            . ",<br> Kecamatan " . ($siswa->kecamatan ?? '-')
            . ",<br> Kode Pos " . ($siswa->kode_pos ?? '-');
        $alamat_siswa =
            "Rt " . ($siswa->rt ?? '-')
            . ", Rw " . ($siswa->rw ?? '-')
            . ",<br> " . ($siswa->desa ?? '')
            . " - " . ($siswa->kecamatan ?? '-')
            . ", " . ($siswa->kode_pos ?? '-');

        return response()->json([
            'success' => true,
            'data' => [
                'id'        => $siswa->id,
                'nama_siswa'        => $siswa->nama_siswa,
                'nis'               => $siswa->nis,
                'nisn'               => $siswa->nisn,
                'desa'               => $siswa->desa,
                'kelas'             => $siswa->kelas->kelas ?? '-',
                'alamat'            => $alamat_siswa, // ✅ ini yang kurang!
                'nohpayah'          => $siswa->ayah_nohp ?? '-',
                'nohpibu'           => $siswa->ibu_nohp ?? '-',
                'tempat_lahir'      => $siswa->tempat_lahir ?? '-',
                'tanggal_lahir'     => $tanggal_lahir ?? '-',
                'wali_kelas'        => $wali_kelas ?? '-',
                'rt'        => $siswa->rt ?? '-',
                'rw'        => $siswa->rw ?? '-',
                'tanggal_lahir_pretty' => Carbon::parse($siswa->tanggal_lahir)->translatedFormat('l, d F Y'),
            ]
        ]);
    }
    public function ubahDataKarpel(Request $request)
    {
        // dd($request->all());
        $data = Detailsiswa::find($request->id);
        $data->nama_siswa = $request->nama_siswa;
        $data->nis = $request->nis;
        $data->nisn = $request->nisn;
        $data->rt = $request->rt;
        $data->rw = $request->rw;
        $data->desa = $request->desa;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tanggal_lahir = $request->tanggal_lahir;
        $data->update();
        return Redirect::back()->with('Title', 'Sukses')->with('Success', 'Data Telah Di Perbaharui');
    }
}
