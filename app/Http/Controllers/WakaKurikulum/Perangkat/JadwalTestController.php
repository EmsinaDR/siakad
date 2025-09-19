<?php

namespace App\Http\Controllers\WakaKurikulum\Perangkat;

use Carbon\Carbon;
use App\Models\Admin\Emapel;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Learning\Emengajar;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\Perangkat\JadwalTest;

class JadwalTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    JadwalTest
    $jdtest
    role.waka.kurikulum.Perangkat
    role.waka.kurikulum.Perangkat.jadwal-test
    role.waka.kurikulum.Perangkat.blade_show
    Index = Jadwal Test
    Breadcume Index = 'Waka Kirikulum / Perangkat Test / Jadwal Test';
    Single = Jadwal Test
    php artisan make:view role.waka.kurikulum.Perangkat.jadwal-test
    php artisan make:view role.waka.kurikulum.Perangkat.jadwal-test-single
    php artisan make:seed JadwalTestSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Jadwal Test';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kirikulum / Perangkat Test / Jadwal Test';
        $titleviewModal = 'Lihat Data Jadwal Test';
        $titleeditModal = 'Edit Data Jadwal Test';
        $titlecreateModal = 'Create Data Jadwal Test';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->


        // $datas = JadwalTest::where('tapel_id', $etapels->id)
        //     ->with('mapeltest') // Menggunakan relasi baru
        //     ->orderBy('tanggal_pelaksanaan')
        //     ->orderBy('mapel_id')
        //     ->get()
        //     ->groupBy(['tanggal_pelaksanaan', 'mapel_id']);

        $datas = JadwalTest::where('tapel_id', $etapels->id)
            ->with('mapeltest') // Pastikan relasi benar
            ->orderBy('tanggal_pelaksanaan')
            ->orderBy('jam_mulai') // Tambahkan order by jam_mulai
            ->orderBy('mapel_id')
            ->get()
            ->groupBy(['tanggal_pelaksanaan', 'mapel_id']);



        // Ambil jumlah ruangan maksimal dari data
        $maxRuangan = JadwalTest::where('tapel_id', $etapels->id)
            ->where('semester', 'II')
            ->max('nomor_ruangan');
        // dd($datas);
        // $datas = JadwalTest::with('mapeltest')->get();
        // dd($datas);
        $JumlahPengawasan = JadwalTest::where('tapel_id', $etapels->id)->selectRaw('detailguru_id, COUNT(*) as count')
            ->groupBy('detailguru_id')
            ->get();

        $DataMapels = Emengajar::select('mapel_id')
            ->distinct()
            ->where('tapel_id', $etapels->id)->get();
        $DataMapelTest = JadwalTest::select('mapel_id')
            ->distinct()
            ->where('tapel_id', $etapels->id)->get();
        $DataPengawas = Detailguru::get();
        // dd($DataMapels);
        return view('role.waka.kurikulum.Perangkat.jadwal-test', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'maxRuangan',
            'JumlahPengawasan',
            'DataMapels',
            'DataPengawas',
            'DataMapelTest',
        ));
        //php artisan make:view role.waka.kurikulum.Perangkat.jadwal-test

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Jadwal Test';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kirikulum / Perangkat Test / Jadwal Test';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = JadwalTest::where('aktiv', 'Y')->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.Perangkat.jadwal-test-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.kurikulum.Perangkat.jadwal-test-single
    }

    public function store(Request $request)
    {
        //
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' =>  $etapels->semester,
        ]);

        foreach ($request->tanggal_pelaksanaan as $index => $tanggal) {
            for ($i = 1; $i <= (int) $request->nomor_ruangan[$index]; $i++) {
                // Mengambil waktu awal berdasarkan index
                $time = Carbon::parse($request->time[$index], 'Asia/Jakarta');

                // Menyalin waktu untuk menghindari perubahan yang tidak diinginkan
                $jamMulai = $time->copy();
                $jamSelesai = $time->copy()->addMinutes((int) $request->durasi[$index]); // Konversi ke integer

                // Data yang akan disimpan
                $dataSave = [
                    'tanggal_pelaksanaan' => $tanggal, // Ambil berdasarkan index
                    'mapel_id' => $request->mapel_id[$index], // Ambil berdasarkan index
                    'tapel_id' => $request->tapel_id,
                    'jam_mulai' => $jamMulai->format('H:i'), // Simpan dalam format string
                    'jam_selesai' => $jamSelesai->format('H:i'), // Simpan dalam format string
                    'nomor_ruangan' => $i,
                    'semester' => $request->semester,
                    'durasi' => (int) $request->durasi[$index], // Konversi ke integer
                ];

                // Debugging (Cek apakah data benar sebelum insert)
                // dd($dataSave);

                // Menyimpan data ke database
                JadwalTest::create($dataSave);
            }
        }



        // dd($dataSave);

        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update(Request $request)
    {

        // $jadwal = JadwalTest::find($request->id);
        // // $KodeGuru = Detailguru::where('kode_guru', $request->id)->first();

        // if (!$jadwal) {
        //     return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        // }

        // // $jadwal = JadwalTest::find($KodeGuru->id);
        // $jadwal->{$request->field} = $request->value;
        // $jadwal->save();

        // return response()->json(['success' => true]);
        // // Cek apakah request membawa nilai 'kode_guru' dan 'id'


        // Cek apakah kode_guru yang diberikan ada di database
        $kodeGuru = strtoupper($request->input('kode_guru')); // Mengubah kode_guru menjadi huruf kapital semua

        // Mencari detail guru berdasarkan kode guru yang sudah diubah menjadi kapital
        $detailGuru = Detailguru::where('kode_guru', $kodeGuru)->first();

        // Jika kode_guru tidak ditemukan, kirimkan respons dengan pesan
        if (!$detailGuru) {
            return response()->json([
                'success' => false,
                'message' => 'Kode Guru ' . strtoupper($kodeGuru) . ' tidak ditemukan di data guru.'
            ]);
        }

        // Jika kode_guru ditemukan, lanjutkan dengan update
        $jadwalTest = JadwalTest::find($request->input('id'));

        if (!$jadwalTest) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan.'
            ]);
        }

        // Update field pada JadwalTest
        $jadwalTest->{$request->input('field')} = $request->input('value');
        if ($request->input('field') == 'detailguru_id') {
            $jadwalTest->detailguru_id = $detailGuru->id; // Ganti dengan id detailguru yang sesuai
        }

        // Simpan perubahan
        $jadwalTest->save();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // Validasi input
        // dd($request->all());

        // Hapus data dari database
        $deleted = JadwalTest::where('mapel_id', $request->mapel_id)->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'Semua jadwal berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang dihapus!');
        }
        return redirect()->back()->with('success', 'Jadwal berhasil dihapus!');
    }

    public function Resset(Request $request)
    {
        //dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();

        if ($etapels) {
            JadwalTest::where('tapel_id', $etapels->id)->delete();
        }
        Session::flash('success', 'Data Berhasil Dihapus Semua');
        return Redirect::back();
    }
}
