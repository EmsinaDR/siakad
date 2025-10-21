<?php

namespace App\Http\Controllers\Kepala\Supervisi;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Kepala\Supervisi\SupervisiRPP;

class SupervisiRPPController extends Controller
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

    //Supervisi RPP
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    php artisan optimize:clear

    php artisan make:view role.kepala.supervisi.supervisi-rpp
    php artisan make:view role.kepala.supervisi.supervisi-rpp-single
    php artisan make:seeder Kepala/Supervisi/SupervisiRPPSeeder
    php artisan make:model Kepala/Supervisi/SupervisiRPP
    php artisan make:controller Kepala/Supervisi/SupervisiRPPController --resource



     */
    /*
    SupervisiRPP
    $supervisirpp
    role.kepala.supervisi
    role.kepala.supervisi.supervisi-rpp
    role.kepala.supervisi.
    Index = Data Supervisi RPP
    Breadcume Index = 'Kepala Sekolah / Data Supervisi RPP';
    Single = Data Supervisi RPP
    php artisan make:view role.kepala.supervisi.supervisi-rpp
    php artisan make:view role.kepala.supervisi.supervisi-rpp-single
    php artisan make:seed SupervisiRPPSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Supervisi RPP';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Kepala Sekolah / Data Supervisi RPP';
        $titleviewModal = 'Lihat Data Supervisi RPP';
        $titleeditModal = 'Edit Data Supervisi RPP';
        $titlecreateModal = 'Create Data Supervisi RPP';
        $datas = SupervisiRPP::get();


        return view('role.kepala.supervisi.supervisi-rpp', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.kepala.supervisi.supervisi-rpp

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Supervisi RPP';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Kepala Sekolah / Data Supervisi RPP';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = SupervisiRPP::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.kepala.supervisi.supervisi-rpp-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.kepala.supervisi.supervisi-rpp-single
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



        SupervisiRPP::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, SupervisiRPP $supervisirpp)
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
        $varmodel = SupervisiRPP::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //SupervisiRPP
        // dd($id);
        // dd($request->all());
        $data = SupervisiRPP::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
