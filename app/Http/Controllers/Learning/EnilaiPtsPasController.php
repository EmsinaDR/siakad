<?php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;

use App\Models\Admin\Etapel;
use App\Models\Learning\EnilaiPtsPas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EnilaiPtsPasController extends Controller
{
    //
    public function index(Request $request)
    {
        $title = 'E Nilai Tugas';
        $arr_ths = [
            'Nama',
            'NIS'
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = EnilaiPtsPas::with('EnilaiPtsPastoDetailSiswa')->where('id', 'id')->get(); //Relasi di sisipi dengan where
        $breadcrumb = 'Guru / E Nilai Tugas';
        $titleviewModal = 'Lihat E Nilai Tugas';
        $titleeditModal = 'Edit E Nilai Tugas';
        $titlecreateModal = 'Buat E Nilai Tugas';
        return view('role.guru.e_nilai_pts_pas', compact('title', 'arr_ths', 'datas', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
    public function store(Request $request)
    {
        //Proses Modal Create
        //Form Modal Create ada di index dengan Modal

        $etapels = Etapel::where('aktiv', 'Y')->first();
        // dd(request->all());
        $data = $request->except(['_token', '_method']);
        $data = new EnilaiPtsPas();
        //$data->indikator_id = implode(',', $request->indikator_id);
        $data->kelas_id = $request->kelas_id;
        $data->created_at = now();
        $data->updated_at =  now();

        $data->save();
        return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data disimpan dalam database');
    }
    public function update($id, Request $request)
    {
        //Proses Modal Update
        //Form Modal Update ada di index dengan Modal
        //dd($request->all());
        $data = $request->except(['_token', '_method']);
        $data = EnilaiPtsPas::findOrFail($id);
        $data->kelas_id = $request->kelas_id;
        $data->updated_at =  now();
        $data->update();
        return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  berhasil diperbaharui');
    }


    public function destroy($id)
    {
        //Proses Modal Delete
        //Form Modal Delete ada di index
        //Detailguru
        // dd(id);
        // dd(request->all());
        $data = EnilaiPtsPas::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
    }
}
