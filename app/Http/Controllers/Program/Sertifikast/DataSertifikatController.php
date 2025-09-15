<?php

namespace App\Http\Controllers\Program\Sertifikast;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Sertifikast\DataSertifikat;

class DataSertifikatController extends Controller
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

php artisan make:view role.program.sertifikat.data-sertifikat
php artisan make:view role.program.sertifikat.data-sertifikat-single
php artisan make:model Program/Sertifikast/DataSertifikat
php artisan make:controller Program/Sertifikast/DataSertifikatController --resource



php artisan make:seeder Program/Sertifikast/DataSertifikatSeeder
php artisan make:migration Migration_DataSertifikat




*/
    /*
    DataSertifikat
    $dtsertifikat
    role.program.sertifikat
    role.program.sertifikat.data-sertifikat
    role.program.sertifikat.blade_show
    Index = Data Sertifikat
    Breadcume Index = 'Program / Data Sertifikat';
    Single = Data Sertifikat
    php artisan make:view role.program.sertifikat.data-sertifikat
    php artisan make:view role.program.sertifikat.data-sertifikat-single
    php artisan make:seed DataSertifikatSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Sertifikat';
        $arr_ths = [
            'Nama Pemilik',
            'Tahun Terbit',
            'Tingkat',
            'Nama Pemilikd',
        ];
        $breadcrumb = 'Program / Data Sertifikat';
        $titleviewModal = 'Lihat Data Sertifikat';
        $titleeditModal = 'Edit Data Sertifikat';
        $titlecreateModal = 'Create Data Sertifikat';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = DataSertifikat::where('tapel_id', $etapels->id)->get();


        return view('role.program.sertifikat.data-sertifikat', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.sertifikat.data-sertifikat

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Sertifikat';
        $arr_ths = [
            'Nama Pemilik',
            'Tahun Terbit',
            'Tingkat',
            'Nama Pemilikd',
        ];
        $breadcrumb = 'Program / Data Sertifikat';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = DataSertifikat::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.sertifikat.data-sertifikat-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.program.sertifikat.data-sertifikat-single
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
            //data_field_validator
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }



        DataSertifikat::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, DataSertifikat $dtsertifikat)
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
        $varmodel = DataSertifikat::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //DataSertifikat
        // dd($id);
        // dd($request->all());
        $data = DataSertifikat::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
