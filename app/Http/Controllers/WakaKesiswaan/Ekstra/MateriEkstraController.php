<?php

namespace App\Http\Controllers\WakaKesiswaan\Ekstra;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKesiswaan\Ekstra\MateriEkstra;
use App\Models\WakaKesiswaan\Ekstra\RiwayatEkstra;

class MateriEkstraController extends Controller
{


    /*
    MateriEkstra
    $materiekstra
    blade
    bladeblade_file
    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Materi Ekstra';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad'
        ];
        $breadcrumb = 'Menu_breadcume / sub_Menu_breadcume';
        $titleviewModal = 'Lihat Data Materi Ekstra';
        $titleeditModal = 'Edit Data Materi Ekstra';
        $titlecreateModal = 'Create Data Materi Ekstra';
        $datas = MateriEkstra::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('bladeblade_file', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }

    public function store(Request $request)
    {
        //
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'ekstra_id' => 'nullable|exists:ekstra,id', // Validasi ekstra_id (boleh null, harus ada di tabel ekstra)
            'materi' => 'nullable|string|max:255', // Validasi materi (boleh null, harus string, max 255 karakter)
            'sub_materi' => 'nullable|string|max:255', // Validasi sub_materi (boleh null, harus string, max 255 karakter)
            'indikator_id' => 'nullable|string', // Validasi indikator (boleh null, harus string)
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
        MateriEkstra::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, MateriEkstra $materiekstra)
    {
        //

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'ekstra_id' => 'nullable|exists:ekstra,id', // Validasi ekstra_id (boleh null, harus ada di tabel ekstra)
            'materi' => 'nullable|string|max:255', // Validasi materi (boleh null, harus string, max 255 karakter)
            'sub_materi' => 'nullable|string|max:255', // Validasi sub_materi (boleh null, harus string, max 255 karakter)
            'indikator' => 'nullable|string', // Validasi indikator (boleh null, harus string)
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $varmodel = MateriEkstra::find($id); // Pastikan $id didefinisikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($validator->validated());

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
        //MateriEkstra
        // dd(id);
        // dd(request->all());
        $data = MateriEkstra::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }

    public function show()
    {
        //
        //Title to Controller
        $title = 'Materi Ekstra';
        $arr_ths = [
            'Materi',
            'Sub Materi',
            'Indikator',
        ];
        $breadcrumb = 'Pembina Ekstra / Materi Ekstra';
        $titleviewModal = 'Lihat Data Materi Ekstra';
        $titleeditModal = 'Edit Data Materi Ekstra';
        $titlecreateModal = 'Create Data Materi Ekstra';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // dd(request()->segment(3));
        $datas = MateriEkstra::where('ekstra_id', request()->segment(3))->get();
        $jumlah_materi = MateriEkstra::select('materi')->where('ekstra_id', request()->segment(3))->distinct()->get()->count();
        $jumlah_sub_materi = MateriEkstra::select('sub_materi')->where('ekstra_id', request()->segment(3))->distinct()->get()->count();
        $jumlah_indikator = MateriEkstra::select('indikator')->where('ekstra_id', request()->segment(3))->distinct()->get()->count();
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        $Ekstra_name = RiwayatEkstra::with('Ekstra')->where('tapel_id', $etapels->id)->where('ekstra_id', request()->segment(3))->first();
        // dd($Ekstra_name->Ekstra->ekstra);
        // dd(optional($Ekstra_name?->Ekstra)->ekstra ?? 'Ekstra tidak tersedia');
        return view('role.pembina.ekstra.materi-ekstra', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'jumlah_materi',
            'jumlah_sub_materi',
            'jumlah_indikator',
            'Ekstra_name',
        ));
    }
    // Ajax Materi Ekstra
    // Method untuk mendapatkan Materi Ekstra
    // public function getMateri()
    // {
    //     $materi = MateriEkstra::select('materi')->distinct()->get();// Mengambil semua materi ekstra dari database
    //     return response()->json($materi);
    // }

    // Method untuk mendapatkan Sub Materi berdasarkan materiId
    // Method untuk mendapatkan Sub Materi berdasarkan materi (nama materi)
    public function getSubMateri($materi)
    {
        // Cari berdasarkan nama materi
        $subMateri = MateriEkstra::select('sub_materi')->where('materi', $materi)->distinct()->get();

        // Debugging: Jika tidak ada data, coba cek apakah nama materi cocok
        if ($subMateri->isEmpty()) {
            return response()->json(['message' => 'No sub materi found for this materi'], 404);
        }
        // Return data dalam format JSON
        return response()->json($subMateri);
    }
    // Method untuk mendapatkan Indikator Materi berdasarkan sub_materi (nama sub materi)
    public function getIndikatorMateri($subMateri)
    {
        // Cari berdasarkan nama sub materi
        $indikator = MateriEkstra::where('sub_materi', $subMateri)->get();
        // Debugging: Jika tidak ada data, coba cek apakah nama sub materi cocok
        if ($indikator->isEmpty()) {
            return response()->json(['message' => 'No indikator found for this sub materi'], 404);
        }
        // Return data dalam format JSON
        return response()->json($indikator);
    }
}
