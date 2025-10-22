<?php

namespace App\Http\Controllers\WakaKurikulum\Perangkat;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\Perangkat\PeraturanTest;

class PeraturanTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
/*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view role.waka.kurikulum.Perangkat.peraturan-test
php artisan make:view role.waka.kurikulum.Perangkat.peraturan-test-single
php artisan make:model WakaKurikulum/Perangkat/PeraturanTest
php artisan make:controller WakaKurikulum/Perangkat/PeraturanTestController --resource



php artisan make:seeder WakaKurikulum/Perangkat/PeraturanTestSeeder
php artisan make:migration Migration_PeraturanTest



   PeraturanTest
    $peraturantest
    role.waka.kurikulum.Perangkat
    role.waka.kurikulum.Perangkat.peraturan-test
    role.waka.kurikulum.Perangkat.blade_show
    Index = Peraturan Test
    Breadcume Index = 'Waka Kurikulum / Perangkat / Peraturan Test';
    Single = titel_data_single
    php artisan make:view role.waka.kurikulum.Perangkat.peraturan-test
    php artisan make:view role.waka.kurikulum.Perangkat.peraturan-test-single
    php artisan make:seed PeraturanTestSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Peraturan Test';
        $arr_ths = [
            'Kategori',
            'Sub Kategori',
            'Peraturan',
        ];
        $breadcrumb = 'Waka Kurikulum / Perangkat / Peraturan Test';
        $titleviewModal = 'Lihat Data Peraturan Test';
        $titleeditModal = 'Edit Data Peraturan Test';
        $titlecreateModal = 'Create Data Peraturan Test';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = PeraturanTest::whereIn('kategori', ['Persiapan Sebelum Tes', 'Pelaksanaan Tes', 'Selesai Tes', 'Sanksi Pelanggaran', 'Hak Peserta'])->orderBy('created_at', 'DESC')->get();
        $DropdownKatgoris = PeraturanTest::select('kategori')->distinct('kategori')->whereIn('kategori', ['Persiapan Sebelum Tes', 'Pelaksanaan Tes', 'Selesai Tes', 'Sanksi Pelanggaran', 'Hak Peserta'])->orderBy('kategori', 'ASC')->get();
        $DropdownSubKatgoris = PeraturanTest::select('sub_kategori')->distinct('sub_kategori')->whereIn('kategori', ['Persiapan Sebelum Tes', 'Pelaksanaan Tes', 'Selesai Tes', 'Sanksi Pelanggaran', 'Hak Peserta'])->orderBy('sub_kategori', 'ASC')->get();


        return view('role.waka.kurikulum.Perangkat.peraturan-test', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DropdownKatgoris',
            'DropdownSubKatgoris',
        ));
        //php artisan make:view role.waka.kurikulum.Perangkat.peraturan-test

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Peraturan Test';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kurikulum / Perangkat / Peraturan Test';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = PeraturanTest::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.Perangkat.peraturan-test-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.waka.kurikulum.Perangkat.peraturan-test-single
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
            'kategori' => 'required|string|max:255',
            'sub_kategori' => 'nullable|string|max:255',
            'peraturan' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }



        PeraturanTest::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, PeraturanTest $peraturantest)
    {
        //

        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|string|max:255',
            'sub_kategori' => 'nullable|string|max:255',
            'peraturan' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $varmodel = PeraturanTest::find($id); // Pastikan $id didefinisikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($validator->validated());
            // return Redirect::back()->with('Title', 'Berhasil')->with('success', 'Data Berhasil di Update');
        } else {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Data tidak ditemukan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //PeraturanTest
        // dd($id);
        // dd($request->all());
        $data = PeraturanTest::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
