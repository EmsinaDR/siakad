<?php

namespace App\Http\Controllers\Perpustakaan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\Perpustakaan\PerpustakaanKategoriBuku;


class PerpustakaanKategoriBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = PerpustakaanKategoriBuku::latest()->paginate(10);
        return view('role.Perpustakaan.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('role.Perpustakaan.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode'          => 'required|unique:perpustakaan_kategori_buku,kode|max:50',
            'nama_kategori' => 'required|string|max:255',
            'keterangan'    => 'nullable|string',
        ]);
        // dd($request->all());
        PerpustakaanKategoriBuku::create($validated);
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(PerpustakaanKategoriBuku $perpustakaanKategoriBuku)
    {
        return view('role.Perpustakaan.kategori.show', compact('perpustakaanKategoriBuku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerpustakaanKategoriBuku $perpustakaanKategoriBuku)
    {
        return view('role.Perpustakaan.kategori.edit', compact('perpustakaanKategoriBuku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerpustakaanKategoriBuku $perpustakaanKategoriBuku)
    {
        $validated = $request->validate([
            'kode'          => 'required|max:50|unique:perpustakaan_kategori_bukus,kode,' . $perpustakaanKategoriBuku->id,
            'nama_kategori' => 'required|string|max:255',
            'keterangan'    => 'nullable|string',
        ]);

        $perpustakaanKategoriBuku->update($validated);

        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data telah tersimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerpustakaanKategoriBuku $perpustakaanKategoriBuku)
    {
        $perpustakaanKategoriBuku->delete();

        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data telah terhapus');
    }
}
