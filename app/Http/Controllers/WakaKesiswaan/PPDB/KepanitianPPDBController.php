<?php

namespace App\Http\Controllers\WakaKesiswaan\PPDB;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKesiswaan\PPDB\KepanitianPPDB;

class KepanitianPPDBController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /*
     KepanitianPPDB
     $KepanitianPPDB
     role.waka.kesiswaan.ppdb
     role.waka.kesiswaan.ppdb.kepanitiaan-ppdb
     role.waka.kesiswaan.ppdb.blade_show
     Index = Kepanitiaan PPDB
     Breadcume Index = 'Waka Kesiswaan / PPDB / Kepanitiaan PPDB';
     Single = Kepanitiaan PPDB
     php artisan make:view role.waka.kesiswaan.ppdb.kepanitiaan-ppdb
     php artisan make:view role.waka.kesiswaan.ppdb.kepanitiaan-ppdb-single
     php artisan make:seed KepanitianPPDBSeeder



     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Kepanitiaan PPDB';
        $arr_ths = [
            'Tahun Pelajaran',
            'Jabatan',
            'Nama Guru',
        ];
        $breadcrumb = 'Waka Kesiswaan / PPDB / Kepanitiaan PPDB';
        $titleviewModal = 'Lihat Data Kepanitiaan PPDB';
        $titleeditModal = 'Edit Data Kepanitiaan PPDB';
        $titlecreateModal = 'Create Data Kepanitiaan PPDB';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = KepanitianPPDB::where('tapel_id', $etapels->id)->get();
        $datas = KepanitianPPDB::orderBy('tapel_id', 'DESC')->get();
        $Jabatans = $datas->pluck('jabatan')->unique()->values()->toArray();
        // dd($Jabatan);
        $DataGurus = Detailguru::orderBy('nama_guru', 'ASC')->get();
        // $JabatanPPDB = KepanitianPPDB::orderBy('tapel_id', 'DESC')->get();


        return view('role.waka.kesiswaan.ppdb.kepanitiaan-ppdb', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DataGurus',
            'Jabatans',
        ));
        //php artisan make:view role.waka.kesiswaan.ppdb.kepanitiaan-ppdb

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Kepanitiaan PPDB';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kesiswaan / PPDB / Kepanitiaan PPDB';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = KepanitianPPDB::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kesiswaan.ppdb.kepanitiaan-ppdb-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.kesiswaan.ppdb.kepanitiaan-ppdb-single
    }

    public function store(Request $request)
    {
        //
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Pastikan $etapels tidak null sebelum mengambil ID
        if (!$etapels) {
            return redirect()->back()->withErrors(['tapel_id' => 'Tahun pelajaran tidak ditemukan.'])->withInput();
        }

        // Mengubah nilai 'jabatan' jika memilih 'lainnya'
        $request->merge([
            'tapel_id' => $etapels->id,
            'jabatan' => $request->jabatan === 'lainnya' ? $request->jabatan_lainnya : $request->jabatan
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'detailguru_id' => 'integer|nullable',
            'jabatan' => 'required|string',
            'tapel_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan ke database
        KepanitianPPDB::create($validator->validated());

        // dd($request->all());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, KepanitianPPDB $KepanitianPPDB)
    {
        //

        dd($request->all());
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
        $varmodel = KepanitianPPDB::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //KepanitianPPDB
        // dd($id);
        // dd($request->all());
        $data = KepanitianPPDB::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
