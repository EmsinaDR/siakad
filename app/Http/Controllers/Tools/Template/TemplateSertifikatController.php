<?php

namespace App\Http\Controllers\Tools\Template;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Tools\Template\TemplateSertifikat;

class TemplateSertifikatController extends Controller
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

php artisan make:view role.tools.template.template-sertifikat
php artisan make:view role.tools.template.template-sertifikat-single
php artisan make:model Tools/Template/TemplateSertifikat
php artisan make:controller Tools/Template/TemplateSertifikatController --resource



php artisan make:seeder Tools/Template/TemplateSertifikatSeeder
php artisan make:migration Migration_TemplateSertifikat




*/
    /*
    TemplateSertifikat
    $templatesertifikat
    role.tools.template
    role.tools.template.template-sertifikat
    role.tools.template.blade_show
    Index = Template Sertifikat
    Breadcume Index = 'Data Template Sertifikat / Template Sertifikat';
    Single = Template Sertifikat
    php artisan make:view role.program.role.tools.template.template-sertifikat
    php artisan make:view role.program.role.tools.template.template-sertifikat-single
    php artisan make:seed TemplateSertifikatSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Template Sertifikat';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Template Sertifikat / Template Sertifikat';
        $titleviewModal = 'Lihat Data Template Sertifikat';
        $titleeditModal = 'Edit Data Template Sertifikat';
        $titlecreateModal = 'Create Data Template Sertifikat';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = TemplateSertifikat::get();


        return view('role.tools.template.template-sertifikat', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.tools.template.template-sertifikat

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Template Sertifikat';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Template Sertifikat / Template Sertifikat';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = TemplateSertifikat::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.tools.template.template-sertifikat-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.tools.template.template-sertifikat-single
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



        TemplateSertifikat::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, TemplateSertifikat $templatesertifikat)
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
        $varmodel = TemplateSertifikat::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //TemplateSertifikat
        // dd($id);
        // dd($request->all());
        $data = TemplateSertifikat::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
