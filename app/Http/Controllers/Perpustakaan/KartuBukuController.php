<?php

namespace App\Http\Controllers\Perpustakaan;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\Perpustakaan\KartuBuku;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\Perpustakaan\Eperpuskatalog;

class KartuBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Kartu Buku';
        $arr_ths = [
            'Judul Buku',
            'Nama Penulis',
            'Nama Penerbit',
            'Tahun Terbit'
        ];
        $breadcrumb = 'Perpustakaan / Kartu Buku';
        $titleviewModal = 'Lihat Data Kartu Buku';
        $titleeditModal = 'Edit Data Kartu Buku';
        $titlecreateModal = 'Create Data Kartu Buku';
        $DataKatalog = Cache::tags(['cache_DataKatalog'])->remember('remember_DataKatalog', now()->addHours(2), function () {
            return Eperpuskatalog::get();
        });

        return view('role.Perpustakaan.kartu-buku', compact('DataKatalog', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
    public function exportBuKuKartu()
    {
        // $datas = Eperpuskatalog::limit(20)->get();
        $datas_kartubuku = Cache::tags(['cache_datas_kartubuku'])->remember('remember_datas_kartubuku', now()->addHours(2), function () {
            return Eperpuskatalog::limit(20)->get();
        });

        $pdf = Pdf::loadView('role.Perpustakaan.kartu-buku-cetak', compact('datas_kartubuku'));

        // Atur opsi PDF
        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true, // untuk load <img> dari public_path atau URL
            'dpi' => 150,
        ]);

        // Tampilkan di browser
        return $pdf->stream('Data Kartu Buku.pdf');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        HapusCacheDenganTag('datas_kartubuku');
        HapusCacheDenganTag('DataKatalog');
    }

    /**
     * Display the specified resource.
     */
    public function show(KartuBuku $kartuBuku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KartuBuku $kartuBuku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KartuBuku $kartuBuku)
    {
        //
        HapusCacheDenganTag('datas_kartubuku');
        HapusCacheDenganTag('DataKatalog');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KartuBuku $kartuBuku)
    {
        //
    }
    public function KartuPeminjaman()
    {
        //dd($request->all());
        //Title to Controller
        $title = 'Kartu Peminjaman';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad'
        ];
        $breadcrumb = 'Perpustakaan / Kartu Peminjaman';
        $titleviewModal = 'Lihat Data Kartu Peminjaman';
        $titleeditModal = 'Edit Data Kartu Peminjaman';
        $titlecreateModal = 'Create Data Kartu Peminjaman';
        $datas = Detailsiswa::whereNotNull('kelas_id')->get();
        HapusCacheDenganTag('datas_kartubuku');
        HapusCacheDenganTag('DataKatalog');


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.Perpustakaan.kartu-peminjaman', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
    public function exportPdfKartuPeminjaman(Request $request)
    {
        $IdSiswa = range(1,50);
        if(count($IdSiswa) >= 1){
            $datas_kartubuku = Detailsiswa::whereIn('kelas_id', $IdSiswa)->get();
        }else{
            $datas_kartubuku = Detailsiswa::whereNotNull('kelas_id')->get();
        }


        $pdf = Pdf::loadView('role.Perpustakaan.export-kartu-peminjaman', compact('datas_kartubuku'));

        // Atur opsi PDF
        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true, // untuk load <img> dari public_path atau URL
            'dpi' => 150,
        ]);

        // Tampilkan di browser
        return $pdf->stream('namaFile.pdf');

        // Atau simpan ke storage
        // Storage::put('laporan/Laporan-Siswa.pdf', $pdf->output());

        // Atau download langsung
        // return $pdf->download('Laporan-Siswa.pdf');
    }
}
