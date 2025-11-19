<?php

namespace App\Http\Controllers\WakaKesiswaan\PPDB;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKesiswaan\PPDB\PembayaranPPDB;
use App\Models\WakaKesiswaan\PPDB\PengumumanPPDB;
use App\Models\WakaKesiswaan\PPDB\PPDBPeserta;

class PembayaranPPDBController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    PembayaranPPDB
    $pembayaranPPDB
    role.ppdb.
    role.ppdb.pembayaran-ppdb
    role.ppdb.pembayaran-ppdb-single
    php artisan make:view role.ppdb.pembayaran-ppdb
    php artisan make:view role.ppdb.pembayaran-ppdb-single
    php artisan make:seed PembayaranPPDBSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Pembayaran PPDB';
        $arr_ths = [
            'No Peserta',
            'Status Penerimaan',
            'Nama Peserta',
            'Pembayaran',
        ];
        $breadcrumb = 'Panitian PPDB / Pembayaran PPDB';
        $titleviewModal = 'Lihat Data Pembayaran PPDB';
        $titleeditModal = 'Edit Data Pembayaran PPDB';
        $titlecreateModal = 'Create Data Pembayaran PPDB';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        // $datas = PembayaranPPDB::get();
        // $datas = PPDBPeserta::with('PembayaranPPDB')
        $datas = PPDBPeserta::where('tapel_id', $etapels->id) ->get();
        $datapembayaran = PembayaranPPDB::where('tapel_id', $etapels->id)->get();
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.ppdb.pembayaran-ppdb', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'datapembayaran',
        ));
        //php artisan make:view role.ppdb.pembayaran-ppdb

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Pembayaran PPDB';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Menu_breadcume / sub_Menu_breadcume';
        $titleviewModal = 'Lihat Data Pembayaran PPDB';
        $titleeditModal = 'Edit Data Pembayaran PPDB';
        $titlecreateModal = 'Create Data Pembayaran PPDB';
        $datas = PembayaranPPDB::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.ppdb.pembayaran-ppdb-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.ppdb.pembayaran-ppdb-single
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
            'detailguru_id' => 'nullable|exists:detailgurus,id',
            'calon_id' => 'nullable|exists:ppdb_peserta,id',
            'nominal' => 'required|integer|min:1000', // Minimal Rp1.000
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
        PembayaranPPDB::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, PembayaranPPDB $pembayaranPPDB)
    {
        //

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'detailguru_id' => 'nullable|exists:detailgurus,id',
            'calon_id' => 'nullable|exists:ppdb_peserta,id',
            'nominal' => 'required|integer|min:1000', // Minimal Rp1.000
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
        $varmodel = PembayaranPPDB::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //PembayaranPPDB
        // dd(id);
        // dd(request->all());
        $data = PembayaranPPDB::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
