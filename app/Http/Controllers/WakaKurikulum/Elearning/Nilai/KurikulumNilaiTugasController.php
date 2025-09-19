<?php

namespace App\Http\Controllers\WakaKurikulum\Elearning\Nilai;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Learning\Emengajar;
use App\Http\Controllers\Controller;
use App\Models\Admin\Emapel;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\Elearning\KurikulumDataKKM;
use App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUH;
use App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiTugas;

class KurikulumNilaiTugasController extends Controller
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

php artisan make:view role.waka.kurikulum.nilai.data-nilai-tugas
php artisan make:view role.waka.kurikulum.nilai.data-nilai-tugas-single
php artisan make:seeder WakaKurikulum/Elearning/Nilai/KurikulumNilaiTugasSeeder
php artisan make:model WakaKurikulum/Elearning/Nilai/KurikulumNilaiTugas
php artisan make:controller WakaKurikulum/Elearning/Nilai/KurikulumNilaiTugasController --resource

App\Http\Controllers\WakaKurikulum$Folder$namaController


php artisan make:migration Migration_Nilai/KurikulumNilaiTugas




*/
    /*
    KurikulumNilaiTugas
    $kurikulumnilaitugas
    role.waka.kurikulum.nilai
    role.waka.kurikulum.nilai.data-nilai-tugas
    role.waka.kurikulum.nilai.blade_show
    Index = Data Nilai Tugas
    Breadcume Index = 'Waka Kurikulum / Data Nilai Tugas';
    Single = Data Nilai Tgas
    php artisan make:view role.waka.kurikulum.nilai.data-nilai-tugas
    php artisan make:view role.waka.kurikulum.nilai.data-nilai-tugas-single
    php artisan make:seed KurikulumNilaiTugasSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Nilai Tugas';
        $arr_ths = [
            'Mapel',
            'Guru',
            'Kelas',
        ];
        $breadcrumb = 'Waka Kurikulum / Data Nilai Tugas';
        $titleviewModal = 'Lihat Data Nilai Tugas';
        $titleeditModal = 'Edit Data Nilai Tugas';
        $titlecreateModal = 'Create Data Nilai Tugas';
        $datas = KurikulumNilaiTugas::get();
        $datas = \App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUH::get();
        $datas = Detailsiswa::with('nilaiUH')->orderBy('kelas_id', 'ASC')->orderBy('nama_siswa', 'ASC')->get();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $datas = Emengajar::where('tapel_id', $etapels->id)->orderBy('kelas_id', 'ASC')->orderBy('mapel_id', 'ASC')->get();


        return view('role.waka.kurikulum.nilai.data-nilai-tugas', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.waka.kurikulum.nilai.data-nilai-tugas

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Nilai Tugas';
        $arr_ths = [
            'NIS',
            'Nama',
            'Kelas',
            'KKM',
            'Mapel',
            'Guru',
        ];
        $breadcrumb = 'Waka Kurikulum / Data Nilai Tugas';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = KurikulumNilaiTugas::get();
        $datas = \App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUH::get();
        $datas = Detailsiswa::with('nilaiTGS')->where('kelas_id', request()->segment(4))->orderBy('kelas_id', 'ASC')->orderBy('nama_siswa', 'ASC')->get();
        // dd($datas);
        // $datas = Detailsiswa::where('kelas_id', request()->segment(4))->orderBy('kelas_id', 'ASC')->orderBy('nama_siswa', 'ASC')->get();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $KKM = KurikulumDataKKM::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.nilai.data-nilai-tugas-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'KKM',
        ));
        //php artisan make:view role.waka.kurikulum.nilai.data-nilai-tugas-single
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



        KurikulumNilaiTugas::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, KurikulumNilaiTugas $kurikulumnilaitugas)
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
        $varmodel = KurikulumNilaiTugas::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //KurikulumNilaiTugas
        // dd(id);
        // dd(request->all());
        $data = KurikulumNilaiTugas::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
