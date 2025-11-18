<?php

namespace App\Http\Controllers\Perpustakaan;

use App\Models\User;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Perpustakaan\Eperpuskatalog;
use App\Models\Perpustakaan\Eperpuspeminjam;
use App\Models\Perpustakaan\PerpustakaanKategoriBuku;

class EperpuskatalogController extends Controller
{
    //
    public function index()
    {
        //dd($request->all());
        //Title to Controller
        $title = 'Katalog Buku Perpustakaan';
        $arr_ths = [
            'Image',
            'Kode Buku',
            'Judul Buku',
            'Penulis',
            'Tesedia'
        ];
        $breadcrumb = 'Perpustakaan / Katalog Buku';
        $titleviewModal = 'Lihat Data Katalog Buku';
        $titleeditModal = 'Edit Data Katalog Buku';
        $titlecreateModal = 'Create Data Katalog Buku';
        $datas = Eperpuskatalog::get();
        $data_riwayat_peminjaman = Cache::tags(['cache_data_riwayat_peminjaman'])->remember('remember_data_riwayat_peminjaman', now()->addHours(2), function () {
            return Eperpuspeminjam::select('buku_id', DB::raw('COUNT(*) as total_peminjaman'))
                ->groupBy('buku_id')
                ->orderBy('total_peminjaman', 'DESC')->get();
        });

        $DataUserSekolah = Cache::tags(['cache_DataUserSekolah'])->remember('remember_DataUserSekolah', now()->addHours(2), function () {
            return User::whereIn('posisi', ['Guru', 'Karyawan', 'Kepamad', 'Kepala', 'Siswa'])->count();
        });
        $KategoriBuku = Cache::tags(['Cache_KategoriBuku'])->remember('Remember_KategoriBuku', now()->addMinutes(10), function () {
            return PerpustakaanKategoriBuku::get();
        });
        return view('role.Perpustakaan.katalog-buku', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'data_riwayat_peminjaman',
            'KategoriBuku',
            'DataUserSekolah'
        ));
    }
    public function store(Request $request)
    {
        //dd($request->all());
        // Validasi data
        $validator = Validator::make($request->all(), [
            'kode_buku'      => 'required|string|max:50',
            'kategori_id'     => 'required|numeric|min:0',
            'judul_buku'     => 'required|string|max:255',
            'tahun_terbit'   => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'baik'           => 'required|integer|min:0',
            'rusak'          => 'required|integer|min:0',
            'harga'          => 'required|numeric|min:0',
            'penerbit'       => 'string|max:255',
            'penulis'       => 'string|max:255',
            'isbn' => 'nullable|string|max:255|unique:perpustakaan_katalog_buku,isbn',
            'sumber_dana' => 'required|string|max:50',
            'keterangan'     => 'nullable|string|max:500',
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
        Eperpuskatalog::create($validator->validated());
        Session::flash('success', 'Data Berhasil Dihapus');
        HapusCacheDenganTag('DataUserSekolah');
        HapusCacheDenganTag('data_riwayat_peminjaman');
        return Redirect::back();
    }

    public function update($id, Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'kode_buku'      => 'required|string|max:50',
            'kategori_id'     => 'required|numeric|min:0',
            'judul_buku'     => 'required|string|max:255',
            'tahun_terbit'   => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'baik'           => 'required|integer|min:0',
            'rusak'          => 'required|integer|min:0',
            'harga'          => 'required|numeric|min:0',
            'penerbit'       => 'string|max:255',
            'penulis'       => 'string|max:255',
            'isbn' => 'nullable|string|max:255|unique:perpustakaan_katalog_buku,isbn',
            'sumber_dana' => 'required|string|max:50',
            'keterangan'     => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $varmodel = Eperpuskatalog::find($id); // Pastikan $id didefinisikan atau diterima dari request
        // dd($request->sumber_dana);
        // dd($varmodel);
        if ($varmodel) {
            $varmodel->update($validator->validated());
            HapusCacheDenganTag('DataUserSekolah');
            HapusCacheDenganTag('data_riwayat_peminjaman');
            return Redirect::back()->with('Title', 'Berhasil')->with('success', 'Data Berhasil di Update');
        } else {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Data tidak ditemukan');
        }
    }
    public function destroy($id)
    {
        //
        $varEperpuskatalog = Eperpuskatalog::findOrFail($id);
        $varEperpuskatalog->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}


// php artisan make:view role.perpustakaan.index