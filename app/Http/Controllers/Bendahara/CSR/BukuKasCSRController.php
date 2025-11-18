<?php

namespace App\Http\Controllers\Bendahara\CSR;

use App\Models\Bendahara\CSR\BukuKasCSR;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use App\Models\Bendahara\CSR\PemasukkanCSR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class BukuKasCSRController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Bendahara CSR';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara CSR';
        $titleviewModal = 'Lihat Bendahara CSR';
        $titleeditModal = 'Edit Bendahara CSR';
        $titlecreateModal = 'Buat Bendahara CSR';
        $arr_ths = [
            'Tanggal',
            'Sumber Dana',
            'Pemasukkan',
            'Pengeluaran',
            'Keterangan',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Bendahara\CSR\BukuKasCSR::with(['Tapel', 'DanaPengeluaran'])->orderBy('created_at', 'DESC')->where('tapel_id', $etapels->id)->get();
        $datas = \App\Models\Bendahara\CSR\BukuKasCSR::with(['Tapel', 'DanaPengeluaran'])
            ->orderBy('created_at', 'DESC')
            ->where('tapel_id', $etapels->id)
            ->where(function ($query) {
                $query->where('penerimaan', '>', 0)
                    ->orWhere('pengeluaran', '>', 0);
            })
            ->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.bendahara.csr.bukukascsr.buku-kas-csr', compact(
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

        return view('role.bendahara.csr.bukukascsr.buku-kas-csr-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {
        // Mendapatkan data Etapel yang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge(['tapel_id' => $etapels->id]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        \App\Models\Bendahara\CSR\BukuKasCSR::create($validator->validated());

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
        $data = \App\Models\Bendahara\CSR\BukuKasCSR::findOrFail($id);

        return view('role.bendahara.csr.bukukascsr.buku-kas-csr-single', compact(
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
        $data = \App\Models\Bendahara\CSR\BukuKasCSR::findOrFail($id);

        return view('role.bendahara.csr.bukukascsr.buku-kas-csr-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Bendahara\CSR\BukuKasCSR::findOrFail($id);

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
        $data = \App\Models\Bendahara\CSR\BukuKasCSR::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
