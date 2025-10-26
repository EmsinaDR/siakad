<?php

namespace App\Http\Controllers\Dokumen\Surat;

use App\Models\Eijin;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\bk\Ebkpanggilan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class SuratController extends Controller
{
    //index surat BK
    public function surat_bk(Request $request)
    {
        //dd($request->all());

        //Title to Controller
        $title = 'Data Surat';
        $arr_ths = [
            'No Surat',
            'Kategori Surat',
            'Detail Singkat',
        ];
        $breadcrumb = 'Bimbingan Konseling / sub_Menu_breadcume';
        $titleviewModal = 'Lihat Data Surat';
        $titleeditModal = 'Edit Data Surat';
        $titlecreateModal = 'Create Data Surat';


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.bk.surat', compact('title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
    //Surat Penggilan model Ebkpanggilan
    public function s_panggilan(Request $request)
    {
        //dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $data = new Ebkpanggilan();
        $data->detailguru_id = $request->detailguru_id;
        $data->detailsiswa_id = $request->detailsiswa_id;
        $data->waktu = $request->waktu;
        $data->tujuan = $request->tujuan;
        $data->created_at = now();
        $data->updated_at = now();
        $data = $request->updated_at;
        $data->save();
    }
    //Surat ijin masuk dan keluar model Eijin
    public function s_ijin(Request $request)
    {
        //dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $data = new Eijin();
        $data->detailguru_id = $request->detailguru_id;
        $data->detailsiswa_id = $request->detailsiswa_id;
        $data->waktu = $request->waktu;
        $data->tujuan = $request->tujuan;
        $data->created_at = now();
        $data->updated_at = now();
        $data->save();
    }
    public function s_aktif_siswa(Request $request)
    {
        //dd($request->all());
        //aa
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $data = new Eijin();
        $data->waktu = $request->waktu;



        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data dokuemn telah berhasil disimpan');
    }
    public function s_dispensasi(Request $request)
    {
        //dd($request->all());
        //aaa
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $data = new Eijin();
        $data->waktu = $request->waktu;



        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data dokuemn telah berhasil disimpan');
    }
    public function s_bebas_perpus(Request $request)
    {
        //dd($request->all());
        //Bebas Perpus
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $data = new Eijin();
        $data->waktu = $request->waktu;



        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data dokuemn telah berhasil disimpan');
    }
    public function s_bebas_keuangan(Request $request)
    {
        //dd($request->all());
        //Bebas Keuangan
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $data = new Eijin();
        $data->waktu = $request->waktu;



        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data dokuemn telah berhasil disimpan');
    }
    public function s_pernyataan(Request $request)
    {
        //dd($request->all());
        //Surat Pernyataan
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $data = new Eijin();
        $data->waktu = $request->waktu;



        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data dokuemn telah berhasil disimpan');
    }
    public function s_skorsing(Request $request)
    {
        //dd($request->all());
        //Surat skorsing
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $data = new Eijin();
        $data->waktu = $request->waktu;



        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data dokuemn telah berhasil disimpan');
    }
    public function s_keterangan_lulus(Request $request)
    {
        //dd($request->all());
        //Surat Keterangan Lulus
    }
    public function s_keterangan_nilai(Request $request)
    {
        //dd($request->all());
        //Surat Kterangan Nilai SMT 1 - 5
    }
}
