<?php

namespace App\Http\Controllers\Laboratorium;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Laboratorium\Laboratorium;
use Illuminate\Support\Facades\Validator;
use App\Models\Laboratorium\RiwayatLaboratorium;
use App\Models\WakaSarpras\Inventaris\Einventaris;
use App\Models\Laboratorium\InventarisLaboratorium;
use App\Models\WakaKesiswaan\Inventaris\Inventaris;
use App\Models\WakaSarpras\Inventaris\InventarisRuangan;
use App\Models\WakaSarpras\Inventaris\InventarisInRuangan;
use App\Models\WakaKesiswaan\Inventaris\InventarisKategori;
use App\Models\WakaSarpras\Inventaris\Inventaris as InventarisInventaris;
use App\Models\WakaSarpras\Inventaris\KIBB;

class InventarisLaboratoriumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    InventarisLaboratorium
    $inventarislab
    role.pembina.laboratorium
    role.pembina.laboratorium.inventaris-ruangan
    role.pembina.laboratorium.blade_show
    Index = Data Inventaris
    Breadcume Index = 'Pembina Laboratorium / Data Inventaris';
    Single = Data Inventaris
    php artisan make:view role.pembina.laboratorium.inventaris-ruangan
    php artisan make:view role.pembina.laboratorium.inventaris-ruangan-single
    php artisan make:seed InventarisLaboratoriumSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Inventaris';
        $arr_ths = [
            'Kode Barang',
            'Kategori Barang',
            'Nama Barang',
            'Jumlah',
        ];
        $breadcrumb = 'Pembina Laboratorium / Data Inventaris';
        $titleviewModal = 'Lihat Data Inventaris';
        $titleeditModal = 'Edit Data Inventaris';
        $titlecreateModal = 'Create Data Inventaris';
        $datas = InventarisLaboratorium::get();
        $DataInventarisIn = InventarisInRuangan::where('kibc_id', request()->segment(3))->get();
        dump($DataInventarisIn);



        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.pembina.laboratorium.inventaris-ruangan', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.pembina.laboratorium.inventaris-ruangan

    }


    public function show(Request $request)
    {
        //
        //Title to Controller
        $title = 'Data Inventaris';
        $arr_ths = [
            'Kode Barang',
            'Nama Barang',
        ];
        $breadcrumb = 'Pembina Laboratorium / Data Inventaris';
        $titleviewModal = 'Lihat Data Inventaris';
        $titleeditModal = 'Edit Data Inventaris';
        $titlecreateModal = 'Create Data Inventaris';

        // $datas = InventarisLaboratorium::where()->get();
        $DataLab = RiwayatLaboratorium::with('elaboratorium')->where('laboratorium_id', request()->segment(3))->first();
        $datas = InventarisInRuangan::where('kibc_id', request()->segment(3))->get();
        $DataKIBBs = KIBB::get();
        // dump($datas);
        // if (!$DataLab) {
        //     Session::flash('success', 'Tidak Ada Ruangan Yang Tersedia');
        //     return Redirect::back();
        // }
        // $datas = InventarisLaboratorium::where('kode_ruangan', $DataLab->kode_ruangan)->get();
        // if ($datas->isEmpty()) {
        //     return redirect()->back()->with('error', 'Data tidak ditemukan.');
        // }
        // $InventarisBarang = Einventaris::get();
        // $kategoriBarang = InventarisKategori::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.pembina.laboratorium.inventaris-ruangan-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DataLab',
            'DataKIBBs',
            // 'InventarisBarang',
            // 'kategoriBarang',
        ));
        //php artisan make:view role.pembina.laboratorium.inventaris-ruangan-single
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
        InventarisLaboratorium::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, InventarisLaboratorium $inventarislab)
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
        $varmodel = InventarisLaboratorium::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //InventarisLaboratorium
        // dd(id);
        // dd(request->all());
        $data = InventarisLaboratorium::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
