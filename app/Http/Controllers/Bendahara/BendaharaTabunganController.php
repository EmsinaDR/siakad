<?php

namespace App\Http\Controllers\Bendahara;

use Carbon\Carbon;
use Mpdf\Mpdf;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Laravel\Reverb\Loggers\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Bendahara\BendaharaTabungan;

class BendaharaTabunganController extends Controller
{
    //
    public function index(BendaharaTabungan $BendaharaTabungan)
    {
        $title = 'Data Bendahara Komite';
        $arr_ths = [
            'Nama Siswa',
            'No Pembayaran',
            'Kelas',
            'Itim',
            'Nominal',
            'Waktu',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = BendaharaTabungan::with('BendaharaTabungantoSiswa')->where('id', 'id')->take(100)->get(); //Relasi di sisipi dengan where
        $breadcrumb = 'Bendahara / Daftar Ulang';
        $titleviewModal = 'Lihat Daftar Ulang';
        $titleeditModal = 'Edit Daftar Ulang';
        $titlecreateModal = 'Buat Daftar Ulang';

        return view('role.bendahara.tabungan.index', compact(
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
    }


    public function store(Request $request)
    {
        //Proses Modal Create
        //Form Modal Create ada di index dengan Modal
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $kelas = Ekelas::where('kelas', $request->kelas)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'kelas_id' => $kelas->id,
            'tingkat_id' => $kelas->tingkat_id,
            'petugas_id' => Auth::useR()->id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'tapel_id' => 'required|numeric',
            'detailsiswa_id' => 'required|numeric',
            'tingkat_id' => 'required|numeric',
            'kelas_id' => 'required|numeric',
            'petugas_id' => 'required|numeric',
            'nominal' => 'required|numeric',
            'keterangan' => 'required|string|max:255',
            'type' => 'in:pemasukkan,pengeluaran',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        BendaharaTabungan::create($validator->validated());
        // dd($request->all());
        return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data disimpan dalam database');
    }
    public function update($id, Request $request)
    {
        //Proses Modal Update
        //Form Modal Update ada di index dengan Modal
        //dd($request->all());
        $data = $request->except(['_token', '_method']);
        $data = BendaharaTabungan::findOrFail($id);
        $data->kelas_id = $request->kelas_id;
        $data->updated_at =  now();
        $data->update();
        return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  berhasil diperbaharui');
    }


    public function destroy($id)
    {
        //Proses Modal Delete
        //Form Modal Delete ada di index
        //Detailguru
        // dd(id);
        // dd(request->all());
        $data = BendaharaTabungan::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
    }
    public function TabunganSiswa()
    {
        //dd($request->all());
        //Title to Controller
        $title = 'Tabungan Siswa';
        $arr_ths = [
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Nominal'
        ];
        $breadcrumb = 'Bendahara / Tabungan Siswa';
        $titleviewModal = 'Lihat Data Tabungan Siswa';
        $titleeditModal = 'Edit Data Tabungan Siswa';
        $titlecreateModal = 'Create Data Tabungan Siswa';
        $datasiswas = Detailsiswa::get();
        $datas = BendaharaTabungan::orderBy('created_at', 'DESC')->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.bendahara.tabungan.tabungan', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'datasiswas'
        ));
    }
    public function DataTabungan()
    {
        //dd($request->all());
        $title = 'Data Tabungan Siswa';
        $arr_ths = [
            'NIS',
            'Nama Siswa',
            'Kelas'
        ];
        $breadcrumb = 'Bendahara / Data Tabungan Siswa';
        $titleviewModal = 'Lihat Data Tabungan Siswa';
        $titleeditModal = 'Edit Data Tabungan Siswa';
        $titlecreateModal = 'Create Data Tabungan Siswa';
        $datasiswas = Detailsiswa::orderBy('kelas_id', 'ASC')->orderBy('nama_siswa', 'ASC')->get();
        $datas = BendaharaTabungan::get();
        $tabuangan_vii = BendaharaTabungan::select('type', 'nominal')->where('tingkat_id', 7)->get();
        $tabuangan_viii = BendaharaTabungan::select('type', 'nominal')->where('tingkat_id', 8)->get();
        $tabuangan_ix = BendaharaTabungan::select('type', 'nominal')->where('tingkat_id', 9)->get();

        // Menghitung total pemasukan dan pengeluaran
        $kelas_vii_in = $tabuangan_vii->where('type', 'pemasukkan')->sum('nominal');
        $kelas_viii_in = $tabuangan_viii->where('type', 'pemasukkan')->sum('nominal');
        $kelas_ix_in = $tabuangan_ix->where('type', 'pemasukkan')->sum('nominal');

        $kelas_vii_out = $tabuangan_vii->where('type', 'pengeluaran')->sum('nominal');
        $kelas_viii_out = $tabuangan_viii->where('type', 'pengeluaran')->sum('nominal');
        $kelas_ix_out = $tabuangan_ix->where('type', 'pengeluaran')->sum('nominal');
        // dd($kelas_viii_out);

        // $tabuangan_vii = BendaharaTabungan::selectRaw('type, SUM(nominal) as total_nominal')
        // ->where('tingkat_id', 9)
        // ->groupBy('type')
        // ->get();
        // dd($tabuangan_vii->nominal);


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.bendahara.tabungan.data-tabungan', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'datasiswas',
            'tabuangan_vii',
            'tabuangan_viii',
            'tabuangan_ix',
            'kelas_vii_in',
            'kelas_viii_in',
            'kelas_ix_in',
            'kelas_vii_out',
            'kelas_viii_out',
            'kelas_ix_out'
        ));
    }
    public function LaporanTabungan(Request $request)
    {
        //dd($request->all());
        //Title to Controller
        $title = 'Laporan Tabungan';
        $arr_ths = [
            'No',
            'Nama',
            'title_tabelac',
            'title_tabelad'
        ];
        $breadcrumb = 'Bendahara / Tabungan / Laporan';
        $titleviewModal = 'Lihat Data Laporan Tabungan';
        $titleeditModal = 'Edit Data Laporan Tabungan';
        $titlecreateModal = 'Create Data Laporan Tabungan';
        $datas = BendaharaTabungan::get();
        $dataSiswas = Detailsiswa::get();

        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.bendahara.tabungan.laporan', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal', 'dataSiswas'));
    }
    public function LaporanBulananTabungan(Request $request)
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
        $datas = BendaharaTabungan::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->get();

        // Data Tabungan Tiap Angkatan
        $tabuangan_vii = BendaharaTabungan::select('type', 'nominal')->where('tingkat_id', 7)->get();
        $tabuangan_viii = BendaharaTabungan::select('type', 'nominal')->where('tingkat_id', 8)->get();
        $tabuangan_ix = BendaharaTabungan::select('type', 'nominal')->where('tingkat_id', 9)->get();

        // Menghitung total pemasukan dan pengeluaran
        $kelas_vii_in = $tabuangan_vii->where('type', 'pemasukkan')->sum('nominal');
        $kelas_viii_in = $tabuangan_viii->where('type', 'pemasukkan')->sum('nominal');
        $kelas_ix_in = $tabuangan_ix->where('type', 'pemasukkan')->sum('nominal');

        $kelas_vii_out = $tabuangan_vii->where('type', 'pengeluaran')->sum('nominal');
        $kelas_viii_out = $tabuangan_viii->where('type', 'pengeluaran')->sum('nominal');
        $kelas_ix_out = $tabuangan_ix->where('type', 'pengeluaran')->sum('nominal');
        // Cek jika data kosong
        if ($datas->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        try {
            // Inisialisasi Mpdf
            $mpdf = new Mpdf();

            // Mendefinisikan HTML untuk PDF
            $html = "

            <style>
                .text-center {
                    text-align: center;
                }
                    .bg-green{
                    background-color:#b1dfbb;
                }
            </style>
                    <h2 style='text-align:center'>Cetak Dokumen</h2>
                    <div class='title'>Laporan Tabungan Siswa</div>
                    <div><strong>Periode:</strong> {$tanggalAwal->format('d M Y')} - {$tanggalAkhir->format('d M Y')}</div>
                    Total Tabungan Kelas VII : {$kelas_vii_in} - {$kelas_vii_out} <br>
                    Total Tabungan Kelas VIII : {$kelas_viii_in} <br>
                    Total Tabungan Kelas IX : {$kelas_ix_in} <br>
                    <table id='example1' border='1' cellspacing='0' cellpading='2' width='100%' class='table table-bordered table-hover'>
                        <thead>
                            <tr class='bg-green'>
                                <th>No</th>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>";

            // Menambahkan variabel untuk nomor urut
            $no = 1;

            // Loop untuk menampilkan data
            foreach ($datas as $data) {
                $html .= "
                        <tr>
                            <td class='text-center'>{$no}</td> <!-- Menampilkan nomor urut -->
                            <td class='text-center'>{$data->id}</td> <!-- ID data -->
                            <td class='text-center'>{$data->BendaharaTabunganToDetailsiswa->nama_siswa}</td> <!-- Nama siswa -->
                            <td class='text-center'>{$data->created_at->format('d M Y')}</td> <!-- Tanggal -->
                            <td class='text-center'>Rp. " . number_format($data->nominal, 2) . "</td> <!-- Jumlah dalam format uang -->
                        </tr>";

                // Increment nomor urut setelah setiap baris
                $no++;
            }

            $html .= "
                        </tbody>
                    </table>";

            // Menulis HTML ke PDF
            $mpdf->WriteHTML($html);

            // Output PDF ke browser
            return $mpdf->Output('Laporan_Bulanan_Keuangan.pdf', 'I');
        } catch (\Mpdf\MpdfException $e) {
            // Jika terjadi kesalahan dalam pembuatan PDF
            return response()->json(['error' => 'Terjadi kesalahan saat membuat PDF: ' . $e->getMessage()], 500);
        }
    }
    // public function LaporanBulananTabunganajax(Request $request)
    public function LaporanBulananTabunganajax(Request $request)
    {
        \Carbon\Carbon::setLocale('id');
        $tanggalAwal = Carbon::parse($request->tanggal_awal)->startOfDay();  // Memastikan mulai dari jam 00:00
        $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();  // Memastikan sampai jam 23:59

        // Ambil data sesuai filter tanggal
        $data = DB::table('keuangan_tabungan')
            ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->select('type', 'nominal', 'created_at')
            ->orderBy('created_at', 'DESC')->get()
            ->map(function ($item) {
                // Format tanggal menggunakan Carbon
                $item->created_at = Carbon::parse($item->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm');
                return $item;
            });

        // Hitung total pemasukan dan pengeluaran
        $totalPemasukan = $data->where('type', 'pemasukkan')->sum('nominal');
        $totalPengeluaran = $data->where('type', 'pengeluaran')->sum('nominal');

        // Mengembalikan data dan periode yang dikirimkan
        $result = [
            'data' => $data,
            'summary' => [
                'total_pemasukan' => $totalPemasukan,
                'total_pengeluaran' => $totalPengeluaran,
            ],
            'periode' => [
                'tanggal_awal' => $request->tanggal_awal,
                'tanggal_akhir' => $request->tanggal_akhir
            ]
        ];

        return response()->json($result);
    }

    public function LaporanBulananTabunganSiswaajax(Request $request)
    {
        \Carbon\Carbon::setLocale('id');
        $tanggalAwal = Carbon::parse($request->tanggal_awal)->startOfDay();  // Memastikan mulai dari jam 00:00
        $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();  // Memastikan sampai jam 23:59

        // Ambil data sesuai filter tanggal dan siswa
        $data = DB::table('keuangan_tabungan')
            ->where('detailsiswa_id', $request->detailsiswa_id)
            ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->select('type', 'nominal', 'created_at')
            ->orderBy('cretead_at', 'DESC')->get()
            ->map(function ($item) {
                // Format tanggal menggunakan Carbon
                $item->created_at = Carbon::parse($item->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm'); // Gunakan locale('id')
                return $item;
            });

        // Hitung total pemasukan dan pengeluaran
        $totalPemasukan = $data->where('type', 'pemasukkan')->sum('nominal');
        $totalPengeluaran = $data->where('type', 'pengeluaran')->sum('nominal');

        // Mengembalikan data dan periode yang dikirimkan
        $result = [
            'data' => $data,
            'summary' => [
                'total_pemasukan' => $totalPemasukan,
                'total_pengeluaran' => $totalPengeluaran,
            ],
            'periode' => [
                'tanggal_awal' => $request->tanggal_awal,
                'tanggal_akhir' => $request->tanggal_akhir
            ]
        ];

        return response()->json($result);
    }
}
