<?php

namespace App\Http\Controllers\WakaKesiswaan\PPDB;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKesiswaan\PPDB\RiwayatPendaftaranPPDB;

class RiwayatPendaftaranPPDBController extends Controller
{
    /*
    RiwayatPendaftaranPPDB
    $riwayatPendaftaran
    role.waka.kesiswaan.ppdb
    role.waka.kesiswaan.ppdbriwayat-ppdb
    role.waka.kesiswaan.ppdbriwayat-ppdb-single
    php artisan make:view role.ppdb.riwayat-ppdb
    php artisan make:view role.ppdb.riwayat-ppdb-single
    php artisan make:seed RiwayatPendaftaranPPDBSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Pantian PPDB';
        $arr_ths = [
            'Tahun Pelajaran',
            'No Penfatar',
            'Status',
            'Nama',
            'Asal Sekola',
        ];
        $breadcrumb = 'Panitan PPDB / Riwayat PPDB';
        $titleviewModal = 'Lihat Data Pantian PPDB';
        $titleeditModal = 'Edit Data Pantian PPDB';
        $titlecreateModal = 'Create Data Pantian PPDB';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        $dataRiwayat = Cache::tags(['cache_dataRiwayat'])->remember('remember_dataRiwayat', now()->addMinutes(10), function (){
            return RiwayatPendaftaranPPDB::orderBy('tapel_id', 'DESC')->orderBy('nomor_peserta', 'ASC')->get();
        });

        // $datas_old =
        $datas_old = Cache::tags(['cache_datas_old'])->remember('remember_datas_old', now()->addMinutes(10), function () {
            return RiwayatPendaftaranPPDB::select(
                'tapel_id',
                DB::raw("SUM(CASE WHEN status_penerimaan = 'Diterima' THEN 1 ELSE 0 END) as jumlah_diterima"),
                DB::raw("SUM(CASE WHEN status_penerimaan = 'Ditolak' THEN 1 ELSE 0 END) as jumlah_ditolak"),
                DB::raw("SUM(CASE WHEN status_penerimaan = 'Menunggu' THEN 1 ELSE 0 END) as jumlah_pending"),
                DB::raw("COUNT(*) as total_pendaftar") // Menghitung total pendaftar per tapel_id
            )
                ->groupBy('tapel_id')
                ->orderBy('tapel_id', 'DESC')
                ->get();
        });
        // HapusCacheDenganTag('datas_old');
        // HapusCacheDenganTag('dataRiwayat');

        $riwayat = new RiwayatPendaftaranPPDB();
        $trenData = $riwayat->tren_penerimaan;

        $data_sekolah = RiwayatPendaftaranPPDB::getPivotData();
        $riwayat = new RiwayatPendaftaranPPDB();
        $trenData = $riwayat->tren_penerimaan;

        // Ambil data tahun akademik dari model Etapel
        $etapels = Etapel::whereIn('id', array_keys($trenData))->get()->keyBy('id');

        // Tambahkan label tahun akademik ke dalam trenData
        foreach ($trenData as $tahun => $data) {
            $trenData[$tahun]['tapel'] = $etapels[$tahun]->tapel ?? 'Tahun Tidak Ditemukan';
        }


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.ppdb.riwayat-ppdb', compact(
            'dataRiwayat',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'datas_old',
            'trenData',
            'data_sekolah',
        ));

        //php artisan make:view role.ppdb.riwayat-ppdb

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Pantian PPDB';
        $arr_ths = [
            'No Penfatar',
            'Nama',
            'Asal Sekola',
            'Status',
        ];
        $breadcrumb = 'Panitan PPDB / Riwayat PPDB';
        $titleviewModal = 'Lihat Data Pantian PPDB';
        $titleeditModal = 'Edit Data Pantian PPDB';
        $titlecreateModal = 'Create Data Pantian PPDB';
        $datas = RiwayatPendaftaranPPDB::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.ppdb.riwayat-ppdb-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.ppdb.riwayat-ppdb-single
    }

    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $kelas = Ekelas::where('kelas', $request->kelas)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
            'kelas_id' => $kelas->id,
            'tingkat_id' => $kelas->tingkat_id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            //data_field_validator
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
        RiwayatPendaftaranPPDB::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, RiwayatPendaftaranPPDB $riwayatPendaftaran)
    {
        //

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            //data_field_validator
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
        $varmodel = RiwayatPendaftaranPPDB::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //RiwayatPendaftaranPPDB
        // dd(id);
        // dd(request->all());
        $data = RiwayatPendaftaranPPDB::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
