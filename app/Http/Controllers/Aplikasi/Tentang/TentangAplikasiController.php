<?php

namespace App\Http\Controllers\Aplikasi\Tentang;

use App\Models\Aplikasi\Tentang\TentangAplikasi;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class TentangAplikasiController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Aplikasi Tentang';
        $breadcrumb = 'xxxxxxxxxxxx / Aplikasi Tentang';
        $titleviewModal = 'Lihat Aplikasi Tentang';
        $titleeditModal = 'Edit Aplikasi Tentang';
        $titlecreateModal = 'Buat Aplikasi Tentang';
        $arr_ths = [
            'Judul',
            'Versi',
            'Level',
            'Keterangan',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Aplikasi\Tentang\TentangAplikasi::get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.aplikasi.tentang.tentangaplikasi.tentang-aplikasi', compact(
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
        $title = 'Tambah Data Aplikasi Tentang';
        $breadcrumb = 'xxxxxxxxxxxx / Aplikasi Tentang';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.aplikasi.tentang.tentangaplikasi.tentang-aplikasi-create', compact(
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
        \App\Models\Aplikasi\Tentang\TentangAplikasi::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Aplikasi Tentang';
        $breadcrumb = 'xxxxxxxxxxxx / Aplikasi Tentang';
        $data = \App\Models\Aplikasi\Tentang\TentangAplikasi::findOrFail($id);

        return view('role.aplikasi.tentang.tentangaplikasi.tentang-aplikasi-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Aplikasi Tentang';
        $breadcrumb = 'xxxxxxxxxxxx / Aplikasi Tentang / Edit';
        $data = \App\Models\Aplikasi\Tentang\TentangAplikasi::findOrFail($id);

        return view('role.aplikasi.tentang.tentangaplikasi.tentang-aplikasi-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        // dd($request->all());
        $data = \App\Models\Aplikasi\Tentang\TentangAplikasi::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'content' => 'string'
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
        $data = \App\Models\Aplikasi\Tentang\TentangAplikasi::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
