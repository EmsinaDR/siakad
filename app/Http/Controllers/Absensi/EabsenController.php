<?php

namespace App\Http\Controllers\Absensi;

use Exception;
use Carbon\Carbon;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Absensi\Eabsen;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\ErrorHandler\Exception\FlattenException;

class EabsenController extends Controller
{
    //Eabsen
    public function index(Request $request, Eabsen $eabsen)
    {
        $title = 'Data Absensi Siswa';
        $arr_ths = [
            'Hari dan Tanggal',
            'Jam',
            'NIS',
            'Nama',
            'Kelas',
            'Absen'
        ];

        $jumlahAbsenPerKelas = Ekelas::withCount(['siswa' => function ($query) {
            $query->whereHas('absensi', function ($q) {
                $q->whereDate('waktu_absen', now()->toDateString());
            });
        }])->get();
        $jumlahAbsenPerKelas = Eabsen::jumlahAbsenHariIni();
        $label_grafik = array_column($jumlahAbsenPerKelas->toArray(), "kelas");
        $data_grafik = array_column($jumlahAbsenPerKelas->toArray(), "jumlah_absen");
        $etapels = Cache::tags(['chace_etapels'])->remember('remember_etapels', now()->addHours(2), function () {
            return Etapel::where('aktiv', 'Y')->first();
        });
        $AbsensiHaraIni = Cache::tags(['chace_AbsensiHaraIni'])->remember('remember_AbsensiHaraIni', now()->addMinutes(2), function () {
            return Eabsen::whereDate('created_at', Carbon::today())->orderBy('waktu_absen', 'desc')->get();
        });
        $titleviewModal = 'Lihat Data Absensi Siswa';
        $titleeditModal = 'Edit Data Absensi Siswa';
        $titlecreateModal = 'Buat Data Absensi Siswa';
        $breadcrumb = 'Guru Piket / Data Absensi Siswa';


        return view('role.absensi.index', compact(
            'title',
            'arr_ths',
            'AbsensiHaraIni',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'jumlahAbsenPerKelas',
            'data_grafik',
            'label_grafik'
        ));
    }
    public function absensiSiswa(Request $request)
    {
        $title = 'Data Absensi Siswa';
        $arr_ths = [
            'No',
            'NIS',
            'Nama',
            'Kelas',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = Eabsen::orderBy('waktu_absen', 'desc')->get(); //Relasi di sisipi dengan where
        $DataAbsenHarIni = Cache::tags(['chacprosesabsen'])->remember('remember_chacprosesabsen', now()->addHours(2), function () {
            return Eabsen::whereDate('waktu_absen', Carbon::today()) // Hanya ambil data hari ini
                ->orderBy('waktu_absen', 'desc') // Urutkan dari yang terbaru
                ->get();
        });
        $breadcrumb = 'Guru Piket / Data Absensi Siswa';
        $titleviewModal = 'Lihat Data Absensi Siswa';
        $titleeditModal = 'Edit Data Absensi Siswa';
        $titlecreateModal = 'Buat Data Absensi Siswa';

        return view('role.absensi.absensi-siswa', compact(
            'title',
            'arr_ths',
            'DataAbsenHarIni',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
    }
    // scan
    public function absensiGuru(Request $request)
    {
        $title = 'Data Absensi Siswa';
        $arr_ths = [
            'No',
            'NIS',
            'Nama',
            'Kelas',
        ];
        $breadcrumb = 'Guru Piket / Data Absensi Siswa';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = Eabsen::orderBy('waktu_absen', 'desc')->get(); //Relasi di sisipi dengan where
        $AbsenGuruHariIni = Cache::tags(['cache_AbsenGuruHariIni'])->remember('remember_AbsenGuruHariIni', now()->addMinutes(2), function () {
            return Eabsen::whereDate('waktu_absen', Carbon::today()) // Hanya ambil data hari ini
                ->orderBy('waktu_absen', 'desc') // Urutkan dari yang terbaru
                ->get();
        });
        $titleviewModal = 'Lihat Data Absensi Siswa';
        $titleeditModal = 'Edit Data Absensi Siswa';
        $titlecreateModal = 'Buat Data Absensi Siswa';

        return view('role.absensi.absensi-guru', compact(
            'title',
            'arr_ths',
            'DataAbsenHarIni',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
    }

    public function storeAbsensiGuru(Request $request)
    {
        // dd('terhubung');
        // try {
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datasiswa = Detailguru::where('kode_guru', $request->datanis)->first();

        if (!$datasiswa) {
            return redirect()->back()
                ->with('Title', 'Gagal')
                ->with('gagal', 'NIS tidak ditemukan');
        }

        $jamSekarang = now();
        $jenisAbsen = $jamSekarang->format('H:i') <= '07:00' ? 'masuk' : 'pulang';

        $sudahAbsen = Eabsen::whereDate('created_at', today())
            ->where('detailsiswa_id', $datasiswa->id)
            ->where('jenis_absen', $jenisAbsen)
            ->exists();

        if ($sudahAbsen) {
            return redirect()->back()
                ->with('Title', 'Sudah Absen')
                ->with('message', "Kamu sudah absen $jenisAbsen hari ini.");
        }

        $data = [
            'detailguru_id' => $datasiswa->id,
            'tapel_id'       => $etapels->id,
            'semester'       => $etapels->semester ?? '1',
            'kelas_id'       => $datasiswa->kelas_id ?? null,
            'absen'          => 'hadir',
            'jenis_absen'    => $jenisAbsen,
            'waktu_absen'    => $jamSekarang,
            'created_at'     => $jamSekarang,
            'updated_at'     => $jamSekarang,
        ];

        Eabsen::create($data);

        // 🔔 WhatsApp Gateway kirim notifikasi
        kirimPesanAbsensi($datasiswa->id,  $data,);
        HapusCacheDenganTag('chace_AbsensiHaraIni');

        return redirect()->back()
            ->with('Title', 'Berhasil');
    }
    public function RekapAbsensicetak(Request $request)
    {
        $title = 'Data Absensi Siswa';
        $arr_ths = [
            'No',
            'NIS',
            'Nama',
            'Kelas',
        ];
        $jumlahAbsenPerKelas = Ekelas::withCount(['siswa' => function ($query) {
            $query->whereHas('absensi', function ($q) {
                $q->whereDate('waktu_absen', now()->toDateString());
            });
        }])->get();
        $jumlahAbsenPerKelas = Eabsen::jumlahAbsenHariIni();
        $label_grafik = array_column($jumlahAbsenPerKelas->toArray(), "kelas");
        $data_grafik = array_column($jumlahAbsenPerKelas->toArray(), "jumlah_absen");

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = Eabsen::orderBy('waktu_absen', 'desc')->get(); //Relasi di sisipi dengan where
        $datas = Eabsen::whereDate('waktu_absen', Carbon::today()) // Hanya ambil data hari ini
            ->orderBy('waktu_absen', 'desc') // Urutkan dari yang terbaru
            ->get();
        $breadcrumb = 'Guru Piket / Data Absensi Siswa';
        $titleviewModal = 'Lihat Data Absensi Siswa';
        $titleeditModal = 'Edit Data Absensi Siswa';
        $titlecreateModal = 'Buat Data Absensi Siswa';
        $JumlahSiswaKelas = Cache::remember(
            'jumlah_siswa_kelas',
            now()->addHours(2),
            fn() =>
            Detailsiswa::whereNotNull('kelas_id')
                ->groupBy('kelas_id')
                ->select('kelas_id', DB::raw('count(*) as total_siswa'))
                ->get()
                ->keyBy('kelas_id')
        );

        $rekapKelas = Ekelas::where('tapel_id', $etapels->id)->withCount([
            'siswa as sakit_count' => fn($q) => $q->whereHas('absensi', fn($q) => $q->whereDate('waktu_absen', today())->where('absen', 'sakit')),
            'siswa as ijin_count' => fn($q) => $q->whereHas('absensi', fn($q) => $q->whereDate('waktu_absen', today())->where('absen', 'ijin')),
            'siswa as alfa_count' => fn($q) => $q->whereHas('absensi', fn($q) => $q->whereDate('waktu_absen', today())->where('absen', 'alfa')),
            'siswa as hadir_count' => fn($q) => $q->whereHas('absensi', fn($q) => $q->whereDate('waktu_absen', today())->where('absen', 'hadir')),
        ])->get()->map(function ($kelas) use ($JumlahSiswaKelas) {
            $kelas->total_siswa = $JumlahSiswaKelas[$kelas->id]->total_siswa ?? 0;
            return $kelas;
        });


        return view('role.absensi.absensi-siswa-cetak', compact(
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'jumlahAbsenPerKelas',
            'label_grafik',
            'data_grafik',
            'rekapKelas',
        ));
    }

    // data qr absensi
    public function store(Request $request)
    {
        $jamBatasMasuk = '07:00'; // 🟢 cukup ubah ini aja kalau ada perubahan

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datasiswa = Detailsiswa::with('Detailsiswatokelas')->where('nis', $request->datanis)->first();

        if (!$datasiswa) {
            return back()->with('gagal', 'Data siswa tidak ditemukan.');
        }

        // Versi Enscripting susah untuk scan dan tidak bisa diatur panjangnya
        // try {
        //     $decrypted = Crypt::decryptString($request->datanis); // QR hasil scan
        //     [$nis, $vendor, $sekolah] = explode('|', $decrypted); // Ambil NIS-nya

        //     $datasiswa = Detailsiswa::with('Detailsiswatokelas')
        //         ->where('nis', $nis)
        //         ->first();
        // } catch (\Throwable $e) {
        //     return redirect()->back()
        //         ->with('Title', 'Gagal')
        //         ->with('gagal', 'QR tidak valid atau rusak!');
        // }

        // if (!$datasiswa) {
        //     return redirect()->back()
        //         ->with('Title', 'Gagal')
        //         ->with('gagal', 'NIS tidak ditemukan');
        // }
        // // Versi HashIds tidak bisa gabungan vendor ( murnis angka tidak bisa huruf )
        // try {
        //     $nis = hashid_decode($request->datanis); // hasil dari QR berbasis hashid

        //     $datasiswa = Detailsiswa::with('Detailsiswatokelas')
        //         ->where('nis', $nis)
        //         ->first();

        //     if (!$datasiswa) {
        //         return back()->with('gagal', 'Data siswa tidak ditemukan.');
        //     }
        // } catch (\Throwable $e) {
        //     return back()->with('Title', 'Gagal')
        //         ->with('gagal', 'QR tidak valid atau rusak!');
        // }


        $jamSekarang = now();
        $jenisAbsen = $jamSekarang->format('H:i') <= $jamBatasMasuk ? 'masuk' : 'pulang';

        $sudahAbsen = Eabsen::whereDate('created_at', today())
            ->where('detailsiswa_id', $datasiswa->id)
            ->where('jenis_absen', $jenisAbsen)
            ->exists();
        if ($sudahAbsen) {
            return redirect()->back()
                ->with('Title', 'Sudah Absen')
                ->with('message', "Kamu sudah absen $jenisAbsen hari ini.");
        }
        // 🕒 Hitung telat jika absen masuk dan lewat dari $jamBatasMasuk
        $telatMenit = 0;
        if ($jenisAbsen === 'masuk') {
            $jamBatas = Carbon::createFromTimeString($jamBatasMasuk);
            if ($jamSekarang->greaterThan($jamBatas)) {
                $telatMenit = $jamBatas->diffInMinutes($jamSekarang);
            }
        }

        $data = [
            'detailsiswa_id' => $datasiswa->id,
            'tapel_id'       => $etapels->id,
            'semester'       => $etapels->semester ?? '',
            'kelas_id'       => $datasiswa->kelas_id ?? null,
            'absen'          => 'hadir',
            'jenis_absen'    => $jenisAbsen,
            'waktu_absen'    => $jamSekarang,
            'telat'          => $telatMenit,
            'created_at'     => $jamSekarang,
            'updated_at'     => $jamSekarang,
        ];
        Eabsen::create($data);
        kirimPesanAbsensi($datasiswa->id,  $data,);
        HapusCacheDenganTag('chace_AbsensiHaraIni');
        HapusCacheDenganTag('chacprosesabsen');

        return redirect()->back()
            ->with('Title', 'Berhasil')
            ->with('message', "Absensi $jenisAbsen berhasil!");
    }
    public function IndexAjax()
    {
        // $absensi = Eabsen::with('detailsiswa')->orderByDesc('created_at')->take(20)->get();
        $absensi = Cache::tags(['cache_absensi'])->remember('remember_absensi', now()->addHours(2), function () {
            // return Eabsen::with('detailsiswa')->orderByDesc('created_at')->take(20)->get();
            return Eabsen::with('detailsiswa')->orderByDesc('created_at')->get();
        });
        HapusCacheDenganTag('cache_absensi');

        return view('role.absensi.absensi-siswa-ajax', compact('absensi'));
    }


    public function storeSiswaAjax(Request $request)
    {
        $request->validate(['nis' => 'required']);
        // $datasiswa = Detailsiswa::with('Detailsiswatokelas')->where('nis', $request->datanis)->first();
        $siswa = Detailsiswa::with('Detailsiswatokelas')->where('nis', $request->nis)->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => '❌ NIS tidak ditemukan',
            ]);
        }

        $jamSekarang     = now();
        $jamBatasMasuk   = '07:05';
        $jamBatasPulang  = '13:00'; // bisa juga ambil dari setting database
        $jenisAbsen      = $jamSekarang->format('H:i') <= $jamBatasMasuk ? 'masuk' : 'pulang';

        $sudahAbsen = Eabsen::whereDate('created_at', today())
            ->where('detailsiswa_id', $siswa->id)
            ->where('jenis_absen', $jenisAbsen)
            ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'error' => false,
                'message' => "⚠️ Sudah absen $jenisAbsen hari ini!",
            ]);
        }

        $telatMenit = 0;
        $pulangCepat = 0;
        $pulangTelat = 0;

        if ($jenisAbsen === 'masuk') {
            $jamBatas = Carbon::createFromTimeString($jamBatasMasuk);
            if ($jamSekarang->greaterThan($jamBatas)) {
                $telatMenit = $jamBatas->diffInMinutes($jamSekarang);
            }
        } else {
            $jamBatas = Carbon::createFromTimeString($jamBatasPulang);
            if ($jamSekarang->lessThan($jamBatas)) {
                $pulangCepat = $jamSekarang->diffInMinutes($jamBatas);
            } elseif ($jamSekarang->greaterThan($jamBatas)) {
                $pulangTelat = $jamBatas->diffInMinutes($jamSekarang);
            }
        }

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $data = [
            'telat' => $telatMenit ?? '0',
            'waktu' => $jenisAbsen === 'masuk' ? 'Pagi' : 'Siang',
        ];
        $absen = Eabsen::create([
            'detailsiswa_id' => $siswa->id,
            'tapel_id'       => $etapels->id ?? null,
            'semester'       => $etapels->semester ?? null,
            'kelas_id'       => $siswa->kelas_id ?? null,
            'absen'          => 'hadir',
            'jenis_absen'    => $jenisAbsen,
            'waktu_absen'    => $jamSekarang,
            'telat'          => $telatMenit,
            // 'pulang_cepat'   => $pulangCepat,
            // 'pulang_telat'   => $pulangTelat,
        ]);
        kirimPesanAbsensi($siswa->id, $data);
        HapusCacheDenganTag('chace_AbsensiHaraIni');
        HapusCacheDenganTag('chacprosesabsen');
        return response()->json([
            'success' => true,
            'message' => "✅ Absen $jenisAbsen berhasil!",
            'data' => [
                'nis' => $siswa->nis,
                'nama' => $siswa->nama_siswa,
                'waktu' => $absen->waktu_absen->format('H:i:s'),
                'jenis' => $jenisAbsen,
                'telat' => $telatMenit ? "$telatMenit menit" : 'Tepat waktu',
                'pulang_cepat' => $pulangCepat ? "$pulangCepat menit" : null,
                'pulang_telat' => $pulangTelat ? "$pulangTelat menit" : null,
            ],
        ]);
    }

    public function storeGuruAjax(Request $request)
    {
        $request->validate(['nis' => 'required']);
        // $datasiswa = Detailsiswa::with('Detailsiswatokelas')->where('nis', $request->datanis)->first();
        $siswa = Detailsiswa::with('Detailsiswatokelas')->where('nis', $request->nis)->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => '❌ NIS tidak ditemukan',
            ]);
        }

        $jamSekarang     = now();
        $jamBatasMasuk   = '07:05';
        $jamBatasPulang  = '13:00'; // bisa juga ambil dari setting database
        $jenisAbsen      = $jamSekarang->format('H:i') <= $jamBatasMasuk ? 'masuk' : 'pulang';

        $sudahAbsen = Eabsen::whereDate('created_at', today())
            ->where('detailsiswa_id', $siswa->id)
            ->where('jenis_absen', $jenisAbsen)
            ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'error' => false,
                'message' => "⚠️ Sudah absen $jenisAbsen hari ini!",
            ]);
        }

        $telatMenit = 0;
        $pulangCepat = 0;
        $pulangTelat = 0;

        if ($jenisAbsen === 'masuk') {
            $jamBatas = Carbon::createFromTimeString($jamBatasMasuk);
            if ($jamSekarang->greaterThan($jamBatas)) {
                $telatMenit = $jamBatas->diffInMinutes($jamSekarang);
            }
        } else {
            $jamBatas = Carbon::createFromTimeString($jamBatasPulang);
            if ($jamSekarang->lessThan($jamBatas)) {
                $pulangCepat = $jamSekarang->diffInMinutes($jamBatas);
            } elseif ($jamSekarang->greaterThan($jamBatas)) {
                $pulangTelat = $jamBatas->diffInMinutes($jamSekarang);
            }
        }

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $data = [
            'telat' => $telatMenit ?? '0',
            'waktu' => $jenisAbsen === 'masuk' ? 'Pagi' : 'Siang',
        ];
        $absen = Eabsen::create([
            'detailsiswa_id' => $siswa->id,
            'tapel_id'       => $etapels->id ?? null,
            'semester'       => $etapels->semester ?? null,
            'kelas_id'       => $siswa->kelas_id ?? null,
            'absen'          => 'hadir',
            'jenis_absen'    => $jenisAbsen,
            'waktu_absen'    => $jamSekarang,
            'telat'          => $telatMenit,
            // 'pulang_cepat'   => $pulangCepat,
            // 'pulang_telat'   => $pulangTelat,
        ]);
        kirimPesanAbsensi($siswa->id, $data);
        HapusCacheDenganTag('chace_AbsensiHaraIni');
        HapusCacheDenganTag('chacprosesabsen');
        return response()->json([
            'success' => true,
            'message' => "✅ Absen $jenisAbsen berhasil!",
            'data' => [
                'nis' => $siswa->nis,
                'nama' => $siswa->nama_siswa,
                'waktu' => $absen->waktu_absen->format('H:i:s'),
                'jenis' => $jenisAbsen,
                'telat' => $telatMenit ? "$telatMenit menit" : 'Tepat waktu',
                'pulang_cepat' => $pulangCepat ? "$pulangCepat menit" : null,
                'pulang_telat' => $pulangTelat ? "$pulangTelat menit" : null,
            ],
        ]);
    }





    public function AbsenManual(Request $request)
    {
        // dd($request->all());
        try {
            $etapels = Etapel::where('aktiv', 'Y')->first();
            $datasiswa = Detailsiswa::whereIn('id', $request->detailsiswa_id)->get();
            // dd($request->all(), $datasiswa);

            foreach ($request->detailsiswa_id as $Idsiswa) {
                $CekAbsensi = Eabsen::whereDate('created_at', Carbon::today())->where('detailsiswa_id', $Idsiswa)->count();
                if ($CekAbsensi === 0) {
                    $data = new Eabsen();
                    $data->detailsiswa_id = $Idsiswa;
                    $data->tapel_id = $etapels->id;
                    $data->semester = $etapels->id; // Yakin semester = tapel_id? Harusnya beda
                    $data->kelas_id = $Idsiswa->kelas_id ?? null; // Perbaiki bagian ini sesuai struktur
                    $data->absen = $request->absen;
                    $data->waktu_absen = now();
                    $data->created_at = now();
                    $data->updated_at = now();
                    $data->save();
                }
            }
            HapusCacheDenganTag('chace_AbsensiHaraIni');
            return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data disimpan dalam database');
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        //Proses Modal Update
        $data = Eabsen::findOrFail($id);
        // dd($data, $request->all());
        $data = $request->except(['_token', '_method']);
        $data = Eabsen::findOrFail($id);
        $data->absen = $request->absen;
        $data->updated_at =  now();
        $data->update();
        HapusCacheDenganTag('chace_AbsensiHaraIni');
        return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  berhasil diperbaharui');
    }


    public function destroy($id)
    {
        //Proses Modal Delete
        //Form Modal Delete ada di index
        //Detailguru
        // dd(id);
        // dd(request->all());
        $data = Eabsen::findOrFail($id);
        $data->delete();
        HapusCacheDenganTag('chace_AbsensiHaraIni');

        return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
    }
    // DOMPDF
    public function RiwayatAbsenGlobalSiswa(Request $request)
    {
        $title = 'Data Rekap Absensi Siswa';
        $arr_ths = [
            'Hari, Tanggal',
            'Jam',
            'Absensi',
        ];

        $Tapel = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Guru Piket / Data Absensi Siswa';
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $SiswaTujuan = Detailsiswa::with('KelasOne')->find($request->detailsiswa_id);

        $DataSiswa = Eabsen::whereBetween('waktu_absen', [$tanggal_awal, $tanggal_akhir])
            ->where('detailsiswa_id', $request->detailsiswa_id)
            ->where('tapel_id', $Tapel->id)
            ->with('EabsentoDetailsiswa')
            ->get();

        $Grouped = $DataSiswa->groupBy(function ($item) {
            return Carbon::parse($item->waktu_absen)->format('Y-m');
        });

        $RekapBulanan = $Grouped->map(function ($items, $bulan) {
            $sakit = $items->filter(fn($i) => strtolower($i->absen) === 'sakit')->count();
            $ijin  = $items->filter(fn($i) => in_array(strtolower($i->absen), ['izin', 'ijin']))->count();
            $alpa  = $items->filter(fn($i) => in_array(strtolower($i->absen), ['alfa', 'alpa', 'alpha']))->count();
            $hadir = $items->filter(fn($i) => strtolower($i->absen) === 'hadir')->count();

            return [
                'bulan'  => $bulan,
                'sakit'  => $sakit,
                'ijin'   => $ijin,
                'alpa'   => $alpa,
                'hadir'  => $hadir,
                'jumlah_total' => $sakit + $ijin + $alpa + $hadir,
            ];
        })->values();

        // PDF Generation
        $pdf = Pdf::loadView('role.absensi.rekap-absensi-siswa', compact(
            'title',
            'arr_ths',
            'breadcrumb',
            'DataSiswa',
            'SiswaTujuan',
            'tanggal_awal',
            'tanggal_akhir',
            'RekapBulanan',
            'SiswaTujuan',
        ))
            ->setPaper('A4', 'portrait') // atau landscape kalau tabel panjang
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true, // jika butuh load gambar/logo dari public
            ]);

        return $pdf->stream('Rekap_Absensi_' . $SiswaTujuan->nama . '.pdf');
    }
}
