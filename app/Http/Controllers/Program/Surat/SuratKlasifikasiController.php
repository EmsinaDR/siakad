<?php

namespace App\Http\Controllers\Program\Surat;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Admin\Identitas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Program\Surat\SuratKeluar;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Surat\SuratKlasifikasi;

class SuratKlasifikasiController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Kalsifikasi Surat';
        $breadcrumb = 'Program Surat / Kalsifikasi Surat';
        $titleviewModal = 'Lihat Kalsifikasi Surat';
        $titleeditModal = 'Edit Kalsifikasi Surat';
        $titlecreateModal = 'Buat Kalsifikasi Surat';
        $arr_ths = [
            'Kode',
            'Klasifikasi',
            'Keterangan',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Program\Surat\SuratKlasifikasi::get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.program.surat.SuratKlasifikasi.surat-klasifikasi', compact(
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
        $title = 'Tambah Data Program Surat';
        $breadcrumb = 'Program Surat / Program Surat';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.program.surat.SuratKlasifikasi.surat-klasifikasir-create', compact(
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
        \App\Models\Program\Surat\SuratKlasifikasi::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Program Surat';
        $breadcrumb = 'Program Surat / Program Surat';
        $data = \App\Models\Program\Surat\SuratKlasifikasi::findOrFail($id);

        return view('role.program.surat.SuratKlasifikasi.surat-klasifikasir-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Program Surat';
        $breadcrumb = 'Program Surat / Program Surat / Edit';
        $data = \App\Models\Program\Surat\SuratKlasifikasi::findOrFail($id);

        return view('role.program.surat.SuratKlasifikasi.surat-klasifikasir-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Program\Surat\SuratKlasifikasi::findOrFail($id);

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
        $data = \App\Models\Program\Surat\SuratKlasifikasi::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
    // Ajax
    public function NoSuratGen(Request $request)
    {
        $klasifikasiId = $request->input('klasifikasi_id');
        $noSurat = SuratKeluar::generateNoSurat($klasifikasiId);

        if (!$noSurat) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat nomor surat, klasifikasi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'nomor_surat' => $noSurat
        ]);
    }
}
