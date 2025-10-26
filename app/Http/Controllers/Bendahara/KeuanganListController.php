<?php

namespace App\Http\Controllers\Bendahara;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bendahara\KeuanganList;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class KeuanganListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        /*
               Validasi untuk di form
               Class : KeuanganList
               Lanjutkan isi validasi
               @if ($errors->any())
                   <div class='alert alert-danger my-2'>
                       <ul class='mb-0'>
                       @foreach ($errors->all() as $error)
                           <li>{{ $error }}</li>
                       @endforeach
                       </ul>
                   </div>
               @endif
               */
        // dd($request->all());
        // $etapels = Etapel::where('aktiv', 'Y')->first();
        // $request->merge([
        //     'tapel_id' => $etapels->id,
        //     'semester' => $etapels->semester
        // ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            // 'nominal' => 'required|numeric',
            // 'petugas_id' => 'required|numeric',
            'kategori' => 'required|string|min:3|max:255',
            'singkatan' => 'required|string|min:3|max:255',
            'jenis_pembayaran' => 'required|string|min:3|max:255',
            'keterangan' => 'required|string|min:3|max:255',

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
        KeuanganList::create($validator->validated());
        // dd($request->all());
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data berhasil disimpan dan ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(KeuanganList $keuanganList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KeuanganList $keuanganList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        //
        /*
               Validasi untuk di form
               Class : KeuanganList
               Lanjutkan isi validasi
               @if ($errors->any())
                   <div class='alert alert-danger my-2'>
                       <ul class='mb-0'>
                       @foreach ($errors->all() as $error)
                           <li>{{ $error }}</li>
                       @endforeach
                       </ul>
                   </div>
               @endif
               */
        // dd($request->all());

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'singkatan' => 'required|string|min:3|max:255',
            'jenis_pembayaran' => 'required|string|min:3|max:255',
            'keterangan' => 'required|string|min:3|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Menyimpan data menggunakan mass assignment
        $keuangan = KeuanganList::find($id); // Pastikan $id didefinisikan atau diterima dari request
        if ($keuangan) {
            $keuangan->update($validator->validated());
            return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil di Update');
        } else {
            return redirect()->back()->withErrors(['error' => 'Data tidak ditemukan.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //KeuanganList
        // dd(id);
        // dd(request->all());
        $VarKeuanganList = KeuanganList::findOrFail($id);
        $VarKeuanganList->delete();

        return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
