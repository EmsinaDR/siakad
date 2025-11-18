<?php

namespace App\Http\Controllers\Laboratorium;

use App\Models\Admin\Ekelas;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Laboratorium\Elabijin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ElabijinController extends Controller
{
    //
    /*
    Elabijin
    $labijin
    role.pembina.laboratorium
    role.pembina.laboratorium.ijin-pengggunaan-lab
    role.pembina.laboratorium.blade_show
    Index = Jadwal Ijin Penggunaan Lab
    Breadcume Index = 'Pembina Laboratorium / Jadwal Penggunaan Laboratorium';
    Single = Jadwal Ijin Penggunaan Lbaoratorium
    php artisan make:view role.pembina.laboratorium.ijin-pengggunaan-lab
    php artisan make:view role.pembina.laboratorium.ijin-pengggunaan-lab-single
    php artisan make:seed ElabijinSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Jadwal Ijin Penggunaan Lab';
        $arr_ths = [
            'Nama Guru',
            'Tanggal Penggunaan',
            'Tujuan Penggunaan',
        ];
        $breadcrumb = 'Pembina Laboratorium / Jadwal Penggunaan Laboratorium';
        $titleviewModal = 'Lihat Data Jadwal Ijin Penggunaan Lab';
        $titleeditModal = 'Edit Data Jadwal Ijin Penggunaan Lab';
        $titlecreateModal = 'Create Data Jadwal Ijin Penggunaan Lab';
        $datas = Elabijin::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.pembina.laboratorium.ijin-pengggunaan-laboratorium', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.pembina.laboratorium.ijin-pengggunaan-laboratorium

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Jadwal Ijin Penggunaan Lbaoratorium';
        $arr_ths = [
            'Nama Guru',
            'Tanggal Penggunaan',
            'Tujuan Penggunaan',
        ];
        $breadcrumb = 'Pembina Laboratorium / Jadwal Penggunaan Laboratorium';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = Elabijin::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.pembina.laboratorium.ijin-pengggunaan-laboratorium-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.pembina.laboratorium.ijin-pengggunaan-laboratorium-single
    }

    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $kelas = Ekelas::where('kelas', $request->kelas)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
            'kelas_id' => $kelas->id,
            'tingkat_id' => $kelas->tingkat_id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'detailguru_id' => 'required|integer',
            'laboratorium_id' => 'required|integer|exists:laboratorium,id',
            'tanggal_penggunaan' => 'required|date',
            'tujuan' => 'required|string|min:10',
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
        Elabijin::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, Elabijin $labijin)
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
            'detailguru_id' => 'required|integer',
            'laboratorium_id' => 'required|integer|exists:laboratorium,id',
            'tanggal_penggunaan' => 'required|date',
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
        $varmodel = Elabijin::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //Elabijin
        // dd(id);
        // dd(request->all());
        $data = Elabijin::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
