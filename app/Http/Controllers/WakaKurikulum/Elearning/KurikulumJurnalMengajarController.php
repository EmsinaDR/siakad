<?php

namespace App\Http\Controllers\WakaKurikulum\Elearning;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\Elearning\KurikulumJurnalMengajar;

class KurikulumJurnalMengajarController extends Controller
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

php artisan make:view role.waka.kurikulum.elearning.jurnal-mengajar
php artisan make:view role.waka.kurikulum.elearning.jurnal-mengajar-single
php artisan make:seeder WakaKurikulum/Elearning/KurikulumJurnalMengajarSeeder
php artisan make:model WakaKurikulum/Elearning/KurikulumJurnalMengajar
php artisan make:controller WakaKurikulum/Elearning/KurikulumJurnalMengajarController --resource

*/
    /*
    KurikulumJurnalMengajar
    $kurikulumjurnalmengajar
    role.waka.kurikulum.elearning.jurnal-mengajar
    role.waka.kurikulum.elearning.jurnal-mengajar.
    role.waka.kurikulum.elearning.jurnal-mengajar.blade_show
    Index = Data Jurnal Mengajar
    Breadcume Index = 'Waka Kurikulum / Jurnal Mengajar Guru';
    Single = Data Jurnal Mengajar
    php artisan make:view role.waka.kurikulum.elearning.jurnal-mengajar.
    php artisan make:view role.waka.kurikulum.elearning.jurnal-mengajar.-single
    php artisan make:seed KurikulumJurnalMengajarSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Jurnal Mengajar Guru';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kurikulum / Jurnal Mengajar Guru';
        $titleviewModal = 'Lihat Data Jurnal Mengajar';
        $titleeditModal = 'Edit Data Jurnal Mengajar';
        $titlecreateModal = 'Create Data Jurnal Mengajar';
        $datas = KurikulumJurnalMengajar::orderBy('created_at', 'DESC')->get();


        return view('role.waka.kurikulum.elearning.jurnal-mengajar', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.waka.kurikulum.elearning.jurnal-mengajar.

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Jurnal Mengajar';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kurikulum / Jurnal Mengajar Guru';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = KurikulumJurnalMengajar::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.elearning.jurnal-mengajar-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.kurikulum.elearning.jurnal-mengajar.-single
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



        KurikulumJurnalMengajar::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, KurikulumJurnalMengajar $kurikulumjurnalmengajar)
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
        $varmodel = KurikulumJurnalMengajar::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //KurikulumJurnalMengajar
        // dd(id);
        // dd(request->all());
        $data = KurikulumJurnalMengajar::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
