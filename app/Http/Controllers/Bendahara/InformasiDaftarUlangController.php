<?php

namespace App\Http\Controllers\Bendahara;

use App\Models\Bendahara\InformasiDaftarUlang;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class InformasiDaftarUlangController extends Controller
{
    public function index()
    {
        $title = 'InformasiDaftarUlangController';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = \App\Models\Bendahara\InformasiDaftarUlang::where('tapel_id', $etapels->id)->get();

        return view('informasidaftarulang.index', compact('title', 'datas'));
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

        \App\Models\Bendahara\InformasiDaftarUlang::create($validator->validated());
        Session::flash('success', 'Data berhasil disimpan');
        return Redirect::back();
    }

    public function update(Request $request, $id)
    {
        $data = \App\Models\Bendahara\InformasiDaftarUlang::findOrFail($id);

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
        $data = \App\Models\Bendahara\InformasiDaftarUlang::findOrFail($id);
        $data->delete();

        Session::flash('success', 'Data berhasil dihapus');
        return Redirect::back();
    }
}
