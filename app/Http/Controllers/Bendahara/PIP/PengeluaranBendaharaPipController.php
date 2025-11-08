<?php

namespace App\Http\Controllers\Bendahara\PIP;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Bendahara\KeuanganRiwayatList;
use App\Models\Bendahara\PIP\DataPenerimaPip;
use App\Models\Bendahara\PIP\PemasukkanBendaharaPip;
use App\Models\Bendahara\PIP\PengeluaranBendaharaPip;
use App\Models\Bendahara\Transfer\TransferPembayaran;

class PengeluaranBendaharaPipController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Bendahara PIP';
        $breadcrumb = 'Pengeluaran Dana PIP / Bendahara PIP';
        $titleviewModal = 'Lihat Bendahara PIP';
        $titleeditModal = 'Edit Bendahara PIP';
        $titlecreateModal = 'Buat Bendahara PIP';
        $arr_ths = [
            'Tanggal',
            'Nama Siswa',
            'Nominal',
            'Tujuan',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Bendahara\PIP\PengeluaranBendaharaPip::orderBy('created_at', 'DESC')->where('tapel_id', $etapels->id)->get();
        $DataPenerimaPIP = DataPenerimaPip::get();
        // $PembayaranKomite = Pembayarank
        $PembayaranKomite = \App\Models\Bendahara\KeuanganRiwayatList::where('kategori', 'komite')->where('tapel_id', $etapels->id)->get();
        // dump($PembayaranKomite, $DataPenerimaPIP->where('detailsiswa_id', 28));
        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.bendahara.pip.pengeluaranbendaharapip.pengeluaran-bendahara-pip', compact(
            'title',
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DataPenerimaPIP',
            'PembayaranKomite',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Bendahara PIP';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara PIP';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.bendahara.pip.pengeluaranbendaharapip.pengeluaran-bendahara-pip-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {

        // dd($request->all());
        DB::beginTransaction();
        try {
            $etapels = Etapel::where('aktiv', 'Y')->first();
            $PembayaranKomite = \App\Models\Bendahara\KeuanganRiwayatList::find($request->pembayaran_id);
            $DataPemasukkan = PemasukkanBendaharaPip::where('detailsiswa_id', $request->detailsiswa_id)->sum('nominal');
            $DataKeluar = PengeluaranBendaharaPip::where('detailsiswa_id', $request->detailsiswa_id)->sum('pengeluaran');
            $CekDataSaldo = $DataPemasukkan - $DataKeluar;
            if ($CekDataSaldo <= 0) {
                throw new \Exception('Saldo tabungan PIP tidak mencukupi.');
            }

            // Lanjutkan proses jika saldo mencukupi...
            // Proses Jika Pembayaran Komite
            if ($request->jenis_pembayaran_other === null) {
                $Datasiswa = Detailsiswa::where('id', $request->detailsiswa_id)->first();
                $datas_riwayats = KeuanganRiwayatList::where('id', $request->pembayaran_id)->first();
                $nomor_pembayaran = $datas_riwayats->singkatan . $request->tingkat_id . $request->detailsiswa_id . '-' . date('Ymd');
                $Guru = Detailguru::find(Auth::user()->detailguru_id);
                $request->merge([
                    'tapel_id' => $etapels->id,
                    'semester' => $etapels->semester,
                    'kelas_id' => $Datasiswa->kelas_id,
                    'tingkat_id' => $Datasiswa->tingkat_id,
                    'petugas_id' => $Guru->id,
                    'keterangan' => 'Pembayaran melalui : ' . $Guru->nama_guru,
                    'nomor_pembayaran' => $nomor_pembayaran,
                    'sumber_dana' => 'PIP',
                    'status' => 'Pending',
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
                // Proses Jika Diluar Pembayaran Komite
            } else {
                // dd($request->all(). 'aa');
                $request->merge([
                    'tapel_id' => $etapels->id,
                    'tujuan_penggunaan' => 'Pembayaran ' . $request->jenis_pembayaran_other,
                    'tanggal_pengeluaran' => now(),
                    'keterangan' => 'Pembayaran ' . $request->jenis_pembayaran_other,
                    'detailguru_id' => Auth::User()->detailguru_id,
                    'pengeluaran' => $request->nominal,
                ]);

                // Validasi input
                $validator = Validator::make($request->all(), [
                    'tapel_id' => 'required|integer',
                    'detailsiswa_id' => 'required|integer',
                    'detailguru_id' => 'required|integer',
                    'tanggal_pengeluaran' => 'required|date',
                    'pengeluaran' => 'required|integer',
                    'tujuan_penggunaan' => 'required|string',
                    'keterangan' => 'required|string',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                    \App\Models\Bendahara\PIP\PengeluaranBendaharaPip::create($validator->validated());
                }
            }

            DB::commit();
            // Menyimpan pesan sukses di session
            Session::flash('success', 'Data berhasil disimpan');

            // Mengarahkan kembali ke halaman sebelumnya
            return Redirect::back();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Proses gagal: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Bendahara PIP';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara PIP';
        $data = \App\Models\Bendahara\PIP\PengeluaranBendaharaPip::findOrFail($id);
        return view('role.bendahara.pip.pengeluaranbendaharapip.pengeluaran-bendahara-pip-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Bendahara PIP';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara PIP / Edit';
        $data = \App\Models\Bendahara\PIP\PengeluaranBendaharaPip::findOrFail($id);

        return view('role.bendahara.pip.pengeluaranbendaharapip.pengeluaran-bendahara-pip-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Bendahara\PIP\PengeluaranBendaharaPip::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data yang ditemukan berdasarkan hasil validasi
        $data->update($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = \App\Models\Bendahara\PIP\PengeluaranBendaharaPip::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
