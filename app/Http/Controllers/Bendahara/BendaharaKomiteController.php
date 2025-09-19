<?php

namespace App\Http\Controllers\Bendahara;

use Mpdf\Mpdf;
use Carbon\Carbon;
// use Barryvdh\DomPDF\Facade as PDF;
use App\Models\User;
use App\Models\Whatsapp\WhatsApp;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Absensi\Eabsen;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Bendahara\KasUmum\BendaharaKasUmum;
use Illuminate\Support\Facades\Auth;
use App\Models\Bendahara\KeuanganList;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\Bendahara\BukukasKomite;
use Illuminate\Support\Facades\Redirect;
use App\Models\Bendahara\BendaharaKomite;
use Illuminate\Support\Facades\Validator;
use App\Models\Laboratorium\Elaboratorium;
use App\Models\Bendahara\KeuanganRiwayatList;

class BendaharaKomiteController extends Controller
{
    //
    //
    public function index(BendaharaKomite $BendaharaKomite)
    {
        $title = 'Bendahara Komite';
        $arr_ths = [
            'Nama Siswa',
            'No Pembayaran',
            'Kelas',
            'Itim',
            'Nominal',
            'Waktu',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $jumlah_siswa = User::where('posisi', 'Siswa')->count();
        $jumlah_alumni = Detailsiswa::whereNotNull('tahun_lulus')->get()->count();
        $jumlah_guru = User::where('posisi', 'Guru')->count();
        $jumlah_karyawan = User::where('posisi', 'Karyawan')->count();
        $emapels = Emapel::where('aktiv', 'Y')->count();
        $jumlah_kelas = Ekelas::where('tapel_id', $etapels->id)->get()->count();
        $jumlah_laboratorium = \App\Models\Laboratorium\Elaboratorium::where('tapel_id', $etapels->id)->where('aktiv', 'Y')->get()->count();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$datas = BendaharaKomite::with('BendaharaKomitetoSiswa')->where('id', 'id')->get(); //Relasi di sisipi dengan where
        $breadcrumb = 'Bendahara / Bendahara Komite';
        $titleviewModal = 'Lihat Data';
        $titleeditModal = 'Edit Data';
        $titlecreateModal = 'Buat Data';


        $datapemasukkan_kelas = BendaharaKomite::where('tapel_id', $etapels->id)->orderBy('kelas_d', 'asc')->groupBy('kelas_id')->take(100)->get();
        $datapemasukkan_kelass = Ekelas::where('tapel_id', $etapels->id)->orderBy('kelas_d', 'asc')->take(100)->get();
        return view('role.bendahara.komite.index', compact(
            // 'info',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'datapemasukkan_kelas',
            'datapemasukkan_kelass',
        ));
    }
    public function TunggakanSiswa()
    {
        //Title to Controller
        $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
        // dd($routeName); // Output: 'absensi.data'
        $title = 'Tunggakan Siswa';
        $arr_ths = [
            'Jenis Pembayaran',
            'Nominal',
            'Terbayar',
            'Sisa'
        ];
        $breadcrumb = 'Bendahara / Tunggakan Siswa';
        $titleviewModal = 'Lihat Data Tunggakan Siswa';
        $titleeditModal = 'Edit Data Tunggakan Siswa';
        $titlecreateModal = 'Create Data Tunggakan Siswa';

        $data_siswa = Detailsiswa::orderBy('kelas_id', 'ASC')->orderBy('nama_siswa', 'ASC')->get();
        $datax =
            DB::table('detailsiswas as ds')
            ->leftJoin('keuangan_komite as kk', 'ds.id', '=', 'kk.detailsiswa_id')  // Gabung ke keuangan_komite berdasarkan detailsiswa_id
            ->leftJoin('keuangan_riwayat_lists as krl', 'kk.pembayaran_id', '=', 'krl.jenis_pembayaran')  // Gabung ke keuangan_riwayat_lists berdasarkan jenis_pembayaran
            ->select(
                'ds.nama_siswa as siswa',  // Pastikan ada kolom nama di tabel detailsiswas
                'ds.kelas_id',
                'krl.jenis_pembayaran',
                DB::raw('SUM(krl.nominal) as total_tagihan'),  // Total tagihan berdasarkan keuangan_riwayat_lists
                DB::raw('COALESCE(SUM(kk.nominal), 0) as total_terbayar')  // Total terbayar dari keuangan_komite
            )
            ->orderBy('ds.kelas_id', 'ASC')
            ->groupBy('ds.id', 'ds.nama_siswa', 'ds.kelas_id', 'krl.jenis_pembayaran')  // Grouping berdasarkan siswa dan jenis pembayaran
            ->get();

        return view('role.bendahara.komite.tunggakan', compact(
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'data_siswa',
            'datax'
        ));
    }

    public function store(Request $request)
    {
        // Proses Modal Create
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $kelas = Ekelas::where('kelas', $request->kelas)
            ->where('tapel_id', $etapels->id)
            ->where('semester', $etapels->semester)
            ->first();
        $data_siswa = Detailsiswa::find($request->detailsiswa_id);

        $datas_riwayats = KeuanganRiwayatList::where('id', $request->pembayaran_id)->first();
        $nomor_pembayaran = $datas_riwayats->singkatan . $request->tingkat_id . $request->detailsiswa_id . '-' . date('Ymd');
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
            'kelas_id' => $kelas->id,
            'tingkat_id' => $kelas->tingkat_id,
            'petugas_id' => Auth::user()->detailguru_id,
            'nomor_pembayaran' => $nomor_pembayaran,
        ]);

        $validator = Validator::make($request->all(), [
            'tapel_id' => 'required|numeric',
            'semester' => 'required|string|max:255',
            'pembayaran_id' => 'required|numeric',
            'detailsiswa_id' => 'required|numeric',
            'kelas_id' => 'required|numeric',
            'tingkat_id' => 'required|numeric',
            'petugas_id' => 'required|numeric',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string|max:255',
            'nomor_pembayaran' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            BendaharaKomite::create($validator->validated());
            $DataPembayaran = KeuanganRiwayatList::where('id',  $request->pembayaran_id)->first();
            $idTerakhir = BendaharaKomite::max('id');

            BukukasKomite::create([
                'tanggal' => now()->toDateString(),
                'uraian' => 'Pembayaran Siswa: ' . $data_siswa->nama_siswa,
                'petugas_id' => Auth::user()->detailguru_id,
                'program' => 'Pembayaran Komite',
                'pemasukkan_id' => $idTerakhir,
                'penerimaan' => $request->nominal,
                'pengeluaran' => 0,
                'keterangan' => 'Pembayaran ' . $DataPembayaran->jenis_pembayaran . ' dari Siswa Melalui Bendahara: ' . Auth::user()->name,
                'tapel_id' => $etapels->id,
            ]);

            BendaharaKasUmum::create([
                'tanggal' => now()->toDateString(),
                'uraian' => 'Pembayaran ' . $DataPembayaran->jenis_pembayaran . ' dari Siswa Melalui Bendahara: ' . Auth::user()->name,
                'sumber_dana' => 'Komite',
                'penerimaan' => $request->nominal,
                'pemasukkan_komite_id' => $idTerakhir,
            ]);

            if ($request->has('kirim_wa')) {
                if (!WhatsApp::isServerActive()) {
                    return redirect()->back()->withErrors(['Server WhatsApp WebJS tidak aktif.']);
                }

                $validNumbers = [];

                if (!empty($data_siswa->nohp_ayah)) {
                    $validNumbers[] = $data_siswa->nohp_ayah;
                }

                if (!empty($data_siswa->nohp_ibu)) {
                    $validNumbers[] = $data_siswa->nohp_ibu;
                }

                if (!empty($data_siswa->nohp_wali)) {
                    $validNumbers[] = $data_siswa->nohp_wali;
                }

                $formattedDate = Carbon::now()->translatedFormat('l, d F Y - H:i');
                $message =
                    "\n" .
                    "💳 *INFORMASI PEMBAYARAN*\n" .
                    "==================================\n\n" .
                    "👤 *Nama Siswa\t\t\t\t:* $data_siswa->nama_siswa\n" .
                    "🛍️ *Pembayaran\t\t\t\t:* $nomor_pembayaran\n" .
                    "💰 *Total Tagihan\t\t\t:* Rp " . number_format($request->nominal, 0, ',', '.') . "\n" .
                    "⏳ *Batas Waktu*\t\t\t\t: $formattedDate\n" .
                    "\n" . str_repeat("─", 25) . "\n" .
                    "✍️ *Ditandatangani oleh:*\n" .
                    "xxxxxxxxxx";

                foreach ($validNumbers as $nohp) {
                    $nohp_cleaned = preg_replace('/^0/', '62', $nohp);
                    WhatsApp::sendMessage(config('whatsappSession.IdWaUtama'), $nohp_cleaned, $message);
                }
            }

            DB::commit();
            return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data disimpan dalam database');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function update($id, Request $request)
    {
        //Proses Modal Update
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'jenis_pembayaran' => 'required|string|max:255',
            'nominal' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Menyimpan data menggunakan mass assignment
        $varmodel = BendaharaKomite::find($id); // Pastikan $id didefinisikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($validator->validated());
            // Update Kas Komite
            $kasKomite = BukukasKomite::where('pemasukkan_id', $id)->update([
                'penerimaan' => $request->nominal,
            ]);
            // Update Kas Umum
            $kasUmum = BendaharaKasUmum::where('pemasukkan_komite_id', $id)->where('sumber_dana', 'Komite')->update([
                'penerimaan' => $request->nominal,
            ]);

            return Redirect::back()->with('Title', 'Berhasil')->with('success', 'Data Berhasil di Update');
        } else {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Data tidak ditemukan');
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Hapus dari KomitePengeluaran
            $pemasukkan = BendaharaKomite::find($id);
            if ($pemasukkan) {
                $pemasukkan->delete();
            }

            // Hapus dari BendaharaKasUmum jika ada
            $kasUmum = BendaharaKasUmum::where('pemasukkan_komite_id', $id)
                ->where('sumber_dana', 'Komite')
                ->first();
            if ($kasUmum) {
                $kasUmum->delete();
            }

            // Hapus dari BukuKasKomite jika ada
            $bukuKas = BukukasKomite::where('pemasukkan_id', $id)->first();
            if ($bukuKas) {
                $bukuKas->delete();
            }

            DB::commit();

            return redirect()->back()
                ->with('Title', 'Berhasil !!!')
                ->with('success', 'Data berhasil dihapus dari database');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('Title', 'Gagal !!!')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
    public function InputKomite(Request $request)
    {
        //Title to Controller
        $title = 'Data Komite';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad'
        ];
        $breadcrumb = 'Bendahara / Bendahara Komite';
        $titleviewModal = 'Lihat Data Komite';
        $titleeditModal = 'Edit Data Komite';
        $titlecreateModal = 'Create Data Komite';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $datas = BendaharaKomite::with(['BendaharaKomiteToDetailsiswa', 'BendaharaKomiteToEtapel', 'BendaharaKomiteToKelas', 'KeuanganRiwayat'])
            ->where('tapel_id', $etapels->id)->orderBy('created_at', 'DESC')->take(50)
            ->get();
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.bendahara.komite.input', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //dd($request->all());
        // return view('role.bendahara.komite.input', compact('variabel_satu', 'ariabel_dua'));
    }
    public function ListDana(Request $request)
    {
        //Title to Controller
        $title = 'List Data Komite';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad'
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Bendahara / List Bendahara Komite';
        $titleviewModal = 'Lihat List Data Komite';
        $titleeditModal = 'Edit List Data Komite';
        $titlecreateModal = 'Create List Data Komite';
        $datas = BendaharaKomite::get();
        $datas = KeuanganList::where('kategori', 'komite')->get();
        $datas_riwayats = KeuanganRiwayatList::where('tapel_id', $etapels->id)
            ->where('kategori', 'komite')
            ->orderBy('tingkat_id')
            ->get();

        $totals = KeuanganRiwayatList::where('tapel_id', $etapels->id)
            ->where('kategori', 'komite')
            ->whereIn('tingkat_id', [7, 8, 9])
            ->select('tingkat_id', DB::raw('SUM(nominal) as total_nominal'))
            ->groupBy('tingkat_id')
            ->pluck('total_nominal', 'tingkat_id');

        // Mengakses total untuk setiap tingkat
        $total_tingkat_a = $totals->get(7, 0);
        $total_tingkat_b = $totals->get(8, 0);
        $total_tingkat_c = $totals->get(9, 0);
        return view('role.bendahara.komite.list-dana', compact('datas', 'datas_riwayats', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal', 'total_tingkat_a', 'total_tingkat_b', 'total_tingkat_c'));
    }
    public function PengaturanKomite(Request $request)
    {
        // Url : http://127.0.0.1:8000/bendahara/pengaturan-komite
        //Title to Controller
        $title = 'Pengaturan Data Komite';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad'
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Bendahara / Pengaturan Bendahara Komite';
        $titleviewModal = 'Lihat List Data Komite';
        $titleeditModal = 'Edit List Data Komite';
        $titlecreateModal = 'Create List Data Komite';
        $datas = BendaharaKomite::get();
        $datas = KeuanganList::where('kategori', 'komite')->get();
        $datas_riwayats = KeuanganRiwayatList::where('tapel_id', $etapels->id)
            ->where('semester', $etapels->semester)
            ->where('kategori', 'komite')
            ->orderBy('tingkat_id')
            ->get();

        $totals = KeuanganRiwayatList::where('tapel_id', $etapels->id)
            ->where('kategori', 'komite')
            ->whereIn('tingkat_id', [7, 8, 9])
            ->select('tingkat_id', DB::raw('SUM(nominal) as total_nominal'))
            ->groupBy('tingkat_id')
            ->pluck('total_nominal', 'tingkat_id');

        // Mengakses total untuk setiap tingkat
        $total_tingkat_a = $totals->get(7, 0);
        $total_tingkat_b = $totals->get(8, 0);
        $total_tingkat_c = $totals->get(9, 0);

        return view('role.bendahara.komite.pengaturan-komite', compact('datas', 'datas_riwayats', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal', 'total_tingkat_a', 'total_tingkat_b', 'total_tingkat_c'));
    }
    public function CopyKomite()
    {
        // Menggandakan data pembayaran pada semester I ke Semester II pada tahun pelajaran sama
        // Url : http://127.0.0.1:8000/bendahara/pengaturan-komite
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas_riwayats = KeuanganRiwayatList::where('tapel_id', $etapels->id - 1)->where('semester', 'I')->where('kategori', 'komite')->get();
        // Proses Menggandakan data pembayaran pada semester I ke Semester II pada tahun pelajaran sama
        $data = $datas_riwayats->map(function ($datas_riwayats) {
            $etapels = Etapel::where('aktiv', 'Y')->first();
            return [
                'petugas_id' => $datas_riwayats->petugas_id,
                'tapel_id' => $etapels->id,
                'semester' => 'II',
                'tingkat_id' => $datas_riwayats->tingkat_id,
                'singkatan' => $datas_riwayats->singkatan,
                'kategori' => $datas_riwayats->kategori,
                'jenis_pembayaran' => $datas_riwayats->jenis_pembayaran,
                'nominal' => $datas_riwayats->nominal,
                'keterangan' => $datas_riwayats->keterangan,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();
        KeuanganRiwayatList::insert($data);
        return Redirect::back()->with('Title', 'Berhasil !!')->with('Success', 'Data telah selesai di gandakan untuk semester II');
    }
    public function ResetKomite()
    {
        // Menghapus data pembayaran pada semester I ke Semester II pada tahun pelajaran sama
        // Url : http://127.0.0.1:8000/bendahara/pengaturan-komite
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas_riwayats = KeuanganRiwayatList::select('id')->where('tapel_id', $etapels->id)->where('semester', 'II')->where('kategori', 'komite')->get()->toArray();
        // Proses Menggandakan data pembayaran pada semester I ke Semester II pada tahun pelajaran sama
        $idcollection = array_column($datas_riwayats, 'id');
        foreach ($idcollection as $datadelete):
            // dd($datadelete);
            $data = KeuanganRiwayatList::findOrFail($datadelete);
            $data->delete();
        endforeach;
        // KeuanganRiwayatList::delete();
        return Redirect::back()->with('Title', 'Berhasil !!')->with('Success', 'Data telah selesai di kosongkan untuk semester II');
    }
    public function PembayaranTunggakanKomite(Request $request)
    {
        // dd($request->all());
        // body_method
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $kelas = Ekelas::where('kelas', $request->kelas)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->first();

        // dd($kelas);
        $singkatan = KeuanganRiwayatList::where('jenis_pembayaran', $request->jenis_pembayaran)->where('tingkat_id', $request->tingkat_id)->first();
        // dd($singkatan);
        $request->merge([
            'kelas_id' => $kelas->id,
            'tingkat_id' => $kelas->tingkat_id,
            'petugas_id' => Auth::user()->detailguru_id,
            'nomor_pembayaran' => $singkatan->singkatan . '' . date('Ymd'),
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'tapel_id' => 'required|numeric',
            'semester' => 'required|string|max:255',
            'pembayaran_id' => 'required|string|max:255',
            'detailsiswa_id' => 'required',
            'kelas_id' => 'required|numeric|min:0|max:100',
            'tingkat_id' => 'required|numeric|min:0|max:100',
            'petugas_id' => 'required|numeric|min:0|max:100',
            'nominal' => 'required|numeric',
            'keterangan' => 'string|max:255',
            'nomor_pembayaran' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        BendaharaKomite::create($validator->validated());
        $DataPembayaran = KeuanganRiwayatList::where('id',  $request->pembayaran_id)->first();

        $data_siswa = Detailsiswa::find($request->detailsiswa_id);
        $idTerakhir = BendaharaKomite::max('id');
        // Inpute ke Buku Kas Komite
        // Simpan juga ke buku kas komite
        BukukasKomite::create([
            'tanggal' => now()->toDateString(),
            'uraian' => 'Pembayaran Tunggakan Siswa: ' . $request->nama_siswa,
            'petugas_id' => Auth::user()->detailguru_id,
            'program' => 'Pembayaran Komite',
            'pemasukkan_id' => $idTerakhir,
            'penerimaan' => $request->nominal,
            'pengeluaran' => 0,
            'keterangan' => 'Pembayaran ' . $request->jenis_pembayaran . ' dari Siswa Melalui Bendahara: ' . Auth::user()->name,
            'tapel_id' => $etapels->id,
        ]);
        // Pemasukkan
        BendaharaKasUmum::create([
            'tanggal' => now()->toDateString(),
            'uraian' => 'Pembayaran Tunggakan ' . $request->jenis_pembayaran . ' dari Siswa Melalui Bendahara: ' . Auth::user()->name,
            'sumber_dana' => 'Komite',
            'penerimaan' => $request->nominal,
            'pemasukkan_komite_id' => $idTerakhir,
        ]);
        //Scipt kirim ke whatsaapp
        return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data disimpan dalam database');
    }
    //dokuem
    public function dokuemn()
    {
        //dd($request->all());
        // body_method
    }
    public function LaporanBulananKomite(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal_awal' => 'required|date',   // Pastikan tanggal_awal valid
            'tanggal_akhir' => 'required|date',  // Pastikan tanggal_akhir valid
        ]);

        // Convert tanggal_awal dan tanggal_akhir ke objek Carbon
        $tanggalAwal = Carbon::parse($request->tanggal_awal)->startOfDay();  // Memastikan mulai dari jam 00:00
        $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();  // Memastikan sampai jam 23:59

        // Ambil data berdasarkan rentang tanggal
        $datas = BendaharaKomite::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->get();

        // Cek jika data kosong
        if ($datas->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);  // Bisa mengembalikan pesan error atau response
        }

        $mpdf = new Mpdf();

        $html = '<H2>Cetak Dokumen</H2>
        ';

        $mpdf->WriteHTML($html);
        return response($mpdf->Output("contoh.pdf", "D"))->header('Content-Type', 'application/pdf');
        // return $pdf->download('Laporan_Bulanan_Komite.pdf');

    }
}
