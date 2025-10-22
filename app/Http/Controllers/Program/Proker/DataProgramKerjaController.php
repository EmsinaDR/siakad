<?php

namespace App\Http\Controllers\Program\Proker;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Proker\DataProgramKerja;

class DataProgramKerjaController extends Controller
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

php artisan make:view role.program.proker.data-program-kerja
php artisan make:view role.program.proker.data-program-kerja-single
php artisan make:model Program/Proker/DataProgramKerja
php artisan make:controller Program/Proker/DataProgramKerjaController --resource



php artisan make:seeder Program/Proker/DataProgramKerjaSeeder
php artisan make:migration Migration_DataProgramKerja


*/
    /*
    DataProgramKerja
    $dataproker
    role.program.proker
    role.program.proker.data-program-kerja
    role.program.proker.blade_show
    Index = Data Program Kerja
    Breadcume Index = 'Data Program / Data Program Kerja';
    Single = Data Program Kerja
    php artisan make:view role.program.role.program.proker.data-program-kerja
    php artisan make:view role.program.role.program.proker.data-program-kerja-single
    php artisan make:seed DataProgramKerjaSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Program Kerja';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Program Kerja / Data Program Kerja';
        $titleviewModal = 'Lihat Data Program Kerja';
        $titleeditModal = 'Edit Data Program Kerja';
        $titlecreateModal = 'Create Data Program Kerja';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = DataProgramKerja::where('tapel_id', $etapels->id)->get();


        return view('role.program.proker.data-program-kerja', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.proker.data-program-kerja

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Program Kerja';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Program Kerja / Data Program Kerja';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = DataProgramKerja::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.proker.data-program-kerja-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.program.proker.data-program-kerja-single
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



        DataProgramKerja::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, DataProgramKerja $dataproker)
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
        $varmodel = DataProgramKerja::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //DataProgramKerja
        // dd($id);
        // dd($request->all());
        $data = DataProgramKerja::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
