<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Pest\Support\Str;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Admin\Identitas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class IdentitasController extends Controller
{
    //
    public function index()
    {
        $root = 'Home';
        $breadcrumb = 'Home / Identitas Sekolah';

        // return $identitas;
        // dd($identitas);
        $title = 'Identitas Sekolah';
        return view('admin.identitas.index', compact('title', 'breadcrumb'));
    }
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'regis' => 'nullable|string|max:255',
            'paket' => 'nullable|string|max:255',
            'jenjang' => 'required|string|max:255',
            'nomor' => 'nullable|string|max:255',
            'kode_sekolahan' => 'nullable|string|max:255',
            'kode_kabupaten' => 'nullable|string|max:255',
            'kode_provinsi' => 'nullable|string|max:255',
            'namasingkat' => 'nullable|string|max:255',
            'namasek' => 'nullable|string|max:255',
            'nsm' => 'nullable|string|max:255',
            'npsn' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'akreditasi' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'logo' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'desa' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:255',
            'namakepala' => 'nullable|string|max:255',
            'visi' => 'nullable|string|max:255',
            'misi' => 'nullable|string|max:255',
            'tujuan' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'facebook_fanspage' => 'nullable|string|max:255',
            'facebook_group' => 'nullable|string|max:255',
            'twiter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'whatsap_group' => 'nullable|string|max:255',
            'internet' => 'nullable|string|max:255',
            'speed' => 'nullable|string|max:255',
        ]);

        // Simpan data ke database
        $identitas = Identitas::create($validated);
        $validated = $request->validate([
            'detailguru_id' => 'nullable|exists:detailgurus,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        // Pembuatan User Admin
        $user = new User();
        $user->posisi = 'Admin';
        $user->aktiv = 'Y';
        $user->detailguru_id = Null;
        $user->name = 'Admin Sekolah';
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->email_verified_at = now(); // Atur waktu verifikasi email
        $user->remember_token = Str::random(60);
        $user->save();


        // Redirect atau response setelah berhasil menyimpan
        return redirect()->route('identitas.show', $identitas->id)->with('success', 'Data identitas berhasil disimpan!');
    }
    public function update($id, Request $request)
    {
        //Proses Modal Update
        //Form Modal Update ada di index dengan Modal
        // dd($request->all());
        $data = $request->except(['_token', '_method']);
        // dd($data);
        $data = Identitas::findOrFail($id);
        $data->namasek = $request->namasek;
        $data->nsm = $request->nsm;
        $data->npsn = $request->npsn;
        $data->status = $request->status;
        $data->akreditasi = $request->akreditasi;
        $data->alamat = $request->alamat;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->namakepala = $request->namakepala;
        // $data->paket = $request->paket;
        $data->updated_at = $request->updated_at;
        $data->updated_at =  now();
        $data->update();
        HapusCacheDenganTag('identitas_sekolah');
        return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  berhasil diperbaharui');
    }


    public function destroy($id)
    {
        $data = Identitas::findOrFail($id);
        $data->delete();
        HapusCacheDenganTag('identitas_sekolah');

        return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
    }

    /*



    CRUD
    Create
    Read All
    Read Single
    Update
    Delete

    Class Name : Indentitas
    Title View Single Data : Identitas Sekolah
    Blade View Single Data : indentitas.index

    Title View All Data : newtitleAll
    Blade View All Data : bladeviewall

    Title View editblade Data : Identitas
    Blade View editblade Data : identitas.edit




    */

    // //------> CRUD Awal
    // public function Create(Request $request)
    // {
    //     $data = $request->all();
    //     $data = $request->except(['field']);
    //     $IndentitasQuery = Indentitas::create($data);
    //     return redirect()->route('CreateIndentitas');
    // }
    // public function Readsingle($id)
    // {
    //     $data = Indentitas::find($id);
    //     $title = 'Identitas Sekolah';
    //     return view('folder.indentitas.index', compact('data', 'title'));
    // }
    // public function ReadData()
    // {
    //     $data = Indentitas::get();
    //     $title = 'newtitleAll';
    //     return view('folder.bladeviewall' . 'dataall', compact('data', 'title'));
    // }
    // public function Update($id)
    // {
    //     $data = Indentitas::find($id);
    //     $title = 'Edit Identitas';
    //     return view('folder.identitas.edit', compact('data'));
    // }
    // public function PUpdate(Request $request)
    // {
    //     $data = $request->all();
    //     $data = $request->except(['field']);
    //     $IndentitasQuery = Indentitas::where('id', $request->id)->update($data);
    //     return redirect()->route('UpdateIndentitas');
    // }
    // public function Delete(Request $request)
    // {
    //     Indentitas::where('id', $request->id)->delete();
    //     //Indentitas::find($id)->delete();
    //     return redirect()->route('DeleteIndentitas');
    // }
    // //------> CRUD Akhir
}
