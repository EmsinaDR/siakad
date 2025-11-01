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
use App\Models\WakaKurikulum\Perangkat\TempatDudukTest;
use App\Models\WakaKurikulum\Perangkat\PerangkatTempatDuduk;

class PerangkatTempatDudukController extends Controller
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

php artisan make:view role.waka.kurikulum.Perangkat.tempat-duduk
php artisan make:view role.waka.kurikulum.Perangkat.tempat-duduk-single
php artisan make:model WakaKurikulum/Perangkat/PerangkatTempatDuduk
php artisan make:controller WakaKurikulum/Perangkat/PerangkatTempatDudukController --resource



php artisan make:seeder WakaKurikulum/Perangkat/PerangkatTempatDudukSeeder
php artisan make:migration Migration_PerangkatTempatDuduk




     */
    /*
    PerangkatTempatDuduk
    $PerangkatTemptDududuk
    role.waka.kurikulum.Perangkat
    role.waka.kurikulum.Perangkat.tempat-duduk
    role.waka.kurikulum.Perangkat.blade_show
    Index = Tempat Dududk
    Breadcume Index = 'Waka Kurikulum / Perangkat Test / Tempat Dududk';
    Single = Tempat Duduk
    php artisan make:view role.waka.kurikulum.Perangkat.tempat-duduk
    php artisan make:view role.waka.kurikulum.Perangkat.tempat-duduk-single
    php artisan make:seed PerangkatTempatDudukSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Tempat Dududk';
        $arr_ths = [
            'Ruangan',
            'Jumlah Peserta',
        ];
        $breadcrumb = 'Waka Kurikulum / Perangkat Test / Tempat Dududk';
        $titleviewModal = 'Lihat Data Tempat Dududk';
        $titleeditModal = 'Edit Data Tempat Dududk';
        $titlecreateModal = 'Create Data Tempat Dududk';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $datas = PerangkatTempatDuduk::where('aktiv', 'Y')->get();
        $datas = PesertaTest::where('tapel_id', $etapels->id)->select('nomor_ruangan', DB::raw('COUNT(*) as jumlah_siswa'))
            ->groupBy('nomor_ruangan')
            ->get();

        // Data Tempat Duduk
        $datas_kelas_vii = PesertaTest::where('tingkat_id', 7)->orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_viii = PesertaTest::where('tingkat_id', 8)->orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_ix = PesertaTest::where('tingkat_id', 9)->orderBy('kelas_id', 'ASC')->get();
        // dd($datas_kelas_vii);
        $group_by_ruang = PesertaTest::orderBy('nomor_ruangan', 'ASC')
            ->get()
            ->groupBy('nomor_ruangan');
        //Pasangan Tempat Duduk
        $group_by_ruang = PesertaTest::orderBy('kelas_id', 'ASC')->orderBy('nomor_ruangan', 'ASC')->get()->groupBy('nomor_ruangan');

        $paired_data = [];

        foreach ($group_by_ruang as $ruang => $pesertas) {
            $count = count($pesertas);
            $mid = ceil($count / 2);

            $first_half = $pesertas->slice(0, $mid)->values();
            $second_half = $pesertas->slice($mid)->values();

            for ($i = 0; $i < count($second_half); $i++) {
                $paired_data[$ruang][] = [
                    'first' => $first_half[$i],
                    'second' => $second_half[$i]
                ];
            }

            // Jika ada sisa di first_half (karena jumlah ganjil), tambahkan ke pasangan sendiri
            if (count($first_half) > count($second_half)) {
                $paired_data[$ruang][] = [
                    'first' => $first_half[count($second_half)],
                    'second' => null
                ];
            }
        }
        // Data Tempat Duduk

        $MeplTest = JadwalTest::where('tapel_id', $etapels->id)->where('nomor_ruangan', 2)->count();

        return view('role.waka.kurikulum.Perangkat.tempat-duduk', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'MeplTest',
            'group_by_ruang',
            'paired_data',
        ));
        //php artisan make:view role.waka.kurikulum.Perangkat.tempat-duduk

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Tempat Dududk';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kurikulum / Perangkat Test / Tempat Dududk';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = PerangkatTempatDuduk::get();
        $title = 'Pasangan Duduk';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kurikulum/ Perangkat Test  / Pasangan Duduk';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = PesertaTest::orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_vii = PesertaTest::where('tingkat_id', 7)->orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_viii = PesertaTest::where('tingkat_id', 8)->orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_ix = PesertaTest::where('tingkat_id', 9)->orderBy('kelas_id', 'ASC')->get();
        // dd($datas_kelas_vii);
        $group_by_ruang = PesertaTest::orderBy('nomor_ruangan', 'ASC')
            ->get()
            ->groupBy('nomor_ruangan');
        //Pasangan Tempat Duduk
        //->where('nomor_ruangan', request()->segment(3))
        $group_by_ruang = PesertaTest::orderBy('nomor_ruangan', 'ASC')->where('nomor_ruangan', request()->segment(3))->get()->groupBy('nomor_ruangan');

        $paired_data = [];

        foreach ($group_by_ruang as $ruang => $pesertas) {
            $count = count($pesertas);
            $mid = ceil($count / 2);

            $first_half = $pesertas->slice(0, $mid)->values();
            $second_half = $pesertas->slice($mid)->values();

            for ($i = 0; $i < count($second_half); $i++) {
                $paired_data[$ruang][] = [
                    'first' => $first_half[$i],
                    'second' => $second_half[$i]
                ];
            }

            // Jika ada sisa di first_half (karena jumlah ganjil), tambahkan ke pasangan sendiri
            if (count($first_half) > count($second_half)) {
                $paired_data[$ruang][] = [
                    'first' => $first_half[count($second_half)],
                    'second' => null
                ];
            }
        }
        $datas_kartu_test = PesertaTest::limit(50)->get();
        // dd($datas_kartu_test);



        // Tentukan jumlah maksimum baris agar sejajar
        $max_rows = max($datas_kelas_vii->count(), $datas_kelas_viii->count(), $datas_kelas_ix->count());

        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.Perangkat.tempat-duduk-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'datas_kelas_vii',
            'datas_kelas_viii',
            'datas_kelas_ix',
            'max_rows',
            'group_by_ruang',
            'datas_kartu_test',
            'paired_data',
        ));
        //php artisan make:view role.waka.kurikulum.Perangkat.tempat-duduk-single
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



        PerangkatTempatDuduk::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, PerangkatTempatDuduk $PerangkatTemptDududuk)
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
        $varmodel = PerangkatTempatDuduk::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //PerangkatTempatDuduk
        // dd($id);
        // dd($request->all());
        $data = PerangkatTempatDuduk::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
