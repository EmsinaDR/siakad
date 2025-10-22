<?php

namespace App\Http\Controllers\Program\Surat;

use App\Models\Program\Surat\SuratMasuk;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use App\Models\Program\Surat\SuratKlasifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class SuratMasukController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Program Surat';
        $breadcrumb = 'xxxxxxxxxxxx / Program Surat';
        $titleviewModal = 'Lihat Program Surat';
        $titleeditModal = 'Edit Program Surat';
        $titlecreateModal = 'Buat Program Surat';
        $arr_ths = [
            'Tanggal Masuk',
            'Jenis Pengirim',
            'Kategori',
            'Perihal',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Program\Surat\SuratMasuk::with(['Klasifikasi'])->where('tapel_id', $etapels->id)->orderBy('created_at', 'DESC')->get();
        $suratKlasifikasis = SuratKlasifikasi::get();
        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.program.surat.suratmasuk.surat-masuk', compact(
            'title',
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'suratKlasifikasis',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Program Surat';
        $breadcrumb = 'xxxxxxxxxxxx / Program Surat';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.program.surat.suratmasuk.surat-masuk-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {
        // Mendapatkan data Etapel yang aktif
        dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge(['tapel_id' => $etapels->id]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'tapel_id' => 'nullable|exists:etapels,id',
            'klasifikasi_id' => 'nullable|exists:surat_klasifikasi,id',
            'nomorl_surat' => 'nullable|string|max:255',
            'tanggal_surat' => 'nullable|date',
            'tanggal_terima' => 'nullable|date',
            'jenis_pengirim' => 'nullable|in:Instansi,Perorangan,Persero,PT',
            'nama_pengirim' => 'nullable|string|max:255',
            'buku_tamu_id' => 'nullable|exists:buku_tamu,id',
            'kategori' => 'nullable|string|max:350',
            'perihal' => 'nullable|string|max:350',
            'lampiran' => 'nullable|string|max:350',
            'status' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:550',
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        \App\Models\Program\Surat\SuratMasuk::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Program Surat';
        $breadcrumb = 'xxxxxxxxxxxx / Program Surat';
        $data = \App\Models\Program\Surat\SuratMasuk::findOrFail($id);

        return view('role.program.surat.suratmasuk.surat-masuk-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Program Surat';
        $breadcrumb = 'xxxxxxxxxxxx / Program Surat / Edit';
        $data = \App\Models\Program\Surat\SuratMasuk::findOrFail($id);

        return view('role.program.surat.suratmasuk.surat-masuk-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Program\Surat\SuratMasuk::findOrFail($id);

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
        $data = \App\Models\Program\Surat\SuratMasuk::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
