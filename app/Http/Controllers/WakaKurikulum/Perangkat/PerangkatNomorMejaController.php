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
use App\Models\WakaKurikulm\Perangkat\PerangkatNomorMeja;
use App\Models\WakaKurikulum\Perangkat\PerangkatTempatDuduk;

class PerangkatNomorMejaController extends Controller
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

php artisan make:view role.waka.kurikulum.Perangkat.nomor-meja
php artisan make:view role.waka.kurikulum.Perangkat.nomor-meja-single
php artisan make:model WakaKurikulum/Perangkat/PerangkatNomorMeja
php artisan make:controller WakaKurikulum/Perangkat/PerangkatNomorMejaController --resource



php artisan make:seeder WakaKurikulum/Perangkat/PerangkatNomorMejaSeeder
php artisan make:migration Migration_PerangkatNomorMeja




    PerangkatNomorMeja
    $perangkatnomerja
    role.waka.kurikulum.Perangkat
    role.waka.kurikulum.Perangkat.nomor-meja
    role.waka.kurikulum.Perangkat.blade_show
    Index = Nomor Meja
    Breadcume Index = 'Waka Kurikulum / Perangkat Test / Nomor Meja';
    Single = Nomor Meja
    php artisan make:view role.waka.kurikulum.Perangkat.nomor-meja
    php artisan make:view role.waka.kurikulum.Perangkat.nomor-meja-single
    php artisan make:seed PerangkatNomorMejaSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Nomor Meja';
        $arr_ths = [
            'Ruangan',
            'Jumlah Peserta',
        ];
        $breadcrumb = 'Waka Kurikulum / Perangkat Test / Nomor Meja';
        $titleviewModal = 'Lihat Data Nomor Meja';
        $titleeditModal = 'Edit Data Nomor Meja';
        $titlecreateModal = 'Create Data Nomor Meja';
        $etapels = Etapel::where('aktiv', 'Y')->first();

        $datas = PesertaTest::where('tapel_id', $etapels->id)->groupBy('nomor_ruangan')->orderBy('nomor_ruangan', 'ASC')->get();
        // dd($datas_kartu_test);
        $MeplTest = JadwalTest::where('tapel_id', $etapels->id)->where('nomor_ruangan', 2)->count();

        return view('role.waka.kurikulum.Perangkat.nomor-meja', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titleeditModal',
            'titlecreateModal',
        ));
        //php artisan make:view role.waka.kurikulum.Perangkat.nomor-meja

    }


    public function show()
    {
        //
        //Title to Controller

        $title = 'Nomor Meja';
        $arr_ths = [
            'Ruangan',
            'Jumlah Peserta',
        ];
        $breadcrumb = 'Waka Kurikulum / Perangkat Test / Nomor Meja';
        $titleviewModal = 'Lihat Data Nomor Meja';
        $titleeditModal = 'Edit Data Nomor Meja';
        $titlecreateModal = 'Create Data Nomor Meja';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $etapels = Etapel::where('aktiv', 'Y')->first();

        $datas = PesertaTest::orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_vii = PesertaTest::where('tingkat_id', 7)->orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_viii = PesertaTest::where('tingkat_id', 8)->orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_ix = PesertaTest::where('tingkat_id', 9)->orderBy('kelas_id', 'ASC')->get();
        // dd($datas_kelas_vii);
        $group_by_ruang = PesertaTest::orderBy('nomor_ruangan', 'ASC')
            ->get()
            ->groupBy('nomor_ruangan');
        //Pasangan Tempat Duduk
        $group_by_ruang = PesertaTest::orderBy('nomor_ruangan', 'ASC')->where('nomor_ruangan', request()->segment(3))->get()->groupBy('nomor_ruangan');
        // dump(request()->segment(3));
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

        //Pasangan Tempat Duduk

        $datas_kartu_test = PesertaTest::limit(50)->get();
        // dd($datas_kartu_test);



        // Tentukan jumlah maksimum baris agar sejajar
        $max_rows = max($datas_kelas_vii->count(), $datas_kelas_viii->count(), $datas_kelas_ix->count());
        $MeplTest = JadwalTest::where('tapel_id', $etapels->id)->where('nomor_ruangan', 2)->count();

        return view('role.waka.kurikulum.Perangkat.nomor-meja-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titleeditModal',
            'titlecreateModal',
            'MeplTest',
            'group_by_ruang',
            'paired_data',
        ));
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.Perangkat.nomor-meja-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.kurikulum.Perangkat.nomor-meja-single
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



        PerangkatNomorMeja::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, PerangkatNomorMeja $perangkatnomerja)
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
        $varmodel = PerangkatNomorMeja::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //PerangkatNomorMeja
        // dd($id);
        // dd($request->all());
        $data = PerangkatNomorMeja::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
