<?php

namespace App\Http\Controllers\Program\Shalat;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\JadwalShalat\JadwalShalat;

class JadwalShalatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    JadwalShalat
    $jadshalat
    role.program.shalat.jadwal-shalat
    role.program.shalat.jadwal-shalat
    role.program.shalat.jadwal-shalat-single
    Index = Jadwal Shalat
    Breadcume Index = 'Pembina Shalat / Jadwal Shalat';
    Single = Jadwal Shalat
    php artisan make:view role.program.shalat.jadwal-shalat
    php artisan make:view role.program.shalat.jadwal-shalat-single
    php artisan make:seed JadwalShalatSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Jadwal Shalat';
        $arr_ths = [
            'Hari dan Tanggal',
            'Kelas',
            'Imam',
            'Keterangan',
        ];
        $breadcrumb = 'Pembina Shalat / Jadwal Shalat';
        $titleviewModal = 'Lihat Data Jadwal Shalat';
        $titleeditModal = 'Edit Data Jadwal Shalat';
        $titlecreateModal = 'Create Data Jadwal Shalat';
        $etapels = \App\Models\Admin\Etapel::where('aktiv', 'Y')->first();
        $datas = \App\Models\Program\JadwalShalat\JadwalShalat::groupBy('hari')->where('tapel_id', $etapels->id)->get();
        $DataGurus = Detailguru::where('jenis_kelamin', 'L')->orderBy('nama_guru')->get();
        // Dropdown Tanggal

        // Dropdown Tanggal


        return view('role.program.shalat.jadwal-shalat', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DataGurus',
        ));
        //php artisan make:view role.program.shalat.jadwal-shalat

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Jadwal Shalat';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Pembina Shalat / Jadwal Shalat';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = JadwalShalat::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.shalat.jadwal-shalat-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.program.shalat.jadwal-shalat-single
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



        JadwalShalat::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, JadwalShalat $jadshalat)
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
        $varmodel = JadwalShalat::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //JadwalShalat
        // dd($id);
        // dd($request->all());
        $data = JadwalShalat::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
