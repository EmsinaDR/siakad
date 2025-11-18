<?php

namespace App\Http\Controllers\WakaSarpras\Inventaris;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaSarpras\Inventaris\InventarisRuangan;

class InventarisRuanganController extends Controller
{
    //
    /*
    InventarisRuangan
    $inventarisruangan
    role.waka.sarpras.inventaris.
    role.waka.sarpras.inventaris..inventaris-ruangan
    role.waka.sarpras.inventaris..blade_show
    Index = Waka Sarpras
    Breadcume Index = 'Waka Sarprass / Inventaris Ruangan';
    Single = Inventaris Ruangan
    php artisan make:view role.waka.sarpras.inventaris..inventaris-ruangan
    php artisan make:view role.waka.sarpras.inventaris..inventaris-ruangan-single
    php artisan make:seed InventarisRuanganSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Waka Sarpras';
        $arr_ths = [
            'Kode Ruangan',
            'Nama Ruangan',
            'Keterangan',
        ];
        $breadcrumb = 'Waka Sarprass / Inventaris Ruangan';
        $titleviewModal = 'Lihat Data Waka Sarpras';
        $titleeditModal = 'Edit Data Waka Sarpras';
        $titlecreateModal = 'Create Data Waka Sarpras';
        $datas = InventarisRuangan::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris..inventaris-ruangan', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.sarpras.inventaris..inventaris-ruangan

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Inventaris Ruangan';
        $arr_ths = [
            'Kode Ruangan',
            'Nama Ruangan',
            'Keterangan',
        ];
        $breadcrumb = 'Waka Sarprass / Inventaris Ruangan';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = InventarisRuangan::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris..inventaris-ruangan-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.sarpras.inventaris..inventaris-ruangan-single
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
        InventarisRuangan::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, InventarisRuangan $inventarisruangan)
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
        $varmodel = InventarisRuangan::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //InventarisRuangan
        // dd(id);
        // dd(request->all());
        $data = InventarisRuangan::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
