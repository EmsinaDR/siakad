<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class EtapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'E Tahun Pelajaran';
        $arr_ths = [
            'Tahun Pelajaran' => 'tapel',
            'Semester Aktiv' => 'semester'
        ];
        $breadcrumb = 'Admin / Pengaturan E Tapel';
        $titleviewModal = 'Lihat Data E Tahun Pelajaran';
        $titleeditModal = 'Edit Data E Tahun Pelajaran';
        $titlecreateModal = 'Create Data E Tahun Pelajaran';
        $dataTapels = Cache::tags(['chace_dataTapels'])->remember('remember_dataTapels', now()->addHours(12), function () {
            return Etapel::select('id', 'tapel', 'semester')->get();
        });
        $etapelsNext = Cache::tags(['etapelNext'])->remember('etapelNext', now()->addHours(2), function () {
            return Etapel::select('tapel')->get()->max();
        });
        // $etapelsNextId = Etapel::select('tapel')->get()->max();

        return view('admin.user.etapel', compact('title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal', 'dataTapels', 'etapelsNext'));
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
    public function show(etapel $etapel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(etapel $etapel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        //
        $datamapel = $request->all();
        $etapelMax = etapel::select('tapel')->get()->max();
        $CekId = etapel::find($id);
        // dd($etapelMax->tapel);
        // dd($CekId);
        if ($CekId === null) {
            etapel::where('aktiv', 'Y')->update(['aktiv' => 0]);
            etapel::insert([
                'tapel' => $etapelMax->tapel + 1,
                'semester' => 'I',
                'aktiv' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),

            ]);
            etapel::insert([
                'tapel' => $etapelMax->tapel + 1,
                'semester' => 'II',
                'aktiv' => 0,
                'created_at' => now(),
                'updated_at' => now(),

            ]);
        } else {
            // $hasil = 'no';
            etapel::where('aktiv', 'Y')->update(['aktiv' => 0]);
            etapel::where('id', $id)->update(['aktiv' => 'Y']);
        }

        return redirect()->route('etapel.index')->with('Title', 'Data Berhasil Diperbaharui')->with('Success', 'Data  berhasil diperbaharui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(etapel $etapel)
    {
        //
    }
}
