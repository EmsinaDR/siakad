<?php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;

use App\Models\Learning\Enilai;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EnilaiController extends Controller
{

    public function index(Request $request)
    {
        $title = 'E Nilai';
        $arr_ths = [
            'Foto',
            'Jenis'
        ];
        $mapel_id = $request->mapel_id;
        $semester_id = $request->semester;
        $tingkat_id = $request->tingkat_id;
        $guru_id = $request->guru_id;
        // dd($tingkat_id);
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = Enilai::with('eloquent')->where('posisi', 'Guru')->get(); //Relasi di sisipi dengan where
        $breadcrumb = 'Data / E Nilai';
        $titleviewModal = 'Lihat E Nilai';
        $titleeditModal = 'Edit E Nilai';
        $titlecreateModal = 'Buat E Nilai';
        return view('role.guru.e_nilai', compact('title', 'arr_ths', 'datas', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));

    }


    public function store(Request $request)
    {
        //Proses Modal Create
        //Form Modal Create ada di index dengan Modal

        $etapels = Etapel::where('aktiv', 'Y')->first();
        // dd(request->all());
        $data = $request->except(['_token', '_method']);
        $data = new Enilai();
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
        $data = Enilai::findOrFail($id);
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
        $data = Enilai::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
    }
}
