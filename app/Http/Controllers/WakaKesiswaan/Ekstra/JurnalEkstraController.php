<?php

namespace App\Http\Controllers\WakaKesiswaan\Ekstra;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKesiswaan\Ekstra\JurnalEkstra;
use App\Models\WakaKesiswaan\Ekstra\MateriEkstra;
use App\Models\WakaKesiswaan\Ekstra\RiwayatEkstra;

class JurnalEkstraController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /*
     JurnalEkstra
     $jurnalekstra
     role.pembina.ekstra
     role.pembina.ekstrajurnal-ekstra
     role.pembina.ekstrajurnal-ekstra
     php artisan make:view role.pembina.ekstra.jurnal-ekstra
     php artisan make:view role.pembina.ekstra.jurnal-ekstra
     php artisan make:seed JurnalEkstraSeeder



     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Jurnal Ekstra';
        $arr_ths = [
            'Hari dan Tanggal',
            'Materi',
            'Indikator',
        ];
        $breadcrumb = 'Pembina Ekstra / Jurnal Materi Ekstra';
        $titleviewModal = 'Lihat Data Jurnal Ekstra';
        $titleeditModal = 'Edit Data Jurnal Ekstra';
        $titlecreateModal = 'Create Data Jurnal Ekstra';
        // $datas = JurnalEkstra::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.pembina.ekstra.jurnal-ekstra', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.pembina.ekstra.jurnal-ekstra

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Jurnal Ekstra';
        $arr_ths = [
            'Hari dan Tanggal',
            'Materi',
            'Indikator',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Pembina Ekstra / Jurnal Materi Ekstra';
        $titleviewModal = 'Lihat Data Jurnal Ekstra';
        $titleeditModal = 'Edit Data Jurnal Ekstra';
        $titlecreateModal = 'Create Data Jurnal Ekstra';
        $datas = JurnalEkstra::where('ekstra_id', request()->segment(3))->orderBy('created_at', 'DESC')->get();
        $materiEkstra = MateriEkstra::select('materi')->where('ekstra_id', request()->segment(3))->orderBy('created_at', 'DESC')->distinct()->get(); // Mengambil semua materi ekstra dari database
        $materiEkstra_sub = MateriEkstra::select('sub_materi')->where('ekstra_id', request()->segment(3))->orderBy('created_at', 'DESC')->distinct()->get(); // Mengambil semua materi ekstra dari database
        $materiEkstra_indikator = MateriEkstra::select('indikator')->where('ekstra_id', request()->segment(3))->orderBy('created_at', 'DESC')->distinct()->get(); // Mengambil semua materi ekstra dari database
        // dd(request()->segment(3));
        // dd($materiEkstra);
        $Ekstra_name = RiwayatEkstra::with('Ekstra')->where('tapel_id', $etapels->id)->where('id', request()->segment(3))->first();
        // dd($Ekstra_name);
        if (!$Ekstra_name) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.pembina.ekstra.jurnal-ekstra', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'materiEkstra',
            'Ekstra_name',
            'materiEkstra_sub',
            'materiEkstra_indikator',
        ));
        //php artisan make:view role.pembina.ekstra.jurnal-ekstra
    }


    public function store(Request $request)
    {
        //
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $kelas = Ekelas::where('kelas', $request->kelas)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
            // 'tanggal_latihan' => now(),
            // 'kelas_id' => $kelas->id,
            // 'tingkat_id' => $kelas->tingkat_id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'ekstra_id' => 'nullable|exists:ekstra,id', // Validasi ekstra_id (boleh null, harus ada di tabel ekstra)
            'materi' => 'nullable|string|max:255', // Validasi materi (boleh null, harus string, max 255 karakter)
            'sub_materi' => 'nullable|string|max:255', // Validasi sub_materi (boleh null, harus string, max 255 karakter)
            'indikator_id' => 'nullable|string', // Validasi indikator (boleh null, harus string)
            'tapel_id' => 'nullable|numeric', // Validasi indikator (boleh null, harus string)

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Menyimpan data menggunakan mass assignment
        // Create : Buat
        // Update : Memperbaharui
        // Menyimpan data menggunakan mass assignment
        JurnalEkstra::create($validator->validated());
        // dd($request->all());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, JurnalEkstra $jurnalekstra)
    {
        //
        // dd($request->tanggal_latihan);
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'ekstra_id' => 'nullable|exists:ekstra,id', // Validasi ekstra_id (boleh null, harus ada di tabel ekstra)
            // 'materi' => 'nullable|string|max:255', // Validasi materi (boleh null, harus string, max 255 karakter)
            // 'sub_materi' => 'nullable|string|max:255', // Validasi sub_materi (boleh null, harus string, max 255 karakter)
            'indikator_id' => 'nullable|string', // Validasi indikator (boleh null, harus string)
            'tapel_id' => 'nullable|numeric', // Validasi indikator (boleh null, harus string)
            'tanggal_latihan' => 'nullable|date', // Validasi indikator (boleh null, harus string)
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Menyimpan data menggunakan mass assignment
        // Create : Buat
        // Update : Memperbaharui
        // Menyimpan data menggunakan mass assignment
        $varmodel = JurnalEkstra::find($id); // Pastikan $id didefinisikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($validator->validated());
            // dd($request->all());
            return Redirect::back()->with('Title', 'Berhasil')->with('success', 'Data Berhasil di Update');
        } else {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Data tidak ditemukan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //JurnalEkstra
        // dd(id);
        // dd(request->all());
        $data = JurnalEkstra::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
