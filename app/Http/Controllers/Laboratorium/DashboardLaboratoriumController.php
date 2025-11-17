<?php

namespace App\Http\Controllers\Laboratorium;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Laboratorium\DashboardLaboratorium;

class DashboardLaboratoriumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    DashboardLaboratorium
    $dashboardlaboratorium
    role.pembina.laboratorium
    role.pembina.laboratorium.dashboard
    role.pembina.laboratorium.blade_show
    Index = Dashboard Laboratorium
    Breadcume Index = 'Pembina Laboratorium / Dashboard';
    Single = titel_data_single
    php artisan make:view role.pembina.laboratorium.dashboard-laboratorium
    php artisan make:view role.pembina.laboratorium.dashboard-single
    php artisan make:seed DashboardLaboratoriumSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Dashboard Laboratorium';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Pembina Laboratorium / Dashboard';
        $titleviewModal = 'Lihat Data Dashboard Laboratorium';
        $titleeditModal = 'Edit Data Dashboard Laboratorium';
        $titlecreateModal = 'Create Data Dashboard Laboratorium';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        $datas = DashboardLaboratorium::where('tapel_id', $etapels->id)->where('laboratorium_id', request()->segment(3))->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.pembina.laboratorium.dashboard-laboratorium', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.pembina.laboratorium.dashboard

    }


    public function show()
    {
        //
        //Title to Controller$title = 'Dashboard Laboratorium';
        $title = 'Dashboard Laboratorium';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Pembina Laboratorium / Dashboard';
        $titleviewModal = 'Lihat Data Dashboard Laboratorium';
        $titleeditModal = 'Edit Data Dashboard Laboratorium';
        $titlecreateModal = 'Create Data Dashboard Laboratorium';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        $data_lab = DashboardLaboratorium::with('Laboratorium')->where('tapel_id', $etapels->id)->where('laboratorium_id', request()->segment(3))->first();
        // dd($data_lab);

        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.pembina.laboratorium.dashboard-single', compact('data_lab', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.pembina.laboratorium.dashboard-single
    }

    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $kelas = Ekelas::where('kelas', $request->kelas)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
            'kelas_id' => $kelas->id,
            'tingkat_id' => $kelas->tingkat_id,
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
        // Menyimpan data menggunakan mass assignment
        // Create : Buat
        // Update : Memperbaharui
        // Menyimpan data menggunakan mass assignment
        DashboardLaboratorium::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, DashboardLaboratorium $dashboardlaboratorium)
    {
        //

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
        // Menyimpan data menggunakan mass assignment
        // Create : Buat
        // Update : Memperbaharui
        // Menyimpan data menggunakan mass assignment
        $varmodel = DashboardLaboratorium::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //DashboardLaboratorium
        // dd(id);
        // dd(request->all());
        $data = DashboardLaboratorium::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
