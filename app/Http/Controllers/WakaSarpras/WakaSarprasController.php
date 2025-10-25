<?php

namespace App\Http\Controllers\WakaSarpras;


use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use App\Models\WakaSarpras\WakaSarpras;
use Illuminate\Support\Facades\Session;
use App\Models\WakaSarpras\WakaSarapras;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaSarpras\Inventaris\KIBA;
use App\Models\WakaSarpras\Inventaris\KIBB;
use App\Models\WakaSarpras\Inventaris\KIBC;
use App\Models\WakaSarpras\Inventaris\Einventaris;
use App\Models\WakaSarpras\Inventaris\InventarisVendor;
use App\Models\WakaSarpras\Inventaris\InventarisRuangan;
use App\Models\WakaKesiswaan\Inventaris\InventarisKategori;

class WakaSarprasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    Wakasarpras
    $wakasarpras
    role.waka.sarpras.waka-sarpras
    role.waka.sarpras.waka-sarpras.waka-sarpras
    role.waka.sarpras.waka-sarpras.blade_show
    Index = Dasboard Sarpras
    Breadcume Index = 'Waka sarpras / Dashboard';
    Single = titel_data_single
    php artisan make:view role.waka.sarpras.waka-sarpras.waka-sarpras
    php artisan make:view role.waka.sarpras.waka-sarpras.waka-sarpras-single
    php artisan make:seed WakasarprasSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Dasboard Sarpras';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka sarpras / Dashboard';
        $titleviewModal = 'Lihat Data Dasboard Sarpras';
        $titleeditModal = 'Edit Data Dasboard Sarpras';
        $titlecreateModal = 'Create Data Dasboard Sarpras';
        // $datas = WakaSarpras::get();
        $datas = '';
        $invetarisBarang = Einventaris::get();
        // $KategoriBarang = InventarisKategori::get();
        // $TotalRuangan = InventarisRuangan::get();
        $KategoriTanah = KIBA::get();
        $KategoriBarang = KIBB::get();
        $TotalRuangan = KIBC::get();
        $TotalVendor = InventarisVendor::get();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $TotalKelas = Ekelas::where('tapel_id', $etapels->id)->get();
        $TotalUser = User::get();



        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.waka-sarpras', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'invetarisBarang',
            'KategoriBarang',
            'TotalRuangan',
            'TotalKelas',
            'TotalUser',
            'TotalVendor',
            'KategoriTanah',
        ));
        //php artisan make:view role.waka.sarpras.waka-sarpras.waka-sarpras

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'titel_data_single';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka sarpras / Dashboard';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        // $datas = WakaSarpras::get();
        $datas = '';


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.waka-sarpras-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.sarpras.waka-sarpras.waka-sarpras-single
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
        // WakaSarpras::create($validator->validated());
        // Session::flash('success', 'Data Berhasil Disimpan');
        // return Redirect::back();
    }
    public function update($id, Request $request)
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
        // $varmodel = WakaSarpras::find($id); // Pastikan $id didefinisikan atau diterima dari request
        // if ($varmodel) {
        //     $varmodel->update($validator->validated());
        //     return Redirect::back()->with('Title', 'Berhasil')->with('success', 'Data Berhasil di Update');
        // } else {
        //     return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Data tidak ditemukan');
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //Wakasarpras
        // dd(id);
        // dd(request->all());
        // $data = WakaSarpras::findOrFail($id);
        // $data->delete();
        // return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        // return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
