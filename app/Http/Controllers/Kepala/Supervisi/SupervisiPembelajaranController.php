<?php

namespace App\Http\Controllers\Kepala\Supervisi;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Kepala\Supervisi\SupervisiPembelajaran;

class SupervisiPembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    //Supervisi Pembelajaran
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    php artisan optimize:clear

    php artisan make:view role.kepala.supervisi.supervisi-pembelajaran
    php artisan make:view role.kepala.supervisi.supervisi-pembelajaran-single
    php artisan make:seeder Kepala/Supervisi/SupervisiPembelajaranSeeder
    php artisan make:model Kepala/Supervisi/SupervisiPembelajaran
    php artisan make:controller Kepala/Supervisi/SupervisiPembelajaranController --resource

    */
    /*
    SupervisiPembelajaran
    $supervisipembelajaran
    role.kepala.supervisi
    role.kepala.supervisi.supervisi-pembelajaran
    role.kepala.supervisi.blade_show
    Index = Data Supervisi Pembelajaran
    Breadcume Index = 'Kepala Sekolah / Data Supervisi Pembelajaran';
    Single = Data Supervisi Pembelajaran
    php artisan make:view role.kepala.supervisi.supervisi-pembelajaran
    php artisan make:view role.kepala.supervisi.supervisi-pembelajaran-single
    php artisan make:seed SupervisiPembelajaranSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Supervisi Pembelajaran';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Kepala Sekolah / Data Supervisi Pembelajaran';
        $titleviewModal = 'Lihat Data Supervisi Pembelajaran';
        $titleeditModal = 'Edit Data Supervisi Pembelajaran';
        $titlecreateModal = 'Create Data Supervisi Pembelajaran';
        $datas = SupervisiPembelajaran::get();


        return view('role.kepala.supervisi.supervisi-pembelajaran', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.kepala.supervisi.supervisi-pembelajaran

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Supervisi Pembelajaran';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Kepala Sekolah / Data Supervisi Pembelajaran';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = SupervisiPembelajaran::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.kepala.supervisi.supervisi-pembelajaran-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.kepala.supervisi.supervisi-pembelajaran-single
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



        SupervisiPembelajaran::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, SupervisiPembelajaran $supervisipembelajaran)
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
        $varmodel = SupervisiPembelajaran::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //SupervisiPembelajaran
        // dd($id);
        // dd($request->all());
        $data = SupervisiPembelajaran::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
