<?php

namespace App\Http\Controllers\WakaSarpras\Inventaris;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaSarpras\Inventaris\KIBA;
use App\Models\WakaSarpras\Inventaris\Inventaris;

class KIBAController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /*
     KIBA
     $kiba
     role.waka.sarpras
     role.waka.sarpras.inventaris.kiba
     role.waka.sarpras.blade_show
     Index = Data KIB A
     Breadcume Index = 'Waka Sarpras / Data KIB A';
     Single = Data KIB A
     php artisan make:view role.waka.sarpras.inventaris.kiba
     php artisan make:view role.waka.sarpras.inventaris.kiba-single
     php artisan make:seed KIBASeeder



     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data KIB A';
        $arr_ths = [
            'Nama Barang',
            'Letak',
            'Luas',
            'Tahun',
            'Penggunaan',
        ];
        $breadcrumb = 'Waka Sarpras / Data KIB A - Tanah';
        $titleviewModal = 'Lihat Data KIB A';
        $titleeditModal = 'Edit Data KIB A';
        $titlecreateModal = 'Create Data KIB A';
        $datas = KIBA::orderBY('created_at', 'DESC')->get();
        $dataInventaris = Inventaris::orderBY('created_at', 'DESC')->get();
        // dd($dataInventaris);


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.kiba', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.waka.sarpras.inventaris.kiba

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data KIB A';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Sarpras / Data KIB A';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = KIBA::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.kiba-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.sarpras.inventaris.kiba-single
    }

    public function store(Request $request)
    {
        //

        $validated = $request->validate([
            'barang_id' => 'required|array', // Memastikan barang_id adalah array
            'barang_id.*' => 'integer|exists:inventaris,id', // Setiap elemen di dalam array harus integer dan ada di tabel barang
        ]);
        $cekData = KIBA::get()->pluck('barang_id');
        // dd($cekData);

        // dd($request->all());
        foreach ($request->barang_id as $IdBarang) {
            if ($cekData->contains($IdBarang)) {
                continue;
            } else {
                KIBA::create([
                    'barang_id' => $IdBarang,
                ]);
            }
        }
        Session::flash('success', 'Data Berhasil Disimpan');
        // dd($request->all());
        return Redirect::back();
    }
    public function update($id, Request $request, KIBA $kiba)
    {
        //

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'barang_id' => 'nullable|integer', // Jika tidak null, harus integer
            'nama_barang' => 'nullable|string|max:255', // Maksimal 255 karakter
            'letak' => 'nullable|string|max:255',
            'luas' => 'nullable|integer', // Jika ada nilai, harus integer
            'tahun_masuk' => 'nullable|string|max:4', // Tahun dalam format 4 digit
            'status_hak' => 'nullable|string|in:Milik,Sewa,Hibah,Pinjaman,Guna Pakai', // Pilihan tetap
            'penggunaan' => 'nullable|string|max:255',
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
        $varmodel = KIBA::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //KIBA
        // dd(id);
        // dd(request->all());
        $data = KIBA::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
