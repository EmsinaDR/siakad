<?php

namespace App\Http\Controllers\Perpustakaan;

use Illuminate\Http\Request;
use App\Models\Admin\Peraturan;
use App\Http\Controllers\Controller;
use App\Models\Perpustakaan\PengaturanPerpustakaan;

class PengaturanPerpustakaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Title to Controller
                $title = 'Pengaturan Perpustakaan';
                $arr_ths = [
                    'title_tabela',
                    'title_tabelab',
                    'title_tabelac',
                    'title_tabelad'
                ];
                $breadcrumb = 'Pengaturan / Perpustakaan';
                $titleviewModal = 'Lihat Data Pengaturan Perpustakaan';
                $titleeditModal = 'Edit Data Pengaturan Perpustakaan';
                $titlecreateModal = 'Create Data Pengaturan Perpustakaan';
                $datas ='';


               //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.Perpustakaan.pengaturan', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
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
    }

    /**
     * Display the specified resource.
     */
    public function show(PengaturanPerpustakaan $pengaturanPerpustakaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengaturanPerpustakaan $pengaturanPerpustakaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengaturanPerpustakaan $pengaturanPerpustakaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengaturanPerpustakaan $pengaturanPerpustakaan)
    {
        //
    }

    public function PeraturanPerpustakaan()
    {
        //
        //Title to Controller
        $title = 'Peraturan Perpustakaan';
        $arr_ths = [
            'Peraturan',
            'Keterangan',
        ];
        $breadcrumb = 'Perpustakaan / Peraturan';
        $titleviewModal = 'Lihat Data Peraturan Perpustakaan';
        $titleeditModal = 'Edit Data Peraturan Perpustakaan';
        $titlecreateModal = 'Create Data Peraturan Perpustakaan';
        $datas = Peraturan::where('kategori', 'Perpustakaan')->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.Perpustakaan.peraturan-perpustakaan', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }

}
