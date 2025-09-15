<?php

namespace App\Http\Controllers\WakaKesiswaan\Ekstra;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKesiswaan\Ekstra\RiwayatEkstra;
use App\Models\WakaKesiswaan\Ekstra\PengaturanEkstra;

class PengaturanEkstraController extends Controller
{
    /*
    PengaturanEkstra
    $pengaturanekstra
    role.pembina.ekstra.
    role.pembina.ekstra.pengaturan-ekstra
    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Pengaturan Ekstra';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad'
        ];
        $breadcrumb = 'Pembina Ekstra / Pengaturan';
        $titleviewModal = 'Lihat Data Pengaturan Ekstra';
        $titleeditModal = 'Edit Data Pengaturan Ekstra';
        $titlecreateModal = 'Create Data Pengaturan Ekstra';
        $datas = PengaturanEkstra::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.pembina.ekstra.pengaturan-ekstra', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }

    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
        ]);

        // dd($request->all());
        // Validasi data
        $validator = Validator::make($request->all(), [
            'nama_pengaturan' => 'required|string|max:255',
            'isi' => 'required|string|max:255',
            'ekstra_id' => 'required|numeric',
            'tapel_id' => 'required|numeric',
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
        PengaturanEkstra::create($validator->validated());

        dd($request->all());
        Session::flash('success', 'Data Berhasil Dihapus');
        return Redirect::back();
    }
    public function update($id, Request $request, PengaturanEkstra $pengaturanekstra)
    {
        //

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            //data_field_validator
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
        $varmodel = PengaturanEkstra::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //ClassName
        // dd(id);
        // dd(request->all());
        $data = PengaturanEkstra::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
        //
        //Title to Controller
        $title = 'Pengaturan Ekstra';
        $arr_ths = [
            'Nama Pengaturan',
            'Isi',
            'Keterangan',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Pembina Ekstra / Pengaturan';
        $titleviewModal = 'Lihat Data Pengaturan Ekstra';
        $titleeditModal = 'Edit Data Pengaturan Ekstra';
        $titlecreateModal = 'Create Data Pengaturan Ekstra';
        $datas = PengaturanEkstra::where('ekstra_id', request()->segment(3))->get();
        $Ekstra_name = RiwayatEkstra::with('Ekstra')->where('tapel_id', $etapels->id)->where('ekstra_id', request()->segment(3))->first();

        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.pembina.ekstra.pengaturan-ekstra', compact('Ekstra_name', 'datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
}
/*
Data Blade
php artisan make:view role.pembina.ekstra.pengaturan-ekstra


*/