<?php

namespace App\Http\Controllers\Bendahara\Transfer;

use App\Models\User;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\Bendahara\BukukasKomite;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Bendahara\BendaharaKomite;
use Illuminate\Support\Facades\Validator;
use App\Models\Bendahara\BendaharaKasUmum;
use App\Models\Bendahara\BendaharaTabungan;
use App\Models\Bendahara\KeuanganRiwayatList;
use App\Models\Bendahara\PIP\DataPenerimaPip;
use App\Models\Bendahara\PIP\PemasukkanBendaharaPip;
use App\Models\Bendahara\PIP\PengeluaranBendaharaPip;
use App\Models\Bendahara\Transfer\TransferPembayaran;

class TransferPembayaranController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Bendahara Transfer';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara Transfer';
        $titleviewModal = 'Lihat Bendahara Transfer';
        $titleeditModal = 'Edit Bendahara Transfer';
        $titlecreateModal = 'Buat Bendahara Transfer';
        $arr_ths = [
            'Jenis Pembayaran',
            'Nama Siswa',
            'Nominal',
            'Status',
            'Keterangan',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $etapels = \App\Models\Admin\Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Bendahara\Transfer\TransferPembayaran::orderBy('created_at', 'DESC')->where('tapel_id', $etapels->id)->get();
        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.bendahara.transfer.transferpembayaran.transfer-pembayaran', compact(
            'title',
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Bendahara Transfer';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara Transfer';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.bendahara.transfer.transferpembayaran.transfer-pembayaran-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {

        // Mendapatkan data Etapel yang aktif
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $kelas = Ekelas::where('kelas', $request->kelas)
            ->where('tapel_id', $etapels->id)
            ->where('semester', $etapels->semester)
            ->first();
        // Ambil data siswa dan nomor telepon
        // $data_siswa = Detailsiswa::find(Auth::user()->detailguru_id);
        $Guru = Detailguru::find(Auth::user()->detailguru_id);

        $datas_riwayats = KeuanganRiwayatList::where('id', $request->pembayaran_id)->first();
        // dd($datas_riwayats);
        $nomor_pembayaran = $datas_riwayats->singkatan . $request->tingkat_id . $request->detailsiswa_id . '-' . date('Ymd');
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
            'kelas_id' => $kelas->id,
            'tingkat_id' => $kelas->tingkat_id,
            'petugas_id' => Auth::user()->detailguru_id,
            'nomor_pembayaran' => $nomor_pembayaran,
            'status' => 'Pending',
            'keterangan' => 'Pembayaran melalui : ' . $Guru->nama_guru,
        ]);
        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
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
            'status' => 'required|string',
            'sumber_dana' => 'required|string',
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // Membuat entri baru berdasarkan validasi
        \App\Models\Bendahara\Transfer\TransferPembayaran::create($validator->validated());
        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Bendahara Transfer';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara Transfer';
        $data = \App\Models\Bendahara\Transfer\TransferPembayaran::findOrFail($id);

        return view('role.bendahara.transfer.transferpembayaran.transfer-pembayaran-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Bendahara Transfer';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara Transfer / Edit';
        $data = \App\Models\Bendahara\Transfer\TransferPembayaran::findOrFail($id);

        return view('role.bendahara.transfer.transferpembayaran.transfer-pembayaran-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // dd($request->all());
            // Menemukan data yang akan diupdate berdasarkan ID
            $data = \App\Models\Bendahara\Transfer\TransferPembayaran::findOrFail($id);
            $perantara = Detailguru::where('id', $data->petugas_id)->first();
            $NePetugas = Detailguru::where('id', Auth::user()->detailguru_id)->first();

            $request->merge([
                'keterangan' => $request->status === 'Success'
                    ? 'Telah diterima dari ' . $perantara->nama_guru . ' ke ' . $NePetugas->nama_guru
                    : 'Masih dalam menunggu proses perubahan data',
                'petugas_id' => Auth::user()->detailguru_id,
            ]);

            // Kirim Ke Pemasukkan Komite
            $DataTransfer = TransferPembayaran::find($id);
            $DataPembayaran = KeuanganRiwayatList::where('id',  $DataTransfer->pembayaran_id)->first();

            // dd($DataPenerimaPIP);
            // Kirim data Pengeluaran antara tabungan dan PIP
            // dd($DataTransfer, $DataPembayaran, $DataTransfer->sumber_dana);
            if ($DataTransfer->sumber_dana === 'Tabungan') {

                $DataTabungan = BendaharaTabungan::where('detailsiswa_id', $DataTransfer->detailsiswa_id)->get();
                $DataTabunganMasuk = $DataTabungan->where('type', 'pemasukkan')->sum('nominal');
                $DataTabunganKeluar = $DataTabungan->where('type', 'pengeluaran')->sum('nominal');
                $SaldoTabungan = $DataTabunganMasuk - $DataTabunganKeluar;
                // dd($DataTabunganMasuk, $DataTabunganKeluar, $SaldoTabungan);
                if ($SaldoTabungan >= $DataTransfer->nominal) {
                    BendaharaTabungan::create(
                        [
                            'tapel_id' => $DataTransfer->tapel_id,
                            'kelas_id' => $DataTransfer->kelas_id,
                            'tingkat_id' => $DataTransfer->tingkat_id,
                            'petugas_id' => $DataTransfer->petugas_id,
                            'detailsiswa_id' => $DataTransfer->detailsiswa_id,
                            'nominal' => $DataTransfer->nominal,
                            'keterangan' => 'Digunakan untuk pembayaran ' .  $DataPembayaran->jenis_pembayaran,
                            'type' => 'pengeluaran',

                        ]
                    );
                } else {
                    throw new \Exception('Saldo tabungan tidak mencukupi.');
                }
            } elseif ($DataTransfer->sumber_dana === 'PIP') {
                $DataPenerimaPIP = DataPenerimaPip::where('detailsiswa_id', $DataTransfer->detailsiswa_id)->first();
                if (!$DataPenerimaPIP) {
                    throw new \Exception('Siswa bukan penerima PIP.');
                } else {
                    // Cek Saldo
                    $SaldoPemasukkan = PemasukkanBendaharaPip::where('detailsiswa_id', $DataTransfer->detailsiswa_id)->sum('nominal');
                    $Pengeluaran = \App\Models\Bendahara\PIP\PengeluaranBendaharaPip::where('detailsiswa_id', $DataTransfer->detailsiswa_id)->sum('pengeluaran');

                    if ($SaldoPemasukkan >= $Pengeluaran) {
                        \App\Models\Bendahara\PIP\PengeluaranBendaharaPip::create(
                            [
                                'tapel_id' => $DataTransfer->tapel_id,
                                'detailsiswa_id' => $DataTransfer->detailsiswa_id,
                                'detailguru_id' => $DataTransfer->petugas_id,
                                'tanggal_pengeluaran' => $DataTransfer->created_at,
                                'pengeluaran' => $DataTransfer->nominal,
                                'is_transfer' => 1,
                                'tujuan_penggunaan' => 'Digunakan untuk pembayaran ' .  $DataPembayaran->jenis_pembayaran,
                                'keterangan' => 'required|string',
                            ]
                        );
                    } else {
                        throw new \Exception('Saldo tabungan tidak mencukupi.');
                    }
                }
            } else {
            }

            // Validasi input
            $validator = Validator::make($request->all(), [
                // Tambahkan validasi sesuai kebutuhan
                'status' => 'required|String',
                'keterangan' => 'required|String'
            ]);

            // Jika validasi gagal, kembalikan dengan pesan error
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Update data yang ditemukan berdasarkan hasil validasi
            $data->update($validator->validated());
            // dd($request->all(), $id, $DataTransfer, 'Pembayaran ' . $DataPembayaran->jenis_pembayaran . ' dari Siswa Melalui Bendahara: ' . Auth::user()->name);
            $SaveBendaharaKomite = BendaharaKomite::create(
                [
                    'tapel_id' => $DataTransfer->tapel_id,
                    'semester' => $DataTransfer->semester,
                    'pembayaran_id' => $DataTransfer->pembayaran_id,
                    'detailsiswa_id' => $DataTransfer->detailsiswa_id,
                    'kelas_id' => $DataTransfer->kelas_id,
                    'tingkat_id' => $DataTransfer->tingkat_id,
                    'petugas_id' => $DataTransfer->petugas_id,
                    'nominal' => $DataTransfer->nominal,
                    'keterangan' => 'Pembayaran ' . $DataPembayaran->jenis_pembayaran . ' dari Siswa Melalui Bendahara: ' . Auth::user()->name,
                    'nomor_pembayaran' => $DataTransfer->nomor_pembayaran,
                ]
            );
            // dd($SaveBendaharaKomite);
            // dd($DataPembayaran);
            $data_siswa = Detailsiswa::find($DataTransfer->detailsiswa_id);
            $idTerakhir = BendaharaKomite::max('id');
            // Inpute ke Buku Kas Komite
            // Simpan juga ke buku kas komite
            BukukasKomite::create([
                'tanggal' => now()->toDateString(),
                'uraian' => 'Pembayaran ' . $DataPembayaran->jenis_pembayaran . ' Siswa: ' . $data_siswa->nama_siswa,
                'petugas_id' => Auth::user()->detailguru_id,
                'program' => 'Pembayaran Komite',
                'pemasukkan_id' => $idTerakhir,
                'penerimaan' => $DataTransfer->nominal,
                'pengeluaran' => 0,
                'keterangan' => 'Pembayaran ' . $DataPembayaran->jenis_pembayaran . ' dari Siswa Melalui Bendahara: ' . Auth::user()->name . ' Dari Program transfer',
                'tapel_id' => $DataTransfer->tapel_id,
            ]);
            // Pemasukkan
            BendaharaKasUmum::create([
                'tanggal' => now()->toDateString(),
                'uraian' => 'Pembayaran ' . $DataPembayaran->jenis_pembayaran . ' dari Siswa bernama ' . $data_siswa->nama_siswa . ' Melalui Bendahara: ' . Auth::user()->name,
                'sumber_dana' => 'Komite',
                'penerimaan' => $DataTransfer->nominal,
                'pemasukkan_komite_id' => $idTerakhir,
            ]);

            DB::commit();
            // Menyimpan pesan sukses di session
            Session::flash('success', 'Data berhasil diperbarui');

            // // Mengarahkan kembali ke halaman sebelumnya
            return Redirect::back();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Proses gagal: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = \App\Models\Bendahara\Transfer\TransferPembayaran::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
