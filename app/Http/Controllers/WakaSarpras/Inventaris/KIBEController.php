<?php

namespace App\Http\Controllers\WakaSarpras\Inventaris;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaSarpras\Inventaris\KIBE;
use App\Models\WakaSarpras\Inventaris\Inventaris;
use App\Models\WakaSarpras\Inventaris\InventarisVendor;

class KIBEController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    KIBE
    $kibe
    role.waka.sarpras.inventaris
    role.waka.sarpras.inventaris.kibe
    role.waka.sarpras.inventaris.blade_show
    Index = Data KIB E
    Breadcume Index = 'Waka Sarpras / Data KIB E';
    Single = Data KIB E
    php artisan make:view role.waka.sarpras.inventaris.kibe
    php artisan make:view role.waka.sarpras.inventaris.kibe-single
    php artisan make:seed KIBESeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data KIB E';
        $arr_ths = [
            'Vendor',
            'Nama Barang',
            'Jenis',
            'Tahun Masuk',
            // 'Penggunaan',
            'Jumlah',
            'Harga',
            'Status',
        ];
        $breadcrumb = 'Waka Sarpras / Data KIB E';
        $titleviewModal = 'Lihat Data KIB E';
        $titleeditModal = 'Edit Data KIB E';
        $titlecreateModal = 'Create Data KIB E';
        $datas = KIBE::orderBy('created_at', 'DESC')->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.kibe', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.waka.sarpras.inventaris.kibe

    }


    public function show()
    {
        //
        //Title to Controller



               //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('blade', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //Title to Controller
        $title = 'Data KIB E';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Sarpras / Data KIB E';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = KIBE::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.kibe-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.waka.sarpras.inventaris.kibe-single
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
        KIBE::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, KIBE $kibe)
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
        $varmodel = KIBE::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //KIBE
        // dd(id);
        // dd(request->all());
        $data = KIBE::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
