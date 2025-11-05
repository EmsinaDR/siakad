<?php

namespace App\Http\Controllers\Aplikasi\Fitur;

use App\Models\Aplikasi\Fitur\FiturAplikasi;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class FiturAplikasiController extends Controller
{
    public function index()
    {
        $title = 'FiturAplikasiController';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = \App\Models\Aplikasi\Fitur\FiturAplikasi::where('tapel_id', $etapels->id)->get();

        return view('fituraplikasi.index', compact('title', 'datas'));
    }

    public function store(Request $request)
    {
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge(['tapel_id' => $etapels->id]);

        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        \App\Models\Aplikasi\Fitur\FiturAplikasi::create($validator->validated());
        Session::flash('success', 'Data berhasil disimpan');
        return Redirect::back();
    }

    public function update(Request $request, $id)
    {
        $data = \App\Models\Aplikasi\Fitur\FiturAplikasi::findOrFail($id);

        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data->update($validator->validated());
        Session::flash('success', 'Data berhasil diperbarui');
        return Redirect::back();
    }

    public function destroy($id)
    {
        $data = \App\Models\Aplikasi\Fitur\FiturAplikasi::findOrFail($id);
        $data->delete();

        Session::flash('success', 'Data berhasil dihapus');
        return Redirect::back();
    }
}
