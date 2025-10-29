<?php

namespace App\Http\Controllers\Walkes;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Walkes\Pengaturan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PengaturanController extends Controller
{
    /*
    Pengaturan
    $pengaturanekstra
    role.pembina.ekstra
    role.pembina.ekstrapengaturan-ekstra
    role.pembina.ekstrapengaturan-ekstra
    php artisan make:view role.pembina.ekstra.pengaturan-ekstra
    php artisan make:view role.pembina.ekstra.pengaturan-ekstra
    php artisan make:seed PengaturanSeeder



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
            'title_tabelad',
        ];
        $breadcrumb = 'Pembina Ekstra / Pengaturan';
        $titleviewModal = 'Lihat Data Pengaturan Ekstra';
        $titleeditModal = 'Edit Data Pengaturan Ekstra';
        $titlecreateModal = 'Create Data Pengaturan Ekstra';
        $datas = Pengaturan::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('blade.pengaturan-ekstra', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view blade.pengaturan-ekstra

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Pengaturan Ekstra';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Pembina Ekstra / Pengaturan';
        $titleviewModal = 'Lihat Data Pengaturan Ekstra';
        $titleeditModal = 'Edit Data Pengaturan Ekstra';
        $titlecreateModal = 'Create Data Pengaturan Ekstra';
        $datas = Pengaturan::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('bladepengaturan-ekstra', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view bladepengaturan-ekstra
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
        Pengaturan::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, Pengaturan $pengaturanekstra)
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
        $varmodel = Pengaturan::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //Pengaturan
        // dd(id);
        // dd(request->all());
        $data = Pengaturan::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
