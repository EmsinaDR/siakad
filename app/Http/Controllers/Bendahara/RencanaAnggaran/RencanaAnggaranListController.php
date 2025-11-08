<?php

namespace App\Http\Controllers\Bendahara\RencanaAnggaran;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Bendahara\RencanaAnggaran\RencanaAnggaranList;

class RencanaAnggaranListController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Bendahara Rencana Anggaran';
        $breadcrumb = 'Bendahara / Rencana Anggaran / List Rencana Anggaran';
        $titleviewModal = 'Lihat Bendahara Rencana Anggaran';
        $titleeditModal = 'Edit Bendahara Rencana Anggaran';
        $titlecreateModal = 'Buat Bendahara Rencana Anggaran';
        $arr_ths = [
            'Kode',
            'Kategori',
            'Jenis Pembayaran',
            'Keterangan',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif

        // Mengambil data dari model terkait dengan tapel_id
        $ListRencanaAnggaran = Cache::tags(['ListRencanaAnggaran'])->remember('ListRencanaAnggaran', now()->addHours(2), function () {
            return RencanaAnggaranList::orderBy('created_at', 'DESC')->get();;
        });

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.bendahara.rencanaanggaran.rencanaanggaranlist.rencana-anggaran-list', compact(
            'title',
            'title',
            'arr_ths',
            'ListRencanaAnggaran',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Bendahara Rencana Anggaran';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara Rencana Anggaran';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.bendahara.rencanaanggaran.rencanaanggaranlist.rencana-anggaran-list-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {
        // Mendapatkan data Etapel yang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $jumlahData = RencanaAnggaranList::count();
        $kode = preg_match_all('/[A-Z]/', $request->jenis_pengeluaran, $matches);
        $kode = implode('', $matches[0]) . '-' . $jumlahData + 1;
        $request->merge([
            'tapel_id' => $etapels->id,
            'kode' => $kode,
        ]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'kode' => 'string',
            'jenis_pengeluaran' => 'string',
            'kategori' => 'string',
            'keterangan' => 'string',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        \App\Models\Bendahara\RencanaAnggaran\RencanaAnggaranList::create($validator->validated());
        HapusCacheDenganTag('ListRencanaAnggaran');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Bendahara Rencana Anggaran';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara Rencana Anggaran';
        $data = \App\Models\Bendahara\RencanaAnggaran\RencanaAnggaranList::findOrFail($id);

        return view('role.bendahara.rencanaanggaran.rencanaanggaranlist.rencana-anggaran-list-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Bendahara Rencana Anggaran';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara Rencana Anggaran / Edit';
        $data = \App\Models\Bendahara\RencanaAnggaran\RencanaAnggaranList::findOrFail($id);

        return view('role.bendahara.rencanaanggaran.rencanaanggaranlist.rencana-anggaran-list-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Bendahara\RencanaAnggaran\RencanaAnggaranList::findOrFail($id);

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
        HapusCacheDenganTag('ListRencanaAnggaran');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = \App\Models\Bendahara\RencanaAnggaran\RencanaAnggaranList::findOrFail($id);

        // Menghapus data
        $data->delete();
        HapusCacheDenganTag('ListRencanaAnggaran');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
