<?php

namespace App\Http\Controllers\WakaSarpras\Inventaris;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaSarpras\Inventaris\KIBA;
use App\Models\WakaSarpras\Inventaris\KIBF;

class KIBFController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    KIBF
    $kibf
    role.waka.sarpras.inventaris
    role.waka.sarpras.inventaris.kibf
    role.waka.sarpras.inventaris.blade_show
    Index = Data KIB F
    Breadcume Index = 'Waka Sarpras / Data KIB F';
    Single = Data KIB F
    php artisan make:view role.waka.sarpras.inventaris.kibf
    php artisan make:view role.waka.sarpras.inventaris.kibf-single
    php artisan make:seed KIBFSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data KIB F';
        $arr_ths = [
            'Nama Barang',
            'Jumlah',
            'Tahun Masuk',
            'Lokasi',
            'Status',
        ];
        $breadcrumb = 'Waka Sarpras / Data KIB F';
        $titleviewModal = 'Lihat Data KIB F';
        $titleeditModal = 'Edit Data KIB F';
        $titlecreateModal = 'Create Data KIB F';
        $datas = KIBF::get();
        $datakibA = KIBA::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.kibf', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'datakibA'
        ));
        //php artisan make:view role.waka.sarpras.inventaris.kibf

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data KIB F';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Sarpras / Data KIB F';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = KIBF::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.kibf-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.sarpras.inventaris.kibf-single
    }

    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'barang_id' => 'nullable|integer',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'tahun_masuk' => 'required|integer|min:1900|max:' . date('Y'),
            'lokasi' => 'required|string|max:255',
            'status' => 'required|in:Baik,Rusak Ringan,Rusak Sedang,Rusak Berat',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        KIBF::create($validator->validated());
        dd($request->all());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, KIBF $kibf)
    {
        //

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'barang_id' => 'nullable|integer',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'tahun_masuk' => 'required|integer|min:1900|max:' . date('Y'),
            'lokasi' => 'required|string|max:255',
            'status' => 'required|in:Baik,Rusak Ringan,Rusak Sedang,Rusak Berat',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $varmodel = KIBF::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //KIBF
        // dd(id);
        // dd(request->all());
        $data = KIBF::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
