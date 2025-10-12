<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\ekaldik;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// use Illuminate\Foundation\Auth\User;

class EkaldikController extends Controller
{
    /*
           * Display a listing of the resource.
           Folder Name = Keladik
           Model = Ekaldik
           Variabel Model = ekaldik
           */
    public function index(EKaldik $ekaldik, User $user)
    {
        // View All Data
        // Variabel kirima ke halaman
        $datas = Ekaldik::with('KaldikTapel')->get();
        $title = 'Data E Kaldik';
        $arr_ths = [
            'Kegiatan',
            'Rencana Anggaran',
            'Penanggung Jawab',
            'Tanggal Pelaksanaan'
        ];
        $breadcrumb = "E Kaldik / Data Kaldik";
        $tapele = Etapel::whereColumn('aktivasi', 1)->first(['name', 'id']);
        $titleviewModal = "Lihat Data E Kaldik";
        $titleeditModal = "Edit Data E Kaldik";
        $titlecreateModal = "Create Data E Kaldik";
        $users = Detailguru::orderBy('nama_guru', 'ASC')->get();
        // $users = User::WhereIn('posisi', ['Guru', 'Karyawan'])->get();
        // Variabel kirima ke halaman


        // ini hasil pengecekan role
        // $wakakur = $user->cekusert('Waka Kurikulum');
        // dd($cek);


        // dd($users->roles->name);
        return view('umum.ekaldik.index', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'tapele',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'users',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Form Create
        return view('Keladik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Untuk Proses Create
        // dd($request->all());
        $request['penanggung_jawab'] = implode(",", $request->penanggung_jawab);
        $request['created_at'] = now();
        // dd($request['penanggung_jawab']);
        $data = $request->all();
        $data['created_at'] = now();
        $data['updated_at'] = now();
        $data = $request->except(['_token']);
        // DB::table('ekaldiks')->insert($data);
        Ekaldik::insert($data);
        return redirect()->route('ekaldik.index')->with('Success', 'Data Sukses Ditambahkan');
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
        $datas = Ekaldik::findOrFail($request->id);
        $title = 'Edit titleedit';
        return view('Keladik.show', compact('datas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Proses Update dari Edit
        // dd($request->all());
        // dd($request->all());
        $request->merge([
            // 'penanggung_jawab' => $request->penanggung_jawab,
            // 'penanggung_jawab' => implode(",", (array) $request->penanggung_jawab),
            'updated_at' => now(),
        ]);

        $ekaldik = Ekaldik::findOrFail($id);
        $data = $request->except(['_token', 'id']); // Hindari overwrite ID yang sudah ada

        $ekaldik->update($data);

        // dd($request->all());
        Session::flash('success', 'Data Berhasil Diperbaharui');
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $varClassModel = ekaldik::findOrFail($id);
        $varClassModel->delete();

        Session::flash('success', 'Data Berhasil Dihapus');
        return Redirect::back();
    }
}
