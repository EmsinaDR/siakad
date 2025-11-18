<?php

namespace App\Http\Controllers\WakaKurikulum\Elearning;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\Elearning\KurikulumMateriAjar;

class KurikulumMateriAjarController extends Controller
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

php artisan make:view role.waka.kurikulum.elearning.materi-ajar
php artisan make:view role.waka.kurikulum.elearning.materi-ajar-single
php artisan make:seeder WakaKurikulum/Elearning/KurikulumMateriAjarSeeder
php artisan make:model WakaKurikulum/Elearning/KurikulumMateriAjar
php artisan make:controller WakaKurikulum/Elearning/KurikulumMateriAjarController --resource

App\Http\Controllers\WakaKurikulum$Folder$namaController
*/
    /*
    KurikulumMateriAjar
    $varModel
    role.waka.kurikulum.elearning
    role.waka.kurikulum.elearning.materi-ajar
    role.waka.kurikulum.elearning.blade_show
    Index = Materi Ajar
    Breadcume Index = 'Waka Kurikulum / Materi Ajar';
    Single = Materi Ajar
    php artisan make:view role.waka.kurikulum.elearning.materi-ajar
    php artisan make:view role.waka.kurikulum.elearning.materi-ajar-single
    php artisan make:seed KurikulumMateriAjarSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Materi Ajar';
        $arr_ths = [
            'Mapel',
            'Materi',
            'Sub Materi',
            'Indikator',
        ];
        $breadcrumb = 'Waka Kurikulum / Materi Ajar';
        $titleviewModal = 'Lihat Data Materi Ajar';
        $titleeditModal = 'Edit Data Materi Ajar';
        $titlecreateModal = 'Create Data Materi Ajar';
        $datas = KurikulumMateriAjar::get();


        return view('role.waka.kurikulum.elearning.materi-ajar', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.waka.kurikulum.elearning.materi-ajar

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Materi Ajar';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kurikulum / Materi Ajar';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = KurikulumMateriAjar::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.elearning.materi-ajar-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.kurikulum.elearning.materi-ajar-single
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



        KurikulumMateriAjar::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, KurikulumMateriAjar $varModel)
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
        $varmodel = KurikulumMateriAjar::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //KurikulumMateriAjar
        // dd(id);
        // dd(request->all());
        $data = KurikulumMateriAjar::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
