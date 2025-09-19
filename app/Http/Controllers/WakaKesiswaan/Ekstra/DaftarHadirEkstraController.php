<?php

namespace App\Http\Controllers\WakaKesiswaan\Ekstra;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKesiswaan\Ekstra\Ekstra;
use App\Models\WakaKesiswaan\Ekstra\PesertaEkstra;
use App\Models\WakaKesiswaan\Ekstra\RiwayatEkstra;
use Illuminate\Support\Facades\Auth; // Import Auth
use App\Models\WakaKesiswaan\Ekstra\DaftarHadirEkstra;

// use App\Models\WakaKesiswaan\Ekstra\DaftarHadirEkstra;

class DaftarHadirEkstraController extends Controller
{
    /*
    DaftarHadirEkstra
    $daftarhadirekstra
    role.pembina.ekstra.
    role.pembina.ekstra.daftar-hadir-ekstra
    */
    // public function index()
    // {
    //     //
    //     //Title to Controller
    //     $title = 'Daftar Hadir Ekstra';
    //     $arr_ths = [
    //         'NIS',
    //         'Nama Siswa',
    //         'Jumlah Hadir',
    //         'title_tabelad'
    //     ];
    //     $breadcrumb = 'Pembina Ekstra / Daftar Hadir';
    //     $titleviewModal = 'Lihat Data Daftar Hadir Ekstra';
    //     $titleeditModal = 'Edit Data Daftar Hadir Ekstra';
    //     $titlecreateModal = 'Create Data Daftar Hadir Ekstra';
    //     $datas = DaftarHadirEkstra::get();


    //     //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
    //     return view('role.pembina.ekstra.daftar-hadir-ekstra', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    // }
    public function index(Ekstra $Ekstra)
    {
        $title = 'Data Hadir Ekstra';
        $arr_ths = [
            'Ekstra',
            'Pembina',
            'Pelatih',
            'Jadwal Latihan',
            'Anggota',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = RiwayatEkstra::where('tapel_id', $etapels->id)->get();
        $breadcrumb = 'Data Admin / Data Hadir Ekstra';
        $titleviewModal = 'Lihat Data Hadir Ekstra';
        $titleeditModal = 'Edit Data Hadir Ekstra';
        $titlecreateModal = 'Buat Data Hadir Ekstra';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $dataEkstra = RiwayatEkstra::where('tapel_id', $etapels->id)->get();
        return view('role.pembina.ekstra.daftar-hadir-ekstra', compact(
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
    }
    //php artisan make:view role.pembina.ekstra.nilai-ekstra
    public function store(Request $request)
    {
        //
        // dd($request->detailsiswa_id);
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();

        $request->merge([
            'tapel_id' => $etapels->id,
            'tanggal_absen' => now(),
            // 'semester' => $etapels->semester,
            // 'kelas_id' => $kelas->id,
            // 'tingkat_id' => $kelas->tingkat_id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            // 'tingkat_id'      => 'nullable|integer',
            'tapel_id'        => 'nullable|integer',
            'ekstra_id'       => 'nullable|integer',
            'detailsiswa_id'  => 'required|array', // Wajib array
            'detailsiswa_id.*' => 'integer', // Setiap item dalam array harus angka dan ada di tabel siswa
            'tanggal_absen'   => 'nullable|date',
            'absensi'   => 'nullable|string',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan data untuk setiap siswa
        foreach ($request->detailsiswa_id as $siswa_id) {
            // $kelas = Ekelas::where('kelas', $request->kelas)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->first();
            $tingkat_siswa = Detailsiswa::with('Detailsiswatokelas')->find($siswa_id);
            // dd($tingkat_siswa);
            DaftarHadirEkstra::create([
                'tingkat_id'      => $tingkat_siswa->Detailsiswatokelas->id,
                'tapel_id'        => $request->tapel_id,
                'ekstra_id'       => $request->ekstra_id,
                'detailsiswa_id'  => $siswa_id,
                'tanggal_absen'   => $request->tanggal_absen,
                'absensi'   => 'Hadir',
            ]);
        }

        // dd($request->all());
        Session::flash('success', 'Data Berhasil Ditambahkan');
        return Redirect::back();
    }
    public function update($id, Request $request, DaftarHadirEkstra $daftarhadirekstra)
    {
        //

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            // data_field_validator
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Menyimpan data menggunakan mass assignment
        // Create : Buat
        // Update : Memperbaharui
        // Menyimpan data menggunakan mass assignment
        $varmodel = DaftarHadirEkstra::find($id); // Pastikan $id didefinisikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($validator->validated());
            return Redirect::back()->with('Title', 'Berhasil')->with('success', 'Data Berhasil di Update');
        } else {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Data tidak ditemukan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //ClassName
        // dd(id);
        // dd(request->all());
        $data = DaftarHadirEkstra::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
    public function show(DaftarHadirEkstra $daftar_hadir_ekstrakurikuler)
    {
        $title = 'Daftar Hadir Ekstra';
        $arr_ths = [
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Jumlah Hadir',
            'Persentasi Kehadiran'
        ];

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Pembina Ekstra / Daftar Hadir';
        $titleviewModal = 'Lihat Data Daftar Hadir Ekstra';
        $titleeditModal = 'Edit Data Daftar Hadir Ekstra';
        $titlecreateModal = 'Create Data Daftar Hadir Ekstra';

        // Cari peserta berdasarkan ekstra_id yang sudah diterima dari route
        $datas = PesertaEkstra::with('Kelas')
            ->where('tapel_id', $etapels->id)
            ->where('ekstra_id', $daftar_hadir_ekstrakurikuler->id)
            ->orderBy('kelas_id', 'ASC')
            ->get();

        // Cari data anggota ekstra berdasarkan tingkat
        $anggotaekstra_vii = PesertaEkstra::where([
            'tingkat_id' => 7,
            'tapel_id' => $etapels->id,
            'ekstra_id' => $daftar_hadir_ekstrakurikuler->id
        ])->get();

        $anggotaekstra_viii = PesertaEkstra::where([
            'tingkat_id' => 8,
            'tapel_id' => $etapels->id,
            'ekstra_id' => $daftar_hadir_ekstrakurikuler->id
        ])->get();

        $anggotaekstra_ix = PesertaEkstra::where([
            'tingkat_id' => 9,
            'tapel_id' => $etapels->id,
            'ekstra_id' => $daftar_hadir_ekstrakurikuler->id
        ])->get();

        // Cari data ekstra
        $Ekstra_name = RiwayatEkstra::with('Ekstra')
            ->where('tapel_id', $etapels->id)
            ->where('id', $daftar_hadir_ekstrakurikuler->id)
            ->first();

        // Jika data ekstra tidak ditemukan
        if (!$Ekstra_name) {
            Session::flash('error', 'Data tidak ditemukan');
            return redirect()->back();
        }

        return view('role.pembina.ekstra.daftar-hadir-ekstra-single', compact(
            'datas',
            'etapels',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'anggotaekstra_vii',
            'anggotaekstra_viii',
            'anggotaekstra_ix',
            'Ekstra_name',
        ));
    }
}
