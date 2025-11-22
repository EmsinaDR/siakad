<?php

namespace App\Http\Controllers\WakaKurikulum\Perangkat;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\Perangkat\JadwalTest;
use App\Models\WakaKurikulum\Perangkat\PesertaTest;
use App\Models\WakaKurikulum\Perangkat\PerangkatDaftarHadir;

class PerangkatDaftarHadirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
/*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view role.waka.kuikulum.Perangkat.daftar-hadir
php artisan make:view role.waka.kuikulum.Perangkat.daftar-hadir-single
php artisan make:model WakaKurikulum/Perangkat/PerangkatDaftarHadir
php artisan make:controller WakaKurikulum/Perangkat/PerangkatDaftarHadirController --resource



php artisan make:seeder WakaKurikulum/Perangkat/PerangkatDaftarHadirSeeder
php artisan make:migration Migration_DaftarHadir

    PerangkatDaftarHadir
    $PerangkatDH
    role.waka.kurikulum.Perangkat
    role.waka.kurikulum.Perangkat.daftar-hadir
    role.waka.kurikulum.Perangkat.blade_show
    Index = Daftar Hadir
    Breadcume Index = 'Waka Kurikulum / Perangkat Test / Daftar Hadir';
    Single = titel_data_single
    php artisan make:view role.waka.kurikulum.Perangkat.daftar-hadir
    php artisan make:view role.waka.kurikulum.Perangkat.daftar-hadir-single
    php artisan make:seed PerangkatDaftarHadirSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Daftar Hadir';
        $arr_ths = [
            'Ruangan',
            'Jumlah Peserta',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Waka Kurikulum / Perangkat Test / Daftar Hadir';
        $titleviewModal = 'Lihat Data Daftar Hadir';
        $titleeditModal = 'Edit Data Daftar Hadir';
        $titlecreateModal = 'Create Data Daftar Hadir';
        $datas = PesertaTest::where('tapel_id', $etapels->id)->select('nomor_ruangan', DB::raw('COUNT(*) as jumlah_siswa'))
            ->groupBy('nomor_ruangan')
            ->get();
        $MeplTest = JadwalTest::where('tapel_id', $etapels->id)->where('nomor_ruangan', 2)->count();
        // dump($MeplTest);

        return view('role.waka.kurikulum.Perangkat.daftar-hadir', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'MeplTest',
        ));
        //php artisan make:view role.waka.kurikulum.Perangkat.daftar-hadir

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Daftar Hadir';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kurikulum / Perangkat Test / Daftar Hadir';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = \App\Models\WakaKurikulum\Perangkat\PerangkatDaftarHadir::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.Perangkat.daftar-hadir-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.kurikulum.Perangkat.daftar-hadir-single
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



        PerangkatDaftarHadir::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, PerangkatDaftarHadir $PerangkatDH)
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
        $varmodel = PerangkatDaftarHadir::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //PerangkatDaftarHadir
        // dd($id);
        // dd($request->all());
        $data = PerangkatDaftarHadir::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
