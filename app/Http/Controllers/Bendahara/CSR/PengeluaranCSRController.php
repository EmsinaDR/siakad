<?php

namespace App\Http\Controllers\Bendahara\CSR;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Bendahara\CSR\BukuKasCSR;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Bendahara\KasUmum\BendaharaKasUmum;
use App\Models\Bendahara\CSR\PemasukkanCSR;
use App\Models\Bendahara\CSR\PengeluaranCSR;

class PengeluaranCSRController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Pengeluaran Bendahara CSR';
        $breadcrumb = 'Bendahara CSR / Pengeluaran Bendahara CSR';
        $titleviewModal = 'Lihat Bendahara CSR';
        $titleeditModal = 'Edit Bendahara CSR';
        $titlecreateModal = 'Buat Bendahara CSR';
        $arr_ths = [
            'Tanggal',
            'Dana Csr',
            'Pengeluaran',
            'Tujuan Pengeluaran',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Bendahara\CSR\PengeluaranCSR::with(['DanaCsr', 'Guru', 'Tapel'])->where('tapel_id', $etapels->id)->orderBy('created_at', 'DESC')->take(100)->get();
        $DanaPemasukkans = PemasukkanCSR::where('nominal', '>', 0)->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.bendahara.csr.pengeluarancsr.pengeluaran-csr', compact(
            'title',
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DanaPemasukkans',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Bendahara CSR';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara CSR';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.bendahara.csr.pengeluarancsr.pengeluaran-csr-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            // Cek saldo dan validasi tetap dilakukan di luar transaksi
            $pemasukkanCsr = PemasukkanCSR::find($request->sumber_dana);
            $totalPengeluaran = PengeluaranCSR::where('csr_id', $request->sumber_dana)->sum('nominal');
            $saldo = $pemasukkanCsr->nominal - ($totalPengeluaran + $request->nominal);

            if ($saldo < 0) {
                Session::flash('error', 'Anggaran tidak mencukupi untuk diproses. Total penggunaan lebih ' . $saldo);
                return Redirect::back();
            }

            $etapels = Etapel::where('aktiv', 'Y')->first();
            $request->merge([
                'tapel_id' => $etapels->id,
                'jenis_pengeluaran' => $pemasukkanCsr->tujuan_bantuan,
                'petugas_id' => Auth::user()->detailguru_id,
                'csr_id' => $request->sumber_dana,
            ]);

            $validator = Validator::make($request->all(), [
                'tapel_id' => 'required|integer',
                'csr_id' => 'required|integer',
                'petugas_id' => 'required|integer',
                'tanggal' => 'required|date',
                'jenis_pengeluaran' => 'required|string',
                'nominal' => 'required|numeric',
                'keterangan' => 'string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Simpan data dalam transaksi
            $validatedData = $validator->validated();
            $pengeluaran = PengeluaranCSR::create($validatedData);
            $IdMax = $pengeluaran->id;

            BukuKasCSR::create([
                'tapel_id' => $request->tapel_id,
                'petugas_id' => $request->petugas_id,
                'tanggal' => $request->tanggal,
                'uraian' => 'Bantuan dari ' . $pemasukkanCsr->nama_corporate . ' digunakan untuk pelaksanaan ' . $pemasukkanCsr->tujuan_bantuan,
                'pengeluaran_id' => $IdMax,
                'penerimaan' => 0,
                'pengeluaran' => $request->nominal,
                'keterangan' => $request->keterangan,
            ]);

            BendaharaKasUmum::create([
                'tapel_id' => $request->tapel_id,
                'petugas_id' => $request->petugas_id,
                'tanggal' => $request->tanggal,
                'uraian' => 'Bantuan dari ' . $pemasukkanCsr->nama_corporate . ' digunakan untuk pelaksanaan ' . $pemasukkanCsr->tujuan_bantuan,
                'program' => $request->tanggal,
                'sumber_dana' => 'CSR',
                'pengeluaran' => $request->nominal,
                'pengeluaran_csr_id' => $IdMax,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();
            Session::flash('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }

        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Bendahara CSR';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara CSR';
        $data = \App\Models\Bendahara\CSR\PengeluaranCSR::findOrFail($id);

        return view('role.bendahara.csr.pengeluarancsr.pengeluaran-csr-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Bendahara CSR';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara CSR / Edit';
        $data = \App\Models\Bendahara\CSR\PengeluaranCSR::findOrFail($id);

        return view('role.bendahara.csr.pengeluarancsr.pengeluaran-csr-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Bendahara\CSR\PengeluaranCSR::findOrFail($id);

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
        $data = \App\Models\Bendahara\CSR\PengeluaranCSR::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
