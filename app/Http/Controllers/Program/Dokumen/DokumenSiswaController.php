<?php

namespace App\Http\Controllers\Program\Dokumen;

use App\Models\Program\Dokumen\DokumenSiswa;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class DokumenSiswaController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Program Dokumen';
        $breadcrumb = 'xxxxxxxxxxxx / Program Dokumen';
        $titleviewModal = 'Lihat Program Dokumen';
        $titleeditModal = 'Edit Program Dokumen';
        $titlecreateModal = 'Buat Program Dokumen';
        $arr_ths = [
            'Nama',
            'Kelas',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Program\Dokumen\DokumenSiswa::orderBy('kelas_id', 'ASC')->orderBy('nama_siswa', 'ASC')->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.program.dokumen.dokumensiswa.dokumen-siswa', compact(
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
        $title = 'Tambah Data Program Dokumen';
        $breadcrumb = 'xxxxxxxxxxxx / Program Dokumen';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.program.dokumen.dokumensiswa.dokumen-siswa-create', compact(
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
        \App\Models\Program\Dokumen\DokumenSiswa::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Program Dokumen';
        $breadcrumb = 'xxxxxxxxxxxx / Program Dokumen';
        $data = \App\Models\Program\Dokumen\DokumenSiswa::findOrFail($id);

        return view('role.program.dokumen.dokumensiswa.dokumen-siswa-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Program Dokumen';
        $breadcrumb = 'xxxxxxxxxxxx / Program Dokumen / Edit';
        $data = \App\Models\Program\Dokumen\DokumenSiswa::findOrFail($id);

        return view('role.program.dokumen.dokumensiswa.dokumen-siswa-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Program\Dokumen\DokumenSiswa::findOrFail($id);

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
        $data = \App\Models\Program\Dokumen\DokumenSiswa::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
    public function CetakDokumenSiswa(Request $request)
    {
        //dd($request->all());
        $dokumenDipilih = $request->input('dokumen', []);
        $detailSiswaIds = $request->input('detailsiswa_id', []);

        // Ambil data siswa dari database
        $siswas = Detailsiswa::whereIn('id', $detailSiswaIds)->get();

        return view('role.program.dokumen.dokumensiswa.cetak-dokumen-siswa', compact(
            'dokumenDipilih',
            'siswas',
        ));
    }
}
