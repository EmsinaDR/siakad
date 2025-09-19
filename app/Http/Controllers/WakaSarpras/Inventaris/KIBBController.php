<?php

namespace App\Http\Controllers\WakaSarpras\Inventaris;
// app\Http\Controllers\WakaSarpras\Inventaris\KIBBController.php
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaSarpras\Inventaris\KIBB;
use App\Models\WakaSarpras\Inventaris\Inventaris;

class KIBBController extends Controller
{
    //
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data KIB B';
        $arr_ths = [
            'Nama Barang',
            // 'Vendor',
            'Merk',
            'Tahun',
            'Kondisi',
            'Jumlah',
            'Harga',
            'Spesifikasi',
            // 'Keterangan',
        ];
        $breadcrumb = 'Waka Sarpras / Data KIB B';
        $titleviewModal = 'Lihat Data KIB B';
        $titleeditModal = 'Edit Data KIB B';
        $titlecreateModal = 'Create Data KIB B';
        $datas = KIBB::orderBy('created_at', 'DESC')->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.kibb', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.sarpras.inventaris.kibb

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data KIB B';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Sarpras / Data KIB B';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = KIBB::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.kibb-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.sarpras.inventaris.kibb-single
    }

    public function store(Request $request)
    {
        //

        $validated = $request->validate([
            'barang_id' => 'required|array', // Memastikan barang_id adalah array
            'barang_id.*' => 'integer|exists:inventaris,id', // Setiap elemen di dalam array harus integer dan ada di tabel barang
        ]);
        // dd($request->barang_id);
        // dd($request->all());
        foreach ($request->barang_id as $IdBarang) {
            $cekData = Inventaris::where('id', $IdBarang)->first();
            $jumlahKodeSama = KIBB::where('barang_id', $IdBarang)->count();
            if($jumlahKodeSama)
            KIBB::create([
                'barang_id' => $IdBarang,
                'kode_barang' => $cekData->kode . '-' . str_pad($jumlahKodeSama, 3, '0', STR_PAD_LEFT),
            ]);
        }
        Session::flash('success', 'Data Berhasil Disimpan');
        // dd($request->all());
        return Redirect::back();
    }
    public function update($id, Request $request, KIBB $kibb)
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
        $varmodel = KIBB::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //KIBB
        // dd(id);
        // dd(request->all());
        $data = KIBB::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
