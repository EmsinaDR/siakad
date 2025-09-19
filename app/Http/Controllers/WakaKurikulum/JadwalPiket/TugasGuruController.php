<?php

namespace App\Http\Controllers\WakaKurikulum\JadwalPiket;

use Carbon\Carbon;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\JadwalPiket\TugasGuru;

class TugasGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view role.waka.kurikulum.jadwalpiket.tugas-guru
php artisan make:view role.waka.kurikulum.jadwalpiket.tugas-guru-single
php artisan make:seeder WakaKurikulum/JadwalPiket/TugasGuruSeeder
php artisan make:model WakaKurikulum/JadwalPiket/TugasGuru
php artisan make:controller WakaKurikulum/JadwalPiket/TugasGuruController --resource



php artisan make:migration Migration_TugasGuru




*/
    //Waka Kesiswaan
    /*
    TugasGuru
    $tugasguru
    role.waka.kurikulum.jadwalpiket.tugas-guru
    role.waka.kurikulum.jadwalpiket.tugas-guru
    role.waka.kurikulum.jadwalpiket.tugas-guru.blade_show
    Index = Tugas Guru
    Breadcume Index = 'Guru Piket / Tugas Guru';
    Single = Tugas Guru
    php artisan make:view role.waka.kurikulum.jadwalpiket.tugas-guru
    php artisan make:view role.waka.kurikulum.jadwalpiket.tugas-guru-single
    php artisan make:seed TugasGuruSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Tugas Guru';
        $arr_ths = [
            'Hari dan Tanggal',
            'Kelas',
            'Nama Guru',
            'Mapel',
            'Keterangan',
        ];
        $breadcrumb = 'Guru Piket / Tugas Guru';
        $titleviewModal = 'Lihat Data Tugas Guru';
        $titleeditModal = 'Edit Data Tugas Guru';
        $titlecreateModal = 'Create Data Tugas Guru';
        $datas = TugasGuru::orderBy('created_at', 'DESC')->orderBy('kelas_id', 'ASC')->get();
        $jumlahTugas = TugasGuru::whereDate('created_at', Carbon::today());
        $JumlagGuru = TugasGuru::whereDate('created_at', Carbon::today())->distinct('detailguru_id')->count();
        // dd($jumlahTugas);
        // dd($JumlagGuru);

        // dd($datas);

        return view('role.waka.kurikulum.jadwalpiket.tugas-guru', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'jumlahTugas',
        ));
        //php artisan make:view role.waka.kurikulum.jadwalpiket.tugas-guru

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Tugas Guru';
        $arr_ths = [
            'Hari dan Tanggal',
            'Kelas',
            'Nama Guru',
            'Mapel',
            'Keterangan',
        ];
        $breadcrumb = 'Guru Piket / Tugas Guru';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = TugasGuru::orderBy('created_at', 'DESC')->orderBy('kelas_id', 'ASC')->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.jadwalpiket.tugas-guru-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.waka.kurikulum.jadwalpiket.tugas-guru-single
    }

    public function TugasNow()
    {
        //
        //Title to Controller
        $title = 'Tugas Guru';
        $arr_ths = [
            'Hari dan Tanggal',
            'Kelas',
            'Nama Guru',
            'Mapel',
            'Jam Ke',
            'Batas Waktu',
            'Keterangan',
        ];
        $breadcrumb = 'Guru Piket / Tugas Guru';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = TugasGuru::orderBy('created_at', 'DESC')->orderBy('kelas_id', 'ASC')->get();
        $datas = TugasGuru::whereDate('created_at', Carbon::now()) // Ambil data hari ini
            ->orderBy('kelas_id', 'ASC') // Urutkan kelas secara naik
            ->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.jadwalpiket.tugas-guru-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.waka.kurikulum.jadwalpiket.tugas-guru-single
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



        TugasGuru::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, TugasGuru $tugasguru)
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
        $varmodel = TugasGuru::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //TugasGuru
        // dd(id);
        // dd(request->all());
        $data = TugasGuru::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
