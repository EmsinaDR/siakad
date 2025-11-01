<?php

namespace App\Http\Controllers\WakaKurikulum\Elearning\Nilai;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\WakaKurikulum\Elearning\KurikulumDataKKM;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUjian;
use App\Models\WakaKurikulum\Elearning\Nilai\KurulumDataPesertaUjian;
use Symfony\Component\Routing\Matcher\RedirectableUrlMatcher;

class KurikulumNilaiUjianController extends Controller
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

php artisan make:view role.waka.kurikulum.nilai.data-nilai-ujian
php artisan make:view role.waka.kurikulum.nilai.data-nilai-ujian-single
php artisan make:seeder WakaKurikulum/Elearning/Nilai/KurikulumNilaiUjianSeeder
php artisan make:model WakaKurikulum/Elearning/Nilai/KurikulumNilaiUjian
php artisan make:controller WakaKurikulum/Elearning/Nilai/KurikulumNilaiUjianController --resource

App\Http\Controllers\WakaKurikulum$Folder$namaController


php artisan make:migration Migration_KurikulumNilaiUjian




*/
    /*
    KurikulumNilaiUjian
    $kurikulumNilaiUjian
    role.waka.kurikulum.nilai
    role.waka.kurikulum.nilai.data-nilai-ujian
    role.waka.kurikulum.nilai.blade_show
    Index = Data Nilai Ujian
    Breadcume Index = 'Waka Kurikulum / Data Nilai Ujian';
    Single = titel_data_single
    php artisan make:view role.waka.kurikulum.nilai.data-nilai-ujian
    php artisan make:view role.waka.kurikulum.nilai.data-nilai-ujian-single
    php artisan make:seed KurikulumNilaiUjianSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Nilai Ujian';
        $arr_ths = [
            'NIS',
            'Nomor Ujian',
            'Kelas',
            'Nama Siswa',
        ];
        $breadcrumb = 'Waka Kurikulum / Data Nilai Ujian';
        $titleviewModal = 'Lihat Data Nilai Ujian';
        $titleeditModal = 'Edit Data Nilai Ujian';
        $titlecreateModal = 'Create Data Nilai Ujian';
        $etapels = \App\Models\Admin\Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $datas = KurikulumNilaiUjian::where('tapel_id', $etapels->id)->get();

        $datas = Detailsiswa::Where('tingkat_id', 9)->OrderBy('kelas_id', 'ASC')->OrderBy('nama_siswa', 'ASC')->get();
        $datas = \App\Models\WakaKurikulum\Elearning\Nilai\KurulumDataPesertaUjian::where('tapel_id', $etapels->id)->OrderBy('kelas_id', 'ASC')->OrderBy('nama_siswa', 'ASC')->get();

        $KKMMapel = KurikulumDataKKM::get();
        return view('role.waka.kurikulum.nilai.data-nilai-ujian', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'KKMMapel',
            'etapels',
            // 'Siswa',
        ));
        //php artisan make:view role.waka.kurikulum.nilai.data-nilai-ujian

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Nilai Ujian';
        $arr_ths = [
            'Mapel',
        ];
        $breadcrumb = 'Waka Kurikulum / Data Nilai Ujian';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $datas = KurikulumNilaiUjian::where('tapel_id', $etapels->id)->where('id', request()->segment(3))->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.nilai.data-nilai-ujian-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.kurikulum.nilai.data-nilai-ujian-single
    }

    public function store(Request $request)
    {
        //

        // dd($request->all());
        // Pastikan Tapel aktif tersedia
        // Ambil Tapel aktif


        $etapels = Etapel::where('aktiv', 'Y')->first();
        if (!$etapels) {
            return redirect()->back()->withErrors(['tapel_id' => 'Tapel aktif tidak ditemukan.'])->withInput();
        }

        // Tambahkan tapel_id ke request
        $request->merge([
            'tapel_id' => $etapels->id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'tapel_id' => 'required|integer',
            'mapel_id' => 'required|array',
            'mapel_id.*' => 'integer|exists:emapels,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ambil semua siswa tingkat 9
        $siswas = KurulumDataPesertaUjian::orderBy('id', 'ASC')->get();
        // dd($siswas);
        if (!$siswas) {
            Session::flash('success', 'Data Tidak Ada Karena Data Peserta Belum Diambil');
            return Redirect::back();
        }
        // Data yang akan diinsert (batch insert)
        $dataInsert = [];
        foreach ($request->mapel_id as $mapel) {
            $counter = 1; // Mulai dari 001
            foreach ($siswas as $siswa) {
                // Cek apakah data sudah ada di database
                $exists = DB::table('enilai_ujian')
                    ->where([
                        ['tapel_id', '=', $request->tapel_id],
                        ['mapel_id', '=', $mapel],
                    ])
                    ->exists();

                // Jika belum ada, masukkan ke dalam array untuk batch insert
                if (!$exists) {
                    $dataInsert[] = [
                        'tapel_id' => $request->tapel_id,
                        'mapel_id' => $mapel,
                        'nilai' => 0,
                        'peserta_id' => $siswa->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $counter++; // Tambah nomor urut
                }
            }
        }

        // Simpan ke database dengan batch insert (tanpa duplikat)
        if (!empty($dataInsert)) {
            DB::table('enilai_ujian')->insert($dataInsert);
        }


        // dd($request->all());
        // KurikulumNilaiUjian::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, KurikulumNilaiUjian $kurikulumNilaiUjian)
    {
        // Ambil hanya id dan nilai dari request
        $data = $request->only(['id', 'nilai']);

        // Pastikan jumlah ID dan Nilai sama
        if (count($data['id']) !== count($data['nilai'])) {
            return redirect()->back()->withErrors(['message' => 'Jumlah ID dan Nilai tidak cocok']);
        }

        // Buat pasangan ID => Nilai
        $nilaiUjian = array_combine($data['id'], $data['nilai']);

        // Loop untuk update data satu per satu
        foreach ($nilaiUjian as $id => $nilai) {
            DB::table('enilai_ujian')
                ->where('id', $id)
                ->update(['nilai' => $nilai, 'updated_at' => now()]);
        }

        return redirect()->back()->with('success', 'Data nilai ujian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, KurikulumNilaiUjian $kurikulumNilaiUjian)
    {
        //KurikulumNilaiUjian
        // dd(id);
        // dd($request->all());
        // Cek apakah ada mapel_id dalam request dan harus berbentuk array
        if (!$request->has('mapel_id') || !is_array($request->mapel_id)) {
            return Redirect::back()->withErrors(['message' => 'Tidak ada mata pelajaran yang dipilih untuk dihapus.']);
        }
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        // Hapus semua data yang memiliki mapel_id yang dikirim
        KurikulumNilaiUjian::whereIn('mapel_id', $request->mapel_id)->where('tapel_id', $etapels->id)->delete();

        return Redirect::back()->with('success', 'Data nilai ujian berdasarkan mata pelajaran berhasil dihapus.');
    }

}
