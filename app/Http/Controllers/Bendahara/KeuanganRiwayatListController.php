<?php

namespace App\Http\Controllers\Bendahara;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Bendahara\KeuanganList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Bendahara\KeuanganRiwayatList;

class KeuanganRiwayatListController extends Controller
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
        // $request->kategori = 'komite';
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        foreach ($request->jenis_pembayaran as $pembayaran) {
            // $jenis_pembayaran_in = find()
            $singkatan = KeuanganList::select('singkatan')->where('jenis_pembayaran', $pembayaran)->first();
            // dd($singkatan);
            DB::table('keuangan_riwayat_lists')->insert([
                'petugas_id' => Auth::user()->detailguru_id,
                'tapel_id' => $etapels->id,
                'semester' => $etapels->semester,
                'tingkat_id' => $request->tingkat_id,
                'singkatan' => $singkatan->singkatan,
                'kategori' => 'komite',
                'jenis_pembayaran' => $pembayaran,
                'created_at' => now(),
                'updated_at' => now(),


            ]);
        }
        // dd($request->all());
        return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(KeuanganRiwayatList $KeuanganRiwayatList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KeuanganRiwayatList $KeuanganRiwayatList)
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
               Class : ModelClass
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

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            // 'name' => 'required|string|max:255',
            'nominal' => 'required|numeric',
        ]);
        // dd($request->all());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Menyimpan data menggunakan mass assignment
        // Create : Buat
        // Update : Memperbaharui
        // Menyimpan data menggunakan mass assignment
        $varmodel = KeuanganRiwayatList::find($id); // Pastikan $id didefinisikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($validator->validated());

            return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil di Update');
        } else {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Data tidak ditemukan');
        }
    }
    public function BulkUpdate(Request $request)
    {
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            // 'name' => 'required|string|max:255',
            'nominal' => 'required|array',
            'nominal.*' => 'numeric',  // Pastikan setiap elemen dalam array nominal adalah angka
            'id' => 'required|array',
            'jenis_pembayaran' => 'required|array',
        ]);
        // dd($request->all());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Proses pembaruan data
        $ids = $request->input('id');
        $jenisPembayaran = $request->input('jenis_pembayaran');
        $nominals = $request->input('nominal');

        foreach ($ids as $index => $id) {
            $data = [
                'tapel_id' => $etapels->id,
                'semester' => $etapels->semester,
                'jenis_pembayaran' => $jenisPembayaran[$index] ?? null,
                'nominal' => $nominals[$index] ?? null,
            ];

            // Pastikan data tersedia sebelum memperbarui
            if ($data['jenis_pembayaran'] !== null && $data['nominal'] !== null) {
                KeuanganRiwayatList::where('id', $id)->update($data);
            }
        }

        // dd($request->all());
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data berhasil diperbaharui');

        //BulkUpdate Nominal
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //KeuanganRiwayatList
        // dd(id);
        // dd(request->all());
        $VarKeuanganRiwayatList = KeuanganRiwayatList::findOrFail($id);
        $VarKeuanganRiwayatList->delete();

        return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahapus Berhasil dihapus dari databse');
    }
    //ajax
    public function getPembayaranTingkat($id)
    {
        //dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $data = KeuanganRiwayatList::select('id', 'jenis_pembayaran', 'nominal')->where('tingkat_id', $id)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->get();
        // dd($data);
        // dd($etapels->semester);
        // $data = KeuanganRiwayatList::select('jenis_pembayaran')->where('tingkat_id', $id)->where('tapel_id', $etapels->id)->get();
        return response()->json($data);
    }
}
