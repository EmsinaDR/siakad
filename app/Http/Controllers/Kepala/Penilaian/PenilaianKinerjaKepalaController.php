<?php

namespace App\Http\Controllers\Kepala\Penilaian;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Kepala\Penilaian\PenilaianKinerjaKepala;

class PenilaianKinerjaKepalaController extends Controller
{
    /*
    PenilaianKinerjaKepala
    $pkks
    role.kepala
    role.kepala.penilaian.penilaian-kinerja-kepala
    role.kepala.blade_show
    Index = Data Penilaian Kinerja Kepala
    Breadcume Index = 'Kepala Sekolah / Data Penilaian Kinerja Kepala';
    Single = Data Penilaian kinerja
    php artisan make:view role.kepala.penilaian.penilaian-kinerja-kepala
    php artisan make:view role.kepala.penilaian.penilaian-kinerja-kepala-single
    php artisan make:seed PenilaianKinerjaKepalaSeeder




    


    */

    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Penilaian Kinerja Kepala';
        $arr_ths = [
            'Tentang',
            'Bidang',
            'Indikator',
            'Sub Indikator',
            'Koordinator',
        ];
        $breadcrumb = 'Kepala Sekolah / Data Penilaian Kinerja Kepala';
        $titleviewModal = 'Lihat Data Penilaian Kinerja Kepala';
        $titleeditModal = 'Edit Data Penilaian Kinerja Kepala';
        $titlecreateModal = 'Create Data Penilaian Kinerja Kepala';
        $datas = PenilaianKinerjaKepala::get();


        return view('role.kepala.penilaian.penilaian-kinerja-kepala', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.kepala.penilaian.penilaian-kinerja-kepala

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Penilaian Kinerja Kepala';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Kepala Sekolah / Data Penilaian Kinerja Kepala';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = PenilaianKinerjaKepala::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.kepala.penilaian.penilaian-kinerja-kepala-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.kepala.penilaian.penilaian-kinerja-kepala-single
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



        PenilaianKinerjaKepala::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, PenilaianKinerjaKepala $pkks)
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
        $varmodel = PenilaianKinerjaKepala::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //PenilaianKinerjaKepala
        // dd($id);
        // dd($request->all());
        $data = PenilaianKinerjaKepala::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
