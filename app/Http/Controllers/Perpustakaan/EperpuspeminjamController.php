<?php

namespace App\Http\Controllers\Perpustakaan;

use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Perpustakaan\Eperpuskatalog;
use App\Models\Perpustakaan\Eperpuspeminjam;
use App\Models\Perpustakaan\PerpustakaanKategoriBuku;

class EperpuspeminjamController extends Controller
{
    //
    public function index()
    {
        //dd($request->all());
        //Title to Controller
        $title = 'Data Peminjaman Buku';
        $arr_ths =
            [
                'Nama Siswa',
                'Judul Buku',
                'Tanggal Peminjaman',
                'Tanggal Pengembalian',
                'Status',

            ];
        $breadcrumb = 'Perpustakaan / Data Peminjaman Buku';
        $titleviewModal = 'Lihat Data Peminjaman Buku';
        $titleeditModal = 'Edit Data Peminjaman Buku';
        $titlecreateModal = 'Create Data Peminjaman Buku';
        $dataPeminjaman = Cache::tags(['Cache_dataPeminjaman'])->remember('Remember_dataPeminjaman', now()->addMinutes(10), function () {
            return Eperpuspeminjam::with('siswa')->orderBy('created_at', 'DESC')->get();
        });

        $listdata = Cache::tags(['Cache_lisdata'])->remember('Remember_lisdata', now()->addMinutes(2), function () {
            return Detailsiswa::get();
        });

        $buku_ids = Cache::tags(['Cache_buku_ids'])->remember('Remember_buku_ids', now()->addMinutes(2), function () {
            return Eperpuskatalog::get();
        });

        return view('role.Perpustakaan.peminjaman', compact('buku_ids', 'listdata', 'dataPeminjaman', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
    public function update($id, Request $request)
    {
        $dataUpdate = Eperpuspeminjam::where('id', $id)->first();
        $dataUpdate->status = $request->status;
        $dataUpdate->update();

        HapusCacheDenganTag('buku_ids');
        HapusCacheDenganTag('lisdata');
        HapusCacheDenganTag('dataPeminjaman');
        Session::flash('success', 'Data Berhasil Diperbaharui');
        return Redirect::back();
    }
    public function store(Request $request)
    {
        $tanggalPeminjaman = Carbon::now(); // Tanggal hari ini
        $batasPengembalian = $tanggalPeminjaman->addDays(3); // Menambahkan 3 hari
        $request->merge([
            'detailsiswa_id' => $request->detailsiswa_id,
            'tanggal_peminjaman' => $tanggalPeminjaman,
            'batas_pengembalian' => $batasPengembalian,
            'status' => 'dipinjam',
        ]);
        // Validasi data
        $validator = Validator::make($request->all(), [
            'detailsiswa_id' => 'nullable|exists:detailsiswas,id',
            'buku_id' => 'required|array', // buku_id harus berupa array
            'buku_id.*' => 'exists:perpustakaan_katalog_buku,id', // Setiap elemen buku_id harus ada di database
            'kategori_id' => 'nullable|exists:perpustakaan_kategori_buku,id',
            'tanggal_peminjaman' => 'required|date',
            'batas_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman',
            // 'tanggal_pengembalian' => 'nullable|date|after_or_equal:tanggal_peminjaman',
            'status' => 'required|in:dipinjam,dikembalikan,terlambat',
            'keterangan' => 'nullable|string',
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Loop untuk menyimpan setiap buku yang dipinjam
        foreach ($request->buku_id as $buku) {
            $kategori = Eperpuskatalog::where('id', $buku)->first();
            // dd($kategori->kategori_id);
            Eperpuspeminjam::create([
                'detailsiswa_id' => $request->detailsiswa_id,
                'buku_id' => $buku, // Menyimpan per buku
                'kategori_id' => $kategori->kategori_id,
                'tanggal_peminjaman' => now(),
                'batas_pengembalian' => Carbon::now()->addDays(3), // Tambah 3 hari
                // 'tanggal_pengembalian' => $request->tanggal_pengembalian,
                'status' => $request->status,
                'keterangan' => $request->keterangan,
            ]);
        }

        // dd($request->all());

        HapusCacheDenganTag('buku_ids');
        HapusCacheDenganTag('lisdata');
        HapusCacheDenganTag('dataPeminjaman');

        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function destroy($id)
    {
        //ClassName
        // dd(id);
        // dd(request->all());
        $data = Eperpuspeminjam::findOrFail($id);
        $data->delete();
        Session::flash('success', 'Data Berhasil Dihapus');
        return Redirect::back();
    }
    // public function AjaxPeminjam($detailsiswa_id)
    // {
    //     //dd($request->all());
    //     // $data = Eperpuspeminjam::where('detailsiswa_id', $detailsiswa_id)->get();
    //     $data = Eperpuspeminjam::with(['siswa', 'buku', 'KategoriBuku'])->where('detailsiswa_id', $detailsiswa_id)->orderBy('created_at', 'DESC')->get();

    //     if ($data->isNotEmpty()) {
    //         return response()->json($data);
    //     }

    //     return response()->json(['error' => 'Data tidak ditemukan'], 404);
    // }
    public function AjaxPeminjam($detailsiswa_id)
    {
        $data = Eperpuspeminjam::with(['siswa', 'buku', 'kategoriBuku']) // 'kategoriBuku' bukan di dalam 'buku'
            ->where('detailsiswa_id', $detailsiswa_id)
            ->orderBy('created_at', 'DESC')
            ->get();
        if ($data->isNotEmpty()) {
            return response()->json($data);
        }


        HapusCacheDenganTag('buku_ids');
        HapusCacheDenganTag('lisdata');
        HapusCacheDenganTag('dataPeminjaman');
        // Ubah dari 'error' => 'Data tidak ditemukan' menjadi array kosong
        return response()->json([]);
    }
}
