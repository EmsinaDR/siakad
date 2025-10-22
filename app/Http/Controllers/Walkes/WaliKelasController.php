<?php

namespace App\Http\Controllers\Walkes;

use Mpdf\Mpdf;
use Carbon\Carbon;
use App\Models\Admin\Emapel;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Absensi\Eabsen;
use App\Models\Learning\Enilai;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Learning\EnilaiTugas;
use App\Models\Learning\EnilaiPtsPas;
use Illuminate\Support\Facades\Cache;
use App\Models\Learning\EnilaiUlangan;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\Learning\Jurnalmengajar;

class WaliKelasController extends Controller
{
    //
    public function index()
    {
        return 'index';
    }
    public function printDataJadwalPiket()
    {
        // Ambil data dari database
        $data = Detailsiswa::where('kelas_id', '2')->get();

        // Load HTML dari view Blade
        // $html = view('print.data_jadwal_piket', compact('data'))->render();

        // Buat instance mPDF
        $mpdf = new Mpdf();
        $html = '<H2>Cetak Dokumen</H2>';
        foreach ($data as $datanama):
            $html .= $datanama->nama_siswa . ' -> ' . $datanama->DetailsiswaToKelas->kelas . '<br>';
        endforeach;

        $mpdf->WriteHTML($html);
        return response($mpdf->Output("contoh.pdf", "D"))->header('Content-Type', 'application/pdf');
    }
    //Menu Wali Kelas Berkaitan Dengan DetailSiswa
    public function Walkes_DataSiswa(Request $request)
    {
        //Title to Controller
        $title = 'Data Siswa';
        $arr_ths = [
            'NIS',
            'NISN',
            'Nama',
            'Desa',
            'Kecamatan',
            'RT / RT',
            'Alamat'
        ];
        $breadcrumb = 'Wali Kelas / Data Siswa';
        $titleviewModal = 'Lihat Data Siswa';
        $titleeditModal = 'Edit Data Siswa';
        $titlecreateModal = 'Create Data Siswa';

        $DataSiswa = Cache::tags(['chace_DataSiswa'])->remember('remember_DataSiswa', now()->addHours(2), function () use ($request) {
            return Detailsiswa::where('kelas_id', $request->kelas_id)->get();
        });
        // dd($datas);

        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        // return 'walkes data siswa';
        return view('role.walkes.data-siswa', compact('DataSiswa', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
    public function Walkes_Datajurnal(Request $request)
    {
        //Title to Controller
        $title = 'Jurnal Kelas';
        $arr_ths = [
            'Hari dan Tanggal',
            'Indikator',
            'Jam Ke',
            'Guru',
            'Kejadian Khusus',
            'Absensi',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Wali Kelas / Jurnal Kelas';
        $titleviewModal = 'Lihat Data Jurnal Kelas';
        $titleeditModal = 'Edit Data Jurnal Kelas';
        $titlecreateModal = 'Create Data Jurnal Kelas';
        $datas = Jurnalmengajar::where('kelas_id', $request->kelas_id)->where('tapel_id',  $etapels->id)->get();
        // return 'Jurnal Kelas';
        return view('role.walkes.data-jurnal', compact('title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal', 'datas'));
    }
    public function Walkes_DataBK(Request $reques)
    {
        //Title to Controller
        $title = 'Data BK';
        $arr_ths = [
            'Nama',
            'Pelanggaran',
            'Kredit Point',
            'Penyelesaian',
            'Proses',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Wali Kelas / Data BK';
        $titleviewModal = 'Lihat Data BK';
        $titleeditModal = 'Edit Data BK';
        $titlecreateModal = 'Create Data BK';


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'

        return view('role.walkes.data-bk', compact('title', 'arr_ths', 'etapels',  'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
    public function Walkes_Datanilai(Request $request)
    {
        //Title to Controller
        $title = 'Data Nilai';
        $arr_ths = [
            'Nama',
            'NIS',
            'title_tabelac',
            'title_tabelad'
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Wali Kelas / Data Nilai';
        $titleviewModal = 'Lihat Data Nilai';
        $titleeditModal = 'Edit Data Nilai';
        $titlecreateModal = 'Create Data Nilai';
        $datas = Enilai::where('kelas_id', $request->kelas_id)->where('taple_id',  $etapels->tapel_id)->get();

        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.walkes.data-nilai', compact('title', 'arr_ths', 'etapels',  'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
    public function Walkes_Datainventaris(Request $request)
    {
        //Title to Controller
        $title = 'Data Inventaris Kelas';
        $arr_ths = [
            'Kode Barang',
            'Nama Barang',
            'Tanggal Masuk',
            ''
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Wali Kelas / Data Inventaris Kelas';
        $titleviewModal = 'Lihat Data Inventaris Kelas';
        $titleeditModal = 'Edit Data Inventaris Kelas';
        $titlecreateModal = 'Create Data Inventaris Kelas';
        $datas = Enilai::where('kelas_id', $request->kelas_id)->where('taple_id',  $etapels->tapel_id)->get();
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.walkes.data-inventaris', compact('title', 'arr_ths', 'etapels',  'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
    public function DataPetugasUpacara(Request $request)
    {
        //Title to Controller
        $title = 'Petugas Upacara';
        $arr_ths = [
            'NIS',
            'Nama',
            'Petugas',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Menu_breadcume / sub_Menu_breadcume';
        $titleviewModal = 'Lihat Petugas Upacara';
        $titleeditModal = 'Edit Petugas Upacara';
        $titlecreateModal = 'Create Petugas Upacara';


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.walkes.data-petugas-upacara', compact('title', 'arr_ths', 'etapels',  'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
    public function Walkes_DataPetugaspiket(Request $request)
    {
        //Title to Controller
        $title = 'Petugas Piket';
        $arr_ths = [
            'NIS',
            'Nama',
            'Hari',

        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Wali Kelas / Petugas Piket';
        $titleviewModal = 'Lihat Petugas Piket';
        $titleeditModal = 'Edit Petugas Piket';
        $titlecreateModal = 'Create Petugas Piket';
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.walkes.data-petugas-piket', compact('title', 'arr_ths', 'etapels',  'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
    public function Walkes_DataStrukturKelas(Request $request)
    {
        //Title to Controller
        $title = 'Data Struktur Kelas';
        $arr_ths = [
            'NIS',
            'Nama',
            'Jabatan Kelas',
            'Jadwal Piket Kelas',
            'Petuga Upacara'
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Data Wali Kelas / Data Strutur Kelas';
        $titleviewModal = 'Lihat Data Struktur Kelas';
        $titleeditModal = 'Edit Data Struktur Kelas';
        $titlecreateModal = 'Create Data Struktur Kelas';
        $datas = Detailsiswa::where('kelas_id', $request->kelas_id)->get();
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'

        return view('role.walkes.data-struktur-kelas', compact('datas', 'title', 'arr_ths', 'etapels',  'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
    public function Walkes_DataAbsensi(Request $request)
    {
        //dd($request->all());
        //Title to Controller
        $title = 'Data Absensi';
        $arr_ths = [
            'NIS',
            'Nama',
            'Waktu Absen',
            'Jam',
            'Absen',
        ];
        $breadcrumb = 'Data Wali Kelas / Absensi';
        $titleviewModal = 'Lihat Data Absensi';
        $titleeditModal = 'Edit Data Absensi';
        $titlecreateModal = 'Create Data Absensi';

        $datas = DB::table('detailsiswas')
            ->leftJoin('eabsens_siswa', function ($join) {
                $join->on('detailsiswas.id', '=', 'eabsens_siswa.user_id')
                    // ->where('eabsens.absen', '=', 'hadir'); // Filter hanya yang absen
                    // ->whereDate('eabsens.waktu_absen', now()->toDateString());
                    ->whereDate('eabsens_siswa.waktu_absen', '=', date('Y-m-d')); // Hanya absen hari ini
            })
            ->where('detailsiswas.kelas_id', $request->kelas_id) // Ambil hanya kelas A
            // ->leftJoin('Ekelas', 'Ekelas.id', '=', 'detailsiswas.kelas_id')
            ->select('detailsiswas.id', 'detailsiswas.nis', 'detailsiswas.nama_siswa', 'detailsiswas.kelas_id', 'eabsens_siswa.absen', 'eabsens_siswa.waktu_absen', 'eabsens_siswa.waktu_absen')
            // ->select('detailsiswas.id', 'detailsiswas.nis', 'detailsiswas.nama_siswa', 'detailsiswas.kelas_id', 'eabsens.absen', 'eabsens.waktu_absen', 'Ekelas.kelas', 'eabsens.waktu_absen')
            ->get();
        // dd($datas);
        $id_absen = Eabsen::select('id')->whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get()->toArray(); //Relasi di sisipi dengan where
        $id_absen = array_column($id_absen, 'id');
        return view('role.walkes.data-absensi', compact('datas', 'id_absen', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
    public function Walkes_DataRekapAbsensi(Request $request)
    {
        $title = 'Data Rekap Absensi';
        $arr_ths = ['NIS', 'Nama'];
        $breadcrumb = 'Wali Kelas / Data Rekap Absensi';
        $titleviewModal = 'Lihat Data Rekap Absensi';
        $titleeditModal = 'Edit Data Rekap Absensi';
        $titlecreateModal = 'Create Data Rekap Absensi';

        // Ambil tahun & semester aktif dari tapel()
        $tapel = tapel();
        $tahun = $tapel['tapel'];
        $semester = $tapel['semester'];

        // Ambil kelas_id dari URL (segment ke-4)
        $kelas_id = $request->segment(2);

        // Tentukan bulan berdasarkan semester aktif
        $bulanArray = $semester === 'I'
            ? [7, 8, 9, 10, 11, 12]  // Semester 1
            : [1, 2, 3, 4, 5, 6];    // Semester 2

        // 🔍 Ambil semua siswa di kelas tersebut
        $siswa_ids = Detailsiswa::where('kelas_id', $kelas_id)->pluck('id');

        // 🔍 Ambil semua data absensi dari siswa-siswa tersebut
        $datas = Eabsen::whereYear('waktu_absen', $tahun)
            ->whereIn('detailsiswa_id', $siswa_ids)
            // ->where('jenis_absen', 'masuk')
            ->get()
            ->groupBy('detailsiswa_id')
            ->map(function ($absen) use ($tahun, $bulanArray) {
                $data = ['detailsiswa_id' => $absen->first()->detailsiswa_id];

                foreach ($bulanArray as $bulan) {
                    $firstDay = Carbon::create($tahun, $bulan, 1)->startOfMonth();
                    $lastDay = Carbon::create($tahun, $bulan, 1)->endOfMonth();
                    $bulanName = Carbon::parse($firstDay)->format('M');

                    $data['H_' . $bulanName] = $absen->whereBetween('waktu_absen', [$firstDay, $lastDay])
                        ->where('absen', 'hadir')->count();
                    $data['S_' . $bulanName] = $absen->whereBetween('waktu_absen', [$firstDay, $lastDay])
                        ->where('absen', 'sakit')->count();
                    $data['I_' . $bulanName] = $absen->whereBetween('waktu_absen', [$firstDay, $lastDay])
                        ->where('absen', 'ijin')->count();
                    $data['A_' . $bulanName] = $absen->whereBetween('waktu_absen', [$firstDay, $lastDay])
                        ->where('absen', 'alfa')->count();
                }

                return $data;
            })
            // 🔤 Urutkan berdasarkan nama siswa (dari relasi Detailsiswa)
            ->sortBy(function ($item) {
                return optional(Detailsiswa::find($item['detailsiswa_id']))->nama_siswa;
            })
            ->values();
        // dd($request->segments());

        return view('role.walkes.data-rekap-absensi', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'bulanArray'
        ));
    }

    // Wali Kelas Data Nilai
    public function Walkes_Datanilai_tugas(Request $request)
    {
        //Title to Controller
        $title = 'Data Nilai Tugas';
        $arr_ths = [
            'NIS',
            'Nama',
            // 'title_tabelac',
            // 'title_tabelad'
        ];
        $breadcrumb = 'Wali Kelas / Data Nilai Tugas';
        $titleviewModal = 'Lihat Data Nilai Tugas';
        $titleeditModal = 'Edit Data Nilai Tugas';
        $titlecreateModal = 'Create Data Nilai Tugas';
        $mapels = Emapel::get();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // dd($request->mapel_id);
        $datas = EnilaiTugas::where('mapel_id', $request->mapel_id)->where('kelas_id', $request->kelas_id)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->get();
        // dd($datas);
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.walkes.data-nilai-tugas-siswa', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal', 'mapels'));
    }
    public function Walkes_Datanilai_ulangan(Request $request)
    {
        //dd($request->all());

        //Title to Controller
        $title = 'Data Nilai Ulangan';
        $arr_ths = [
            'Nis',
            'Nama',
            // 'title_tabelac',
            // 'title_tabelad'
        ];
        $breadcrumb = 'Wali Kelas / Data Nilai';
        $titleviewModal = 'Lihat Data Nilai Ulangan';
        $titleeditModal = 'Edit Data Nilai Ulangan';
        $titlecreateModal = 'Create Data Nilai Ulangan';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // $mapels = Emapel::get();
        // $datas = EnilaiUlangan::where('kelas_id', $request->kelas_id)
        //     ->where('tapel_id', $etapels->id)
        //     ->where('semester', $etapels->semester)
        //     ->where('mapel_id', $request->mapel_id)
        //     ->where('tingkat_id', $request->tingkat_id)
        //     ->get();

        $mapels = Emapel::get();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // dd($request->mapel_id);
        $datas = EnilaiUlangan::where('mapel_id', $request->mapel_id)->where('kelas_id', $request->kelas_id)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->get();
        // dd($datas);
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.walkes.data-nilai-ulangan-siswa', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal', 'mapels', 'etapels'));
    }
    public function Walkes_Datanilai_pts_pas(Request $request)
    {
        //dd($request->all());

        //Title to Controller
        $title = 'Data Nilai PTS dan PAS';
        $arr_ths = [
            'NIS',
            'Nama',
            // 'title_tabelac',
            // 'title_tabelad'
        ];
        $breadcrumb = 'Wali Kelas / Data Nilai PTS dan PAS';
        $titleviewModal = 'Lihat Data Nilai PTS dan PAS';
        $titleeditModal = 'Edit Data Nilai PTS dan PAS';
        $titlecreateModal = 'Create Data Nilai PTS dan PAS';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = EnilaiPtsPas::where('kelas_id', $request->kelas_id)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.walkes.data-nilai-pts-pas-siswa', compact('title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
}
