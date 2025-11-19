<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Bendahara\KomiteDokumen;
use Illuminate\Http\Request;

class KomiteDokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Dokumen Bendahara Komite';
        $arr_ths = [
            'Nama Dokumen',
            // 'title_tabelab',
            // 'title_tabelac',
            // 'title_tabelad',
        ];
        $breadcrumb = 'Bendahara / Bendahara Komite / Dokumen';
        $titleviewModal = 'Lihat Data Dokumen Bendahara Komite';
        $titleeditModal = 'Edit Data Dokumen Bendahara Komite';
        $titlecreateModal = 'Create Data Dokumen Bendahara Komite';

        $datas = '';
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.bendahara.komite.dokumen', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
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
    public function show(KomiteDokumen $KomiteDokumen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KomiteDokumen $KomiteDokumen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KomiteDokumen $KomiteDokumen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KomiteDokumen $KomiteDokumen)
    {
        //
    }
}
