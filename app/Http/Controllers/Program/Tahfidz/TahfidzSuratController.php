<?php

namespace App\Http\Controllers\Program\Tahfidz;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Tahfidz\TahfidzSurat;

class TahfidzSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    TahfidzSurat
    $tahfidzsurat
    role.program.tahfidz
    role.program.tahfidz.tahfidz-surat
    role.program.tahfidz.blade_show
    Index = Data Surat Hafalan
    Breadcume Index = 'Pembina Tahfidz / Data Surat Hafalan';
    Single = Data Surat Hafalan
    php artisan make:view role.program.tahfidz.tahfidz-surat
    php artisan make:view role.program.tahfidz.tahfidz-surat-single
    php artisan make:seed TahfidzSuratSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Surat Hafalan';
        $arr_ths = [
            'Nama Surat',
            'Jumlah Ayat',
        ];
        $breadcrumb = 'Pembina Tahfidz / Data Surat Hafalan';
        $titleviewModal = 'Lihat Data Surat Hafalan';
        $titleeditModal = 'Edit Data Surat Hafalan';
        $titlecreateModal = 'Create Data Surat Hafalan';
        $datas = TahfidzSurat::get();


        return view('role.program.tahfidz.tahfidz-surat', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.tahfidz.tahfidz-surat

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Surat Hafalan';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Pembina Tahfidz / Data Surat Hafalan';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = TahfidzSurat::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.tahfidz.tahfidz-surat-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.program.tahfidz.tahfidz-surat-single
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
            'arab' => 'nullable|string|max:255',
            'nama_surat' => 'required|string|max:255',
            'jumlah_ayat' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }



        TahfidzSurat::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, TahfidzSurat $tahfidzsurat)
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
        $varmodel = TahfidzSurat::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //TahfidzSurat
        // dd(id);
        // dd(request->all());
        $data = TahfidzSurat::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
