<?php

namespace App\Http\Controllers\WakaSarpras\Inventaris;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaSarpras\Inventaris\InventarisVendor;

class InventarisVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    InventarisVendor
    $inventarisVendor
    role.waka.inventaris
    role.waka.sarpras.inventaris.inventaris-vendor
    role.waka.inventaris.blade_show
    Index = Data Vendor Barang
    Breadcume Index = 'Waka Sarpras / Data Vendor';
    Single = titel_data_single
    php artisan make:view role.waka.sarpras.inventaris.inventaris-vendor
    php artisan make:view role.waka.sarpras.inventaris.inventaris-vendor-single
    php artisan make:seed InventarisVendorSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Vendor Barang';
        $arr_ths = [
            'Nama Vendor',
            'Nama Kontak',
            'No HP',
            'Alamat',
            'Keterangan',
        ];
        $breadcrumb = 'Waka Sarpras / Data Vendor';
        $titleviewModal = 'Lihat Data Vendor Barang';
        $titleeditModal = 'Edit Data Vendor Barang';
        $titlecreateModal = 'Create Data Vendor Barang';
        $datas = InventarisVendor::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.inventaris-vendor', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.sarpras.inventaris.inventaris-vendor

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
        $breadcrumb = 'Waka Sarpras / Data Vendor';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = InventarisVendor::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.inventaris-vendor-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.sarpras.inventaris.inventaris-vendor-single
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
        InventarisVendor::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
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
            'nama_vendor' => 'required|string|max:255',
            'nama_kontak' => 'nullable|string|max:255',
            'nomor_hp' => 'required|numeric|digits_between:10,15',
            'alamat' => 'nullable|string|max:500',
            'keterangan' => 'nullable|string',
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
        $varmodel = InventarisVendor::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //InventarisVendor
        // dd(id);
        // dd(request->all());
        $data = InventarisVendor::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
