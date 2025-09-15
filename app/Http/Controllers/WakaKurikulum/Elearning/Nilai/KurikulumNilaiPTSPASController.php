<?php

namespace App\Http\Controllers\WakaKurikulum\Elearning\Nilai;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Learning\Emengajar;
use App\Http\Controllers\Controller;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\Elearning\KurikulumDataKKM;
use App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUH;
use App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiPTSPAS;

class KurikulumNilaiPTSPASController extends Controller
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

php artisan make:view role.waka.kurikulum.nilai.data-nilai-pts-pas
php artisan make:view role.waka.kurikulum.nilai.data-nilai-pts-pas-single
php artisan make:seeder WakaKurikulum/Elearning/Nilai/KurikulumNilaiPTSPASSeeder
php artisan make:model WakaKurikulum/Elearning/Nilai/KurikulumNilaiPTSPAS
php artisan make:controller WakaKurikulum/Elearning/Nilai/KurikulumNilaiPTSPASController --resource

App\Http\Controllers\WakaKurikulum$Folder$namaController


php artisan make:migration Migration_KurikulumNilaiPTSPAS




*/
    /*
    KurikulumNilaiPTSPAS
    $KurikulumNilaiPTSPAS
    role.waka.kurikulum.nilai
    role.waka.kurikulum.nilai.data-nilai-pts-pas
    role.waka.kurikulum.nilai.blade_show
    Index = Data Nilai PTS dan PAS
    Breadcume Index = 'Waka Kurikulum / Data Nilai PTS dan PAS';
    Single = Data Nilai PTS dan PAS
    php artisan make:view role.waka.kurikulum.nilai.data-nilai-pts-pas
    php artisan make:view role.waka.kurikulum.nilai.data-nilai-pts-pas-single
    php artisan make:seed KurikulumNilaiPTSPASSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Nilai PTS dan PAS';
        $arr_ths = [
            'NIS',
            'Nama Siswa',
            'Mapel',
        ];
        $breadcrumb = 'Waka Kurikulum / Data Nilai PTS dan PAS';
        $titleviewModal = 'Lihat Data Nilai PTS dan PAS';
        $titleeditModal = 'Edit Data Nilai PTS dan PAS';
        $titlecreateModal = 'Create Data Nilai PTS dan PAS';
        $datas = KurikulumNilaiPTSPAS::get();
        $datas = \App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUH::get();
        $datas = Detailsiswa::with('nilaiUH')->orderBy('kelas_id', 'ASC')->orderBy('nama_siswa', 'ASC')->get();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $datas = Emengajar::where('tapel_id', $etapels->id)->orderBy('kelas_id', 'ASC')->orderBy('mapel_id', 'ASC')->get();

        return view('role.waka.kurikulum.nilai.data-nilai-pts-pas', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
        //php artisan make:view role.waka.kurikulum.nilai.data-nilai-pts-pas

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Nilai PTS dan PAS';
        $arr_ths = [
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Mapel',
            'KKM',
            'Nama Guru',
        ];
        $breadcrumb = 'Waka Kurikulum / Data Nilai PTS dan PAS';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = KurikulumNilaiPTSPAS::get();
        $datas = \App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUH::get();
        $datas = Detailsiswa::with('nilaiUH')->orderBy('kelas_id', 'ASC')->orderBy('nama_siswa', 'ASC')->get();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $KKM = KurikulumDataKKM::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.nilai.data-nilai-pts-pas-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'KKM',
        ));
        //php artisan make:view role.waka.kurikulum.nilai.data-nilai-pts-pas-single
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



        KurikulumNilaiPTSPAS::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, KurikulumNilaiPTSPAS $KurikulumNilaiPTSPAS)
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
        $varmodel = KurikulumNilaiPTSPAS::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //KurikulumNilaiPTSPAS
        // dd(id);
        // dd(request->all());
        $data = KurikulumNilaiPTSPAS::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
