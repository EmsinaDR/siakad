<?php

namespace App\Http\Controllers\bk;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\bk\Ebkkreditpoint;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

class EbkkreditpointController extends Controller
{
   public function index(Request $request)
   {
      $title = 'Kredit Point';
      $arr_ths = [
         'Kategori',
         'Kredit Point',
         'Point',
      ];
      $etapels = Etapel::where('aktiv', 'Y')->first();
      $dataKreditPoint = Cache::tags(['cache_dataKreditPoint'])->remember('remember_dataKreditPoint', now()->addHours(2), function () {
          return Ebkkreditpoint::get(); //Relasi di sisipi dengan where
      });
      $breadcrumb = 'Bimbingan Konseling / Kredit Point';
      $titleviewModal = 'Lihat Kredit Point';
      $titleeditModal = 'Edit Kredit Point';
      $titlecreateModal = 'Buat Kredit Point';
      return view('role.bk.e_kreditpoint', compact('title', 'arr_ths', 'dataKreditPoint', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
   }


   public function store(Request $request)
   {
      //Proses Modal Create

      $etapels = Etapel::where('aktiv', 'Y')->first();
      // dd(request->all());
      $data = $request->except(['_token', '_method']);
      $data = new Ebkkreditpoint();
      $data->kelas_id = $request->kelas_id;
      $data->created_at = now();
      $data->updated_at =  now();

      $data->save();
      HapusCacheDenganTag('dataKreditPoint');
      return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data disimpan dalam database');
   }
   public function update($kredit_point, Request $request)
   {
      //Proses Modal Update
      // dd($request->all());
      $etapels = Etapel::where('aktiv', 'Y')->first();
      $data = $request->except(['_token', '_method']);
      $data = Ebkkreditpoint::findOrFail($kredit_point);
      $data->tapel_id = $etapels->id;
      $data->kategori = $request->kategori;
      $data->pelanggaran = $request->pelanggaran;
      $data->point = $request->point;
      $data->updated_at =  now();
      $data->update();
      HapusCacheDenganTag('dataKreditPoint');
      return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  berhasil diperbaharui');
   }


   public function destroy($id)
   {
      //Proses Modal Delete
      $data = Ebkkreditpoint::findOrFail($id);
      $data->delete();
      HapusCacheDenganTag('dataKreditPoint');

      return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
   }
}
