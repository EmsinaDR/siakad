<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Models\KepalaSekolah\Pembinaan;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class PembinaanController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Data Pembinaan';
        $breadcrumb = 'Kepala Sekolah / Data Pembinaan';
        $titleviewModal = 'Lihat Kepala Sekolah';
        $titleeditModal = 'Edit Kepala Sekolah';
        $titlecreateModal = 'Buat Kepala Sekolah';
        $arr_ths = [
            'Tanggal',
            'Nama Guru',
            'Status',
            'Indikator',
            'Kesimpulan',
            'Tindak Lanjut',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\KepalaSekolah\Pembinaan::with('Guru')->where('tapel_id', $etapels->id)->orderBy('tanggal', 'DESC')->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.kepalasekolah.pembinaan.pembinaan', compact(
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
        $title = 'Tambah Data KepalaSekolah';
        $breadcrumb = 'xxxxxxxxxxxx / KepalaSekolah';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.kepalasekolah.pembinaan.pembinaan-create', compact(
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
            'tapel_id' => 'required|exists:etapels,id',
            'detailguru_id' => 'required|exists:detailgurus,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Belum,Proses,Selesai',
            'indikator' => 'required|string|max:255',
            // 'kesimpulan_umum' => 'required|string|max:255',
            // 'tindak_lanjut' => 'required|string|max:255',
            // 'keterangan' => 'nullable|string|max:500',
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        \App\Models\KepalaSekolah\Pembinaan::create($validator->validated());
        // dd($request->all());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Pembinaan';
        $breadcrumb = 'Data Pembinaan / Detail Pembinaan';
        $data = \App\Models\KepalaSekolah\Pembinaan::findOrFail($id);

        return view('role.kepalasekolah.pembinaan.pembinaan-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit KepalaSekolah';
        $breadcrumb = 'Data Pembinaan / Ubah Detail Pembinaan';
        $data = \App\Models\KepalaSekolah\Pembinaan::findOrFail($id);

        return view('role.kepalasekolah.pembinaan.pembinaan-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\KepalaSekolah\Pembinaan::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            // 'detailguru_id' => 'required|exists:detailgurus,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Belum,Proses,Selesai',
            'indikator' => 'required|string|max:255',
            'kesimpulan_umum' => 'required|string|max:255',
            'tindak_lanjut' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:500',
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
        $data = \App\Models\KepalaSekolah\Pembinaan::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
