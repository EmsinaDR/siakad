<?php

namespace App\Http\Controllers\Bendahara\BOS;

use App\Models\Bendahara\BOS\BukuKasBOS;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use App\Models\Bendahara\BOS\PengeluaranBOS;
use App\Models\KepalaSekolah\KeuanganBos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class BukuKasBOSController extends Controller
{
    public function index()
{
    // Mendapatkan judul halaman sesuai dengan nama kelas
    $title = 'Bendahara BOS';
    $breadcrumb = 'Buku Kas Dana BOS / Bendahara BOS';
        $titleviewModal = 'Lihat Bendahara BOS';
        $titleeditModal = 'Edit Bendahara BOS';
        $titlecreateModal = 'Buat Bendahara BOS';
    // Mendapatkan data dari tabel Etapel yang sedang aktif
    $etapels = Etapel::where('aktiv', 'Y')->first();

    // Mengambil data dari model terkait dengan tapel_id
    $datas = \App\Models\Bendahara\BOS\BukuKasBOS::with(['Pemasukkan'])->where('tapel_id', $etapels->id)->get();
    $DanaBos = KeuanganBos::orderBy('sumber_dana', 'ASC')->where('tapel_id', $etapels->id)->get();

    // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
    return view('role.bendahara.bos.bukukasbos.buku-kas-bos', compact('title',
            'title',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DanaBos',
     ));
}

public function create()
{
    // Judul halaman
    $title = 'Tambah Data Bendahara BOS';
    $breadcrumb = 'xxxxxxxxxxxx / Bendahara BOS';

    // Breadcrumb (jika diperlukan)
    $breadcrumb = 'Tambah';

    return view('role.bendahara.bos.bukukasbos.buku-kas-bos-create', compact(
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
    \App\Models\Bendahara\BOS\BukuKasBOS::create($validator->validated());

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil disimpan');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function show($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Lihat Detail Bendahara BOS';
    $breadcrumb = 'xxxxxxxxxxxx / Bendahara BOS';
    $data = \App\Models\Bendahara\BOS\BukuKasBOS::findOrFail($id);

    return view('role.bendahara.bos.bukukasbos.buku-kas-bos-single', compact(
        'title',
     'breadcrumb',
      'data',
      ));
}
public function edit($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Edit Bendahara BOS';
    $breadcrumb = 'xxxxxxxxxxxx / Bendahara BOS / Edit';
    $data = \App\Models\Bendahara\BOS\BukuKasBOS::findOrFail($id);

    return view('role.bendahara.bos.bukukasbos.buku-kas-bos-edit', compact(
        'title',
        'breadcrumb',
        'data',
    ));
}

public function update(Request $request, $id)
{
    // Menemukan data yang akan diupdate berdasarkan ID
    $data = \App\Models\Bendahara\BOS\BukuKasBOS::findOrFail($id);

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
    $data = \App\Models\Bendahara\BOS\BukuKasBOS::findOrFail($id);

    // Menghapus data
    $data->delete();

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil dihapus');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

}
