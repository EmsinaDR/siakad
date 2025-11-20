<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Peraturan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PeraturanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
        $DataPeraturans = Cache::tags(['chace_DataPeraturans'])->remember('remember_DataPeraturans', now()->addHours(2), function () {
            return Peraturan::where('kategori', 'Perpustakaan')->get();
        });

        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.Perpustakaan.peraturan-perpustakaan', compact('DataPeraturans', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
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
        // dd($request->all());
        // Validasi data
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|string|max:255',
            'peraturan' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
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
        Peraturan::create($validator->validated());
        HapusCacheDenganTag('chace_DataPeraturans');
        Session::flash('success', 'Data Berhasil Ditambahkan');
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Peraturan $peraturan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peraturan $peraturan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        //
        // Validasi data
        // Validasi data
        $validator = Validator::make($request->all(), [
            'peraturan' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
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
        $varmodel = Peraturan::find($id); // Pastikan $id didefinisikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($validator->validated());
            HapusCacheDenganTag('chace_DataPeraturans');
            return Redirect::back()->with('Title', 'Berhasil')->with('success', 'Data Berhasil di Update');
        } else {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Data tidak ditemukan');
        }
        Session::flash('success', 'Data Berhasil Perbaharui');
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $varPeraturan = Peraturan::findOrFail($id);
        $varPeraturan->delete();
        HapusCacheDenganTag('chace_DataPeraturans');

        Session::flash('success', 'Data Berhasil Dihapus');
        return Redirect::back();
    }
}
