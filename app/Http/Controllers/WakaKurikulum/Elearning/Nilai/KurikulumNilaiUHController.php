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

class KurikulumNilaiUHController extends Controller
{
    /*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view role.waka.kurikulum.nilai.daftar-nilai-uh
php artisan make:view role.waka.kurikulum.nilai.daftar-nilai-uh-single
php artisan make:seeder WakaKurikulum/Nilai/KurikulumNilaiUHSeeder
php artisan make:model WakaKurikulum/Nilai/KurikulumNilaiUH
php artisan make:controller WakaKurikulum/Nilai/KurikulumNilaiUHController --resource

App\Http\Controllers\WakaKurikulum$Folder$namaController


php artisan make:migration Migration_Nilai/KurikulumNilaiUH

*/
    /**
     * Display a listing of the resource.
     */
    /*
    KurikulumNilaiUH
    $kurikulumnilaiuh
    role.waka.kurikulum.nilai
    role.waka.kurikulum.nilai.daftar-nilai-uh
    role.waka.kurikulum.nilai.blade_show
    Index = Daftar Nilai UH
    Breadcume Index = 'Waka Kurikulum / Daftar Nilai UH';
    Single = titel_data_single
    php artisan make:view role.waka.kurikulum.nilai.daftar-nilai-uh
    php artisan make:view role.waka.kurikulum.nilai.daftar-nilai-uh-single
    php artisan make:seed KurikulumNilaiUHSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Daftar Nilai UH';
        $arr_ths = [
            'Mapel',
            'Guru',
            'Kelas',
            // 'Mapel',
        ];
        $breadcrumb = 'Waka Kurikulum / Daftar Nilai UH';
        $titleviewModal = 'Lihat Data Daftar Nilai UH';
        $titleeditModal = 'Edit Data Daftar Nilai UH';
        $titlecreateModal = 'Create Data Daftar Nilai UH';
        $datas = \App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUH::get();
        // $datas = Detailsiswa::with('nilaiUH')->orderBy('kelas_id', 'ASC')->orderBy('nama_siswa', 'ASC')->get();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $datas = Emengajar::where('tapel_id', $etapels->id)->orderBy('kelas_id', 'ASC')->orderBy('mapel_id', 'ASC')->get();


        return view('role.waka.kurikulum.nilai.daftar-nilai-uh', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.waka.kurikulum.nilai.daftar-nilai-uh

    }


    public function show($id)
    {
        //
        //Title to Controller
        //
        //Title to Controller
        $title = 'Daftar Nilai UH';
        $arr_ths = [
            'NIS',
            'Nama',
            'Kelas',
            'KKM',
            'Mapel',
            'Guru',
            // 'Mapel',
        ];
        $breadcrumb = 'Waka Kurikulum / Daftar Nilai UH';
        $titleviewModal = 'Lihat Data Daftar Nilai UH';
        $titleeditModal = 'Edit Data Daftar Nilai UH';
        $titlecreateModal = 'Create Data Daftar Nilai UH';
        $datas = \App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUH::where('mapel_id', request()->segment(3))->get();
        // dd(request()->segment(3));
        $datas = Detailsiswa::with('nilaiUH')->where('kelas_id', request()->segment(4))->orderBy('kelas_id', 'ASC')->orderBy('nama_siswa', 'ASC')->get();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $KKM = KurikulumDataKKM::where('tapel_id', $etapels->id)->get();
        // dd($datas);

        return view('role.waka.kurikulum.nilai.daftar-nilai-uh-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'KKM',
        ));
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



        KurikulumNilaiUH::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, KurikulumNilaiUH $kurikulumnilaiuh)
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
        $varmodel = KurikulumNilaiUH::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //KurikulumNilaiUH
        // dd(id);
        // dd(request->all());
        $data = KurikulumNilaiUH::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
