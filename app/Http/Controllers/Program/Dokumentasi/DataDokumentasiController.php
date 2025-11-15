<?php

namespace App\Http\Controllers\Program\Dokumentasi;

use App\Models\Program\Dokumentasi\DataDokumentasi;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class DataDokumentasiController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'DataDokumentasiController';

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Program\Dokumentasi\DataDokumentasi::where('tapel_id', $etapels->id)->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.program.dokumentasi.datadokumentasi.data-dokumentasi', compact('title', 'datas'));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data DataDokumentasiController';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('{{ view_create }}', compact('title', 'breadcrumb'));
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
        \App\Models\Program\Dokumentasi\DataDokumentasi::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $data = \App\Models\Program\Dokumentasi\DataDokumentasi::findOrFail($id);

        // Judul halaman
        $title = 'Detail DataDokumentasiController';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Detail';

        return view('{{ view_show }}', compact('title', 'breadcrumb', 'data'));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Program\Dokumentasi\DataDokumentasi::findOrFail($id);

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
        $data = \App\Models\Program\Dokumentasi\DataDokumentasi::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
