<?php

namespace App\Http\Controllers\Bendahara\CSR;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Bendahara\CSR\BukuKasCSR;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Bendahara\KasUmum\BendaharaKasUmum;
use App\Models\Bendahara\CSR\PemasukkanCSR;
use App\Models\Bendahara\CSR\PengeluaranCSR;

class PemasukkanCSRController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Bendahara CSR';
        $breadcrumb = 'Bendahara CSR / Pemasukkan Bendahara CSR';
        $titleviewModal = 'Lihat Bendahara CSR';
        $titleeditModal = 'Edit Bendahara CSR';
        $titlecreateModal = 'Buat Bendahara CSR';
        $arr_ths = [
            'Tahun Pelajaran',
            'Nama Perusahaan',
            'Nominal',
            'Saldo',
            'Sumber Dana',
            'Tujuan Penggunaan',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Bendahara\CSR\PemasukkanCSR::with(['Tapel'])->orderBy('created_at', 'DESC')->where('tapel_id', $etapels->id)->take(100)->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.bendahara.csr.pemasukkancsr.pemasukkan-csr', compact(
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
        $title = 'Tambah Data Bendahara CSR';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara CSR';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.bendahara.csr.pemasukkancsr.pemasukkan-csr-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {
        // Mendapatkan data Etapel yang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'petugas_id' => Auth::User()->detailguru_id,
        ]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'petugas_id'      => 'nullable|exists:users,id', // atau tabel lain tergantung relasi
            'tapel_id'        => 'nullable|exists:tapel,id', // sesuaikan dengan nama tabel tahun ajaran
            'nama_corporate'  => 'nullable|string|max:255',
            'sumber_dana'     => 'nullable|string|in:Donasi,Sponsor,Hibah',
            'bentuk_bantuan'  => 'nullable|string|in:Uang,Barang',
            'nominal'         => 'nullable|numeric|min:0|max:999999999999.99',
            'tujuan_bantuan'  => 'nullable|string|max:255',
            'keterangan'      => 'nullable|string',
            'status'          => 'required|in:pending,proses,selesai',
            'tanggal_bantuan' => 'nullable|date|before_or_equal:today',
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        \App\Models\Bendahara\CSR\PemasukkanCSR::create($validator->validated());
        $IdMax = PemasukkanCSR::max('id');

        BukuKasCSR::create([
            'tapel_id' => $request->tapel_id,
            'petugas_id' => $request->petugas_id,
            'tanggal' => $request->tanggal,
            'uraian' => 'Bantuan dari ' . $request->nama_corporate . ' digunakan untuk pelaksanaan ' . $request->tujuan_bantuan,
            'pengeluaran_id' => $IdMax,
            'penerimaan' => $request->nominal,
            'pengeluaran' => 0,
            'keterangan' => $request->keterangan,
        ]);

        BendaharaKasUmum::create([
            'tapel_id' => $request->tapel_id,
            'petugas_id' => $request->petugas_id,
            'tanggal' => $request->tanggal,
            'uraian' => 'Bantuan dari ' . $request->nama_corporate . ' digunakan untuk pelaksanaan ' . $request->tujuan_bantuan,
            'program' => $request->tanggal,
            'sumber_dana' => 'CSR',
            'pemasukkan' => $request->nominal,
            'pengeluaran' => $request->nominal,
            'pemasukkan_csr_id' => $IdMax,
            'keterangan' => $request->keterangan,
        ]);

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Bendahara CSR';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara CSR';
        $data = \App\Models\Bendahara\CSR\PemasukkanCSR::findOrFail($id);

        return view('role.bendahara.csr.pemasukkancsr.pemasukkan-csr-single', compact(
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
        $data = \App\Models\Bendahara\CSR\PemasukkanCSR::findOrFail($id);

        return view('role.bendahara.csr.pemasukkancsr.pemasukkan-csr-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Bendahara\CSR\PemasukkanCSR::findOrFail($id);

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
        $data = \App\Models\Bendahara\CSR\PemasukkanCSR::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
