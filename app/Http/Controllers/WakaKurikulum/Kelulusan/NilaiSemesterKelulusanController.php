<?php

namespace App\Http\Controllers\WakaKurikulum\Kelulusan;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\WakaKurikulum\Elearning\Nilai\KurulumDataPesertaUjian;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\Kelulusan\NilaiSemesterKelulusan;

class NilaiSemesterKelulusanController extends Controller
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

php artisan make:view role.waka.kurikulum.kelulusan.nilai-semester
php artisan make:view role.waka.kurikulum.kelulusan.nilai-semester-single
php artisan make:model WakaKurikulum/Kelulusan/NilaiSemesterKelulusanKelulusan
php artisan make:controller WakaKurikulum/Kelulusan/NilaiSemesterKelulusanKelulusanController --resource



php artisan make:seeder WakaKurikulum/kelulusan/NilaiSemesterKelulusanKelulusanSeeder
php artisan make:migration Migration_NilaiSemesterKelulusanKelulusan




*/
    /*
    NilaiSemesterKelulusan
    $NilaiSemesterKelulusan
    role.waka.kurikulum.kelulusan
    role.waka.kurikulum.kelulusan.nilai-semester
    role.waka.kurikulum.kelulusan.blade_show
    Index = Nilai Semester 1 - 5
    Breadcume Index = 'Waka Kuriulum / Kelulusan / Nilai Semester 1 - 5';
    Single = Nilai Semester 1 - 5
    php artisan make:view role.waka.kurikulum.kelulusan.nilai-semester
    php artisan make:view role.waka.kurikulum.kelulusan.nilai-semester-single
    php artisan make:seed NilaiSemesterKelulusanSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Nilai Semester 1 - 5';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kuriulum / Kelulusan / Nilai Semester 1 - 5';
        $titleviewModal = 'Lihat Data Nilai Semester 1 - 5';
        $titleeditModal = 'Edit Data Nilai Semester 1 - 5';
        $titlecreateModal = 'Create Data Nilai Semester 1 - 5';
        $etapels = Etapel::where('aktiv', 'Y')->get();
        // $datas = NilaiSemesterKelulusan::where('tapel_id', $etapels->id)->get();
        // $datas = DB::table('raport_pengetahuan as rp')
        //     ->leftJoin('raport_keterampilan as rk', function ($join) {
        //         $join->on('rp.mapel_id', '=', 'rk.mapel_id')
        //             ->on('rp.detailsiswa_id', '=', 'rk.detailsiswa_id')
        //             ->on('rp.tapel_id', '=', 'rk.tapel_id');
        //     })
        //     ->leftJoin('detailsiswas as s', 'rp.detailsiswa_id', '=', 's.id')
        //     ->leftJoin('emapels as m', 'rp.mapel_id', '=', 'm.id')
        //     ->select(
        //         'rp.detailsiswa_id',
        //         's.nama_siswa',
        //         'rp.mapel_id',
        //         'm.mapel',
        //         'rp.tapel_id',
        //         'rp.nilai as nilai_pengetahuan',
        //         DB::raw('COALESCE(rk.nilai, 0) as nilai_keterampilan'),
        //         DB::raw('ROUND((rp.nilai + COALESCE(rk.nilai, 0)) / 2, 2) as rata_rata')
        //     )
        //     ->orderBy('rp.detailsiswa_id')
        //     ->orderBy('rp.mapel_id')
        //     ->orderBy('rp.tapel_id')
        //     ->get();
        $datas = DB::table('raport_pengetahuan as rp')
            ->leftJoin('raport_keterampilan as rk', function ($join) {
                $join->on('rp.mapel_id', '=', 'rk.mapel_id')
                    ->on('rp.detailsiswa_id', '=', 'rk.detailsiswa_id')
                    ->on('rp.tapel_id', '=', 'rk.tapel_id');
            })
            ->leftJoin('detailsiswas as s', 'rp.detailsiswa_id', '=', 's.id')
            ->leftJoin('emapels as m', 'rp.mapel_id', '=', 'm.id')
            ->select(
                'rp.detailsiswa_id',
                's.nama_siswa',
                'rp.mapel_id',
                'm.mapel',
                'rp.tapel_id',
                'rp.nilai as nilai_pengetahuan',
                DB::raw('COALESCE(rk.nilai, 0) as nilai_keterampilan'),
                DB::raw('ROUND((rp.nilai + COALESCE(rk.nilai, 0)) / 2, 2) as rata_rata')
            )
            ->orderBy('rp.detailsiswa_id')
            ->orderBy('rp.mapel_id')
            ->orderBy('rp.tapel_id')
            ->get();
        // Format ulang data agar tapel_id jadi kolom header
        $formattedData = [];
        $tapelList = [];

        foreach ($datas as $data) {
            // Simpan daftar tahun ajaran unik untuk header
            if (!in_array($data->tapel_id, $tapelList)) {
                $tapelList[] = $data->tapel_id;
            }

            // Susun data per siswa dan mapel
            $formattedData[$data->detailsiswa_id]['nama_siswa'] = $data->nama_siswa;
            $formattedData[$data->detailsiswa_id]['mapel'][$data->mapel_id]['mapel'] = $data->mapel;
            $formattedData[$data->detailsiswa_id]['mapel'][$data->mapel_id]['nilai'][$data->tapel_id] = [
                'pengetahuan' => $data->nilai_pengetahuan,
                'keterampilan' => $data->nilai_keterampilan,
                'rata_rata' => $data->rata_rata,
            ];
        }

        // Urutkan tahun ajaran agar header tersusun dengan benar
        sort($tapelList);


        // dd($datas);

        return view('role.waka.kurikulum.kelulusan.nilai-semester', compact(
            'datas',
            'tapelList',
            'formattedData',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.waka.kurikulum.kelulusan.nilai-semester

    }


    public function show($detailsiswa_id)
    {
        $title = 'Nilai Semester 1 - 5';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kuriulum / Kelulusan / Nilai Semester 1 - 5';
        $titleviewModal = 'Lihat Data Nilai Semester 1 - 5';
        $titleeditModal = 'Edit Data Nilai Semester 1 - 5';
        $titlecreateModal = 'Create Data Nilai Semester 1 - 5';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $TapelRange = range($etapels->id - 5, $etapels->id - 1);
        $datas = DB::table('raport_pengetahuan as rp')
            ->leftJoin('raport_keterampilan as rk', function ($join) {
                $join->on('rp.mapel_id', '=', 'rk.mapel_id')
                    ->on('rp.detailsiswa_id', '=', 'rk.detailsiswa_id')
                    ->on('rp.tapel_id', '=', 'rk.tapel_id');
            })
            ->leftJoin('detailsiswas as s', 'rp.detailsiswa_id', '=', 's.id')
            ->leftJoin('emapels as m', 'rp.mapel_id', '=', 'm.id')
            ->select(
                'rp.detailsiswa_id',
                's.nama_siswa',
                'rp.mapel_id',
                'm.mapel',
                'rp.tapel_id',
                'rp.nilai as nilai_pengetahuan',
                DB::raw('COALESCE(rk.nilai, 0) as nilai_keterampilan'),
                DB::raw('ROUND((rp.nilai + COALESCE(rk.nilai, 0)) / 2, 2) as rata_rata')
            )
            ->where('rp.detailsiswa_id', $detailsiswa_id) // Filter berdasarkan siswa
            ->whereIn('rp.tapel_id', $TapelRange) // Hanya tapel 1-7
            ->orderBy('rp.mapel_id')
            ->orderBy('rp.tapel_id')
            ->get();

        if ($datas->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.kelulusan.nilai-semester-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.waka.kurikulum.kelulusan.nilai-semester-single
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



        NilaiSemesterKelulusan::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, NilaiSemesterKelulusan $NilaiSemesterKelulusan)
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
        $varmodel = NilaiSemesterKelulusan::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //NilaiSemesterKelulusan
        // dd($id);
        // dd($request->all());
        $data = NilaiSemesterKelulusan::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
