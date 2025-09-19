<?php

namespace App\Http\Controllers\WakaSarpras\Inventaris;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaSarpras\Inventaris\KIBC;
use App\Models\WakaSarpras\Inventaris\Inventaris;

class KIBCController extends Controller
{
    //
    /*
    KIBC
    $kibc
    role.waka.sarpras.inventaris
    role.waka.sarpras.inventaris.kibc
    role.waka.sarpras.inventaris.blade_show
    Index = Data KIB C
    Breadcume Index = 'Waka Sarpras / Data KIB C';
    Single = Data KIB C
    php artisan make:view role.waka.sarpras.inventaris.kibc
    php artisan make:view role.waka.sarpras.inventaris.kibc-single
    php artisan make:seed KIBCSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data KIB C';
        $arr_ths = [
            'Kode Ruangan',
            'Nama Ruangan',
            'Panjang',
            'Lebar',
            'Keterangan',
        ];
        $breadcrumb = 'Waka Sarpras / Data KIB C';
        $titleviewModal = 'Lihat Data KIB C';
        $titleeditModal = 'Edit Data KIB C';
        $titlecreateModal = 'Create Data KIB C';
        $datas = KIBC::orderBy('created_at', 'DESC')->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.kibc', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.sarpras.inventaris.kibc

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data KIB C';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Sarpras / Data KIB C';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = KIBC::orderBy('created_at', 'DESC')->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.kibc-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.waka.sarpras.inventaris.kibc-single
    }

    public function store(Request $request)
    {
        //


        // Validasi data
        // $validator = Validator::make($request->all(), [
        //     'barang_id' => 'nullable|integer',
        //     'kode_ruangan' => 'nullable|string|unique:ruangans,kode_ruangan',
        //     'nama_ruangan' => 'nullable|string|max:255',
        //     'panjang' => 'nullable|integer|min:1',
        //     'lebar' => 'nullable|integer|min:1',
        //     'kondisi' => 'required|in:Baik,Rusak',
        //     'spesifikasi' => 'nullable|string',
        //     'keterangan' => 'nullable|string',
        // ]);

        // dd($request->all());
        $validated = $request->validate([
            'barang_id' => 'required|array', // Memastikan barang_id adalah array
            'barang_id.*' => 'integer|exists:inventaris,id', // Setiap elemen di dalam array harus integer dan ada di tabel barang
        ]);
        $cekData = KIBC::get()->pluck('barang_id');
        // dd($cekData);

        // dd($request->all());
        foreach ((array) $request->barang_id as $IdBarang) {
            $cekData = Inventaris::where('id', $IdBarang)->first();

            if (!$cekData) {
                continue; // Skip jika barang tidak ditemukan
            }

            $jumlahKodeSama = KIBC::where('barang_id', $IdBarang)->count();
            $kodeBaru = $cekData->kode . '-' . str_pad($jumlahKodeSama + 1, 3, '0', STR_PAD_LEFT);

            $dataInsert = [
                'barang_id' => $IdBarang,
                'kode_ruangan' => $kodeBaru,
                'nama_ruangan' => $cekData->nama_barang,
                'panjang' => 0,
                'lebar' => 0,
                'spesifikasi' => 'Belum dijelaskan',
                'keterangan' => 'Belum ada',
            ];
            KIBC::create($dataInsert); // Tetap insert meskipun jumlahKodeSama = 0
        }
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, KIBC $kibc)
    {
        //

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
                'nama_ruangan' => 'nullable|string|max:255',
                'panjang' => 'nullable|integer|min:1',
                'lebar' => 'nullable|integer|min:1',
                'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Sedang,Rusak Berat',
                'spesifikasi' => 'nullable|string',
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
        $varmodel = KIBC::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //KIBC
        // dd(id);
        // dd(request->all());
        $data = KIBC::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
