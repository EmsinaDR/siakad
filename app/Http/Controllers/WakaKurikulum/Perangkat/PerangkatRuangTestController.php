<?php

namespace App\Http\Controllers\WakaKurikulum\Perangkat;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\Perangkat\PesertaTest;
use App\Models\WakaKurikulum\Perangkat\PerangkatRuangTest;

class PerangkatRuangTestController extends Controller
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

php artisan make:view role.waka.kurikulum.Perangkat.ruang-test
php artisan make:view role.waka.kurikulum.Perangkat.ruang-test-single
php artisan make:model WakaKurikulum/Perangkat/PerangkatRuangTest
php artisan make:controller WakaKurikulum/Perangkat/PerangkatRuangTestController --resource



php artisan make:seeder WakaKurikulum/Perangkat/PerangkatRuangTestSeeder
php artisan make:migration PerangkMigration_RuangTest



    PerangkatRuangTest
    $perangkatruangtest
    role.waka.kurikulum.Perangkat
    role.waka.kurikulum.Perangkat.ruang-test
    role.waka.kurikulum.Perangkat.blade_show
    Index = Perangkat Test
    Breadcume Index = 'Waka Kurikulum / Perangkat Test';
    Single = Perangkat Test
    php artisan make:view role.waka.kurikulum.Perangkat.ruang-test
    php artisan make:view role.waka.kurikulum.Perangkat.ruang-test-single
    php artisan make:seed PerangkatRuangTestSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Perangkat Test';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kurikulum / Perangkat Test';
        $titleviewModal = 'Lihat Data Perangkat Test';
        $titleeditModal = 'Edit Data Perangkat Test';
        $titlecreateModal = 'Create Data Perangkat Test';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = PerangkatRuangTest::get();
        $SiswaDropdown = PesertaTest::where('tapel_id', $etapels->id)->orderBy('kelas_id', 'ASC')->orderBy('nama_siswa', 'ASC')->get();
        $datas = PesertaTest::where('tapel_id', $etapels->id)->orderBy('nomor_ruangan', 'ASC')->orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_vii = PesertaTest::where('tapel_id', $etapels->id)->where('tingkat_id', 7)->orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_viii = PesertaTest::where('tapel_id', $etapels->id)->where('tingkat_id', 8)->orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_ix = PesertaTest::where('tapel_id', $etapels->id)->where('tingkat_id', 9)->orderBy('kelas_id', 'ASC')->get();
        $group_by_ruang = PesertaTest::orderBy('nomor_ruangan', 'ASC')
            ->get()
            ->groupBy('nomor_ruangan');
        //Pasangan Tempat Duduk
        $group_by_ruang = PesertaTest::orderBy('nomor_ruangan', 'ASC')->get()->groupBy('nomor_ruangan');

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

        return view('role.waka.kurikulum.perangkat.ruang-test', compact(
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
            'SiswaDropdown',
        ));
        //php artisan make:view role.waka.kurikulum.Perangkat.ruang-test

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Perangkat Test';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kurikulum / Perangkat Test';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = PerangkatRuangTest::where('tapel_id', $etapels->id)->get();
        return view('role.waka.kurikulum.Perangkat.ruang-test-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
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



        PerangkatRuangTest::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, PerangkatRuangTest $perangkatruangtest)
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
        $varmodel = PerangkatRuangTest::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //PerangkatRuangTest
        // dd($id);
        // dd($request->all());
        $data = PerangkatRuangTest::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
    public function UpdateRuangan(Request $request)
    {
        // dd($request->all());
        try {
            // Log data yang diterima untuk memeriksa apakah data sampai dengan benar
            Log::info('Data diterima:', $request->all());

            // Proses update data ke database
            foreach ($request->siswa_ids as $siswa_id) {
                PesertaTest::where('id', $siswa_id)
                    ->update(['nomor_ruangan' => $request->nomor_ruangan]);
            }

            // Kembalikan respons sukses
            Session::flash('success', 'Data Siswa di ruangan : ' . $request->nomor_ruangan . ' telah diperbaharui');
            return Redirect::back();
            // return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data ruangan telah diperbaharui');
        } catch (\Exception $e) {
            // Log error jika terjadi kesalahan
            Log::error('Gagal update:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Gagal memperbarui ruang test!'], 500);
        }
    }
    public function resetRuangan(Request $request)
    {
        try {
            // Cari tapel aktif
            $etapels = Etapel::where('aktiv', 'Y')->first();

            if (!$etapels) {
                Session::flash('error', 'Data Etapel tidak ditemukan!');
                return Redirect::back();
            }

            // Update peserta test
            $affectedRows = PesertaTest::where('tapel_id', $etapels->id)
                ->update(['nomor_ruangan' => null]);

            if ($affectedRows > 0) {
                Session::flash('success', 'Semua peserta telah direset dari ruangan.');
            } else {
                Session::flash('warning', 'Tidak ada data peserta yang diperbarui.');
            }

            return Redirect::back();
        } catch (\Exception $e) {
            Log::error('Gagal reset ruangan:', ['error' => $e->getMessage()]);
            Session::flash('error', 'Gagal memperbarui ruang test!');
            return Redirect::back();
        }
    }
}
