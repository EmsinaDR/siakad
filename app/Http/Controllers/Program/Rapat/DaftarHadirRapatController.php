<?php

namespace App\Http\Controllers\Program\Rapat;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Program\Rapat\DataRapat;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Rapat\DaftarHadirRapat;

class DaftarHadirRapatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Daftar Hadir Rapat';
        $arr_ths = [
            'Hari dan Tanggal',
            'Rapat',
            'Perihal',
            'Jam',
            'Tempat',
            'Jumlah Vote',
        ];
        $breadcrumb = 'Data Rapat / Daftar Hadir Rapat';
        $titleviewModal = 'Lihat Data Daftar Hadir Rapat';
        $titleeditModal = 'Edit Data Daftar Hadir Rapat';
        $titlecreateModal = 'Create Data Daftar Hadir Rapat';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = DaftarHadirRapat::where('tapel_id', $etapels->id)->get();
        $datas = DataRapat::where('tapel_id', $etapels->id)->orderBy('created_at', 'DESC')->get();


        return view('role.program.rapat.daftar-hadir-rapat', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.rapat.daftar-hadir-rapat

    }


    public function show($id)
    {
        //
        //Title to Controller
        $title = 'Daftar Hadir Rapat';
        $arr_ths = [
            'Hari dan Tanggal',
            'Rapat',
            'Perihal',
            'Jam',
            'Tempat',
            'Tembusan',
        ];
        $breadcrumb = 'Data Rapat / Daftar Hadir Rapat';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = DataRapat::findOrFail($id);
        // dd($datas);
        // dd($datas->vote_id);


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.rapat.daftar-hadir-rapat-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.program.rapat.daftar-hadir-rapat-single
    }

    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
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



        DaftarHadirRapat::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, DaftarHadirRapat $dhrapat)
    {
        //

        dd($request->all());
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
        $varmodel = DaftarHadirRapat::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //DaftarHadirRapat
        // dd($id);
        // dd($request->all());
        $data = DaftarHadirRapat::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
