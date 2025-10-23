<?php

namespace App\Http\Controllers\bk;

use Exception;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\bk\Bkbimbingan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Redirect;

class BkbimbinganController extends Controller
{
   //
   //Bkbimbingan

   public function index()
   {

      $dataBimbingan = Cache::tags(['cache_dataBimbingan'])->remember('remember_dataBimbingan', now()->addHours(2), function () {
         return Bkbimbingan::with('Siswa.kelas')->whereHas('Siswa', function ($q) {
            $q->whereNotNull('kelas_id');
         })->orderBy('created_at', 'desc')->get();
      });
      $title = 'Data BK Bimbingan';
      $arr_ths = [
         'Hari dan Tanggal',
         'NIS',
         'Nama',
         'Kelas',
         'Proses',
         'Permasalahan',
      ];
      $breadcrumb = 'Bimbingan Konseling / BK Bimbingan';
      $titleviewModal = 'Detail BK Bimbingan';
      $titleeditModal = 'Edit BK Bimbingan';
      $titlecreateModal = 'Buat BK Bimbingan';
      return view(
         'role.bk.bimbingan',
         compact(
            'title',
            'dataBimbingan',
            'breadcrumb',
            'arr_ths',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
         )
      );
   }

   public function store(Request $request)
   {
      try {
         // Kode yang berpotensi menyebabkan error
         // dd($request->all());
         $etapels = Etapel::where('aktiv', 'Y')->first();
         $data = $request->except(['_token', '_method']);
         $data = new Bkbimbingan();
         $data->tapel_id = $etapels->id;
         $data->detailguru_id = \Illuminate\Support\Facades\Auth::user()->id;
         $data->tanggal = $request->tanggal;
         $data->detailsiswa_id = $request->detailsiswa_id;
         $data->permasalahan = $request->permasalahan;
         $data->solusi = $request->solusi;
         $data->proses = $request->proses;
         $data->created_at = now();
         $data->updated_at = now();
         $data->save();
         HapusCacheDenganTag('dataBimbingan');

         return Redirect::back()->with('Title', 'Data Berhasil')->with('Success', 'Data berhasil disimpan. <br> Silahkan pantau terus status perkembangannya');

         // dd($request->all());
      } catch (Exception $e) {
         // Tindakan jika terjadi exception
         return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
      }
   }

   public function update($id, Request $request)
   {
      try {
         // dd($request->all());
         $pelanggaran = Bkbimbingan::find($id);

         $pelanggaran->update([
            'tapel_id'        => $request->tapel_id,
            'tanggal'         => $request->tanggal,
            'detailguru_id'   => $request->detailguru_id,
            'detailsiswa_id'  => $request->detailsiswa_id,
            'permasalahan'    => $request->permasalahan,
            'solusi'          => $request->solusi,
            // 'proses'          => $request->proses,
            'kreditpoint_id'  => json_encode($request->kreditpoint_id), // kalau bentuk array
         ]);
         HapusCacheDenganTag('dataBimbingan');
         return Redirect::back()->with('Title', 'Data Berhasil')->with('Success', 'Data berhasil disimpan. <br> Silahkan pantau terus status perkembangannya');
      } catch (Exception $e) {
         // Tindakan jika terjadi exception
         return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
      }
   }


   public function destroy($id)
   {
      try {
         $data = Bkbimbingan::findOrFail($id);
         $data->delete();
         return Redirect::back()->with('Title', 'Berhasil!!!')->with('Success', 'Data berhasil dihapus');
      } catch (Exception $e) {
         // Tindakan jika terjadi exception
         return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
      }
   }
}
