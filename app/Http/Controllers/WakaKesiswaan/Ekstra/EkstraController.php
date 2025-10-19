<?php

namespace App\Http\Controllers\WakaKesiswaan\Ekstra;

use App\Models\Admin\Etapel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\WakaKesiswaan\Ekstra\Ekstra;
use App\Models\WakaKesiswaan\Ekstra\RiwayatEkstra;

class EkstraController extends Controller
{
    //
    public function index(Ekstra $Ekstra)
    {
        $title = 'Data Ekstra';
        $arr_ths = [
            'Ekstra',
            'Pembina',
            'Pelatih',
            'Jadwal Latihan',
            'Anggota',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = RiwayatEkstra::where('tapel_id', $etapels->id)->get();
        $breadcrumb = 'Data Admin / Data Ekstra';
        $titleviewModal = 'Lihat Data Ekstra';
        $titleeditModal = 'Edit Data Ekstra';
        $titlecreateModal = 'Buat Data Ekstra';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $dataEkstra = RiwayatEkstra::where('tapel_id', $etapels->id)->get();
        return view('role.waka.kesiswaan.data-ekstra', compact(
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
    }

    public function store(Request $request)
    {
        //Proses Modal Create
        //Form Modal Create ada di index dengan Modal
        // dd($request->all());

        $etapels = Etapel::where('aktiv', 'Y')->first();
        // dd(request->all());
        $data = $request->except(['_token', '_method']);
        $data = new RiwayatEkstra();
        //$data->indikator_id = implode(',', $request->indikator_id);
        $DataEkstra = Ekstra::where('id', $request->ekstra_id)->first();
        $data->ekstra_id = $request->ekstra_id;
        $data->detailguru_id = $request->detailguru_id;
        $data->pelatih = $request->pelatih;
        $data->jadwal = $request->jadwal;
        $data->tapel_id = $etapels->id;
        $data->deskripsi = $DataEkstra->deskripsi;
        $data->save();
        // dd($data);
        // dd($request->all());
        Session::flash('success','Data Berhasil Dihapus');
        return Redirect::back();
    }
    public function update($id, Request $request)
    {
        //Proses Modal Update
        //Form Modal Update ada di index dengan Modal
        //dd($request->all());
        $data = $request->except(['_token', '_method']);
        $data = Ekstra::findOrFail($id);
        $data->kelas_id = $request->kelas_id;
        $data->update_at = now();
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
        $data = Ekstra::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
    }
}
