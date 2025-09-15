<?php

namespace App\Http\Controllers\WakaKurikulum\Perangkat;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\Perangkat\PerangkatBeritaAcara;
use App\Models\WakaKurikulum\Perangkat\PesertaTest;

class PerangkatBeritaAcaraController extends Controller
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
php artisan make:view role.waka.kurikulum.Perangkat.berita-acara
php artisan make:view role.waka.kurikulum.Perangkat.berita-acara-single
php artisan make:model WakaKurikulum/Perangkat/Perangkat/PerangkatBeritaAcara
php artisan make:controller WakaKurikulum/Perangkat/Perangkat/PerangkatBeritaAcaraController --resource



php artisan make:seeder WakaKurikulum/Perangkat/Perangkat/PerangkatBeritaAcaraSeeder
php artisan make:migration PerangkatMigration_BeritaAcara



     */
    /*
    PerangkatBeritaAcara
    $perangkatba
    role.waka.kurikulum.Perangkat
    role.waka.kurikulum.Perangkat.berita-acara
    role.waka.kurikulum.Perangkat.blade_show
    Index = Berita Acara
    Breadcume Index = 'Waka Kurikulum / Perangkat Test /Berita Acara';
    Single = Berita Acara
    php artisan make:view role.waka.kurikulum.Perangkat.berita-acara
    php artisan make:view role.waka.kurikulum.Perangkat.berita-acara-single
    php artisan make:seed WakaKurikulum/Perangkat/PerangkatBeritaAcaraSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Berita Acara';
        $arr_ths = [
            'No Ruangan',
            'Hari Dan Tanggal',
            'Mapel',
            'Durasi',
            'Pengawas',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Waka Kurikulum / Perangkat Test /Berita Acara';
        $titleviewModal = 'Lihat Data Berita Acara';
        $titleeditModal = 'Edit Data Berita Acara';
        $titlecreateModal = 'Create Data Berita Acara';
        $datas = PerangkatBeritaAcara::where('tapel_id', $etapels->id)->orderBy('tanggal_pelaksanaan', 'ASC')->get();
        $dataPesertas = PesertaTest::where('tapel_id', $etapels->id)->get();
        return view('role.waka.kurikulum.Perangkat.berita-acara', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'dataPesertas',
        ));
        //php artisan make:view role.waka.kurikulum.Perangkat.berita-acara

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Berita Acara';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Waka Kurikulum / Perangkat Test /Berita Acara';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = PerangkatBeritaAcara::where('tapel_id', $etapels->id)->get();
        return view('role.waka.kurikulum.Perangkat.berita-acara-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
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
            'tapel_id' => 'nullable|exists:etapels,id',
            'semester' => 'nullable|string|max:255',
            'tanggal_pelaksanaan' => 'nullable|date',
            'durasi' => 'nullable|integer|min:1',
            'mapel_id' => 'nullable|exists:emapels,id',
            'ruang_test' => 'nullable|integer|min:1',
            'detailguru_id' => 'nullable|exists:detailgurus,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        PerangkatBeritaAcara::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, PerangkatBeritaAcara $perangkatba)
    {
        //
        $data = json_encode($request->detailsiswa_id);
        $perangkat = \App\Models\WakaKurikulum\Perangkat\PerangkatBeritaAcara::first('id', $id); // Pastikan $id didefinisikan atau diterima dari request
        // dd($perangkat);
        if ($perangkat) {
            $perangkat->detailsiswa_id = $data;
            $perangkat->keterangan = $request->keterangan;
            $perangkat->save(); // Simpan perubahan
        }
        Session::flash('success', 'Data Siswa Tidak Hadir Berhasil Tersimpan');
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = PerangkatBeritaAcara::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
