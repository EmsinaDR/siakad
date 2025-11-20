<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Ekeuangandaftarulang;
use Illuminate\Support\Facades\Redirect;

class EkeuangandaftarulangController extends Controller
{
    //
    public function index(Ekeuangandaftarulang $Ekeuangandaftarulang)
    {
        $title = 'Daftar Ulang';
        $arr_ths = [
            'Nama Siswa',
            'No Pembayaran',
            'Kelas',
            'Itim',
            'Nominal',
            'Waktu',
        ];
        // //$etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = Ekeuangandaftarulang::with('EkeuangandaftarulangtoSiswa')->where('id', 'id')->get(); //Relasi di sisipi dengan where
        $breadcrumb = 'Bendahara / Daftar Ulang';
        $titleviewModal = 'Lihat Daftar Ulang';
        $titleeditModal = 'Edit Daftar Ulang';
        $titlecreateModal = 'Buat Daftar Ulang';
        return view('role.bendahara.daftarulang', compact('title', 'arr_ths', 'datas', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }


    public function store(Request $request)
    {
        //Proses Modal Create
        //Form Modal Create ada di index dengan Modal

        //$etapels = Etapel::where('aktiv', 'Y')->first();
        // dd(request->all());
        $data = $request->except(['_token', '_method']);
        $data = new Ekeuangandaftarulang();
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
        $data = Ekeuangandaftarulang::findOrFail($id);
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
        $data = Ekeuangandaftarulang::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
    }
}
