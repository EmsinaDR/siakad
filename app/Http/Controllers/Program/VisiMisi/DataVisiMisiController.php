<?php

namespace App\Http\Controllers\Program\VisiMisi;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\VisiMisi\DataVisiMisi;

class DataVisiMisiController extends Controller
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

php artisan make:view role.program.visimisi.data-visi
php artisan make:view role.program.visimisi.data-visi-single
php artisan make:model Program/VisiMisi/DataVisiMisi
php artisan make:controller Program/VisiMisi/DataVisiMisiController --resource



php artisan make:seeder Program/VisiMisi/DataVisiMisiSeeder
php artisan make:migration DataVisiMisi




*/
    /*
    DataVisiMisi
    $DataVisiMisi
    role.program.visimisi
    role.program.visimisi.data-visi
    role.program.visimisi.blade_show
    Index = Data VIsi
    Breadcume Index = 'Menu_breadcume / Data VIsi';
    Single = titel_data_single
    php artisan make:view role.program.visimisi.data-visi
    php artisan make:view role.program.visimisi.data-visi-single
    php artisan make:seed DataVisiMisiSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data VIsi';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Menu_breadcume / Data VIsi';
        $titleviewModal = 'Lihat Data VIsi';
        $titleeditModal = 'Edit Data VIsi';
        $titlecreateModal = 'Create Data VIsi';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = DataVisiMisi::first();


        return view('role.program.visimisi.data-visi', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.visimisi.data-visi

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data VIsi';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Menu_breadcume / Data VIsi';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = DataVisiMisi::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.visimisi.data-visi-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.program.visimisi.data-visi-single
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



        DataVisiMisi::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, DataVisiMisi $DataVisiMisi)
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
        $varmodel = DataVisiMisi::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //DataVisiMisi
        // dd($id);
        // dd($request->all());
        $data = DataVisiMisi::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
