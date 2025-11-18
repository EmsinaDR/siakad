<?php

namespace App\Http\Controllers\Paket\Kerjasama;

use App\Models\Paket\Kerjasama\HargaPaket;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class HargaPaketController extends Controller
{
    public function index()
{
    // Mendapatkan judul halaman sesuai dengan nama kelas
    $title = 'Paket Kerjasama';
    $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama';
        $titleviewModal = 'Lihat Paket Kerjasama';
        $titleeditModal = 'Edit Paket Kerjasama';
        $titlecreateModal = 'Buat Paket Kerjasama';
    $arr_ths = [
            'xxxxxxxxxxxxxxxxxxx',
            'xxxxxxxxxxxxxxxxxxx',
            'xxxxxxxxxxxxxxxxxxx',
        ];

    // Mendapatkan data dari tabel Etapel yang sedang aktif
    $etapels = Etapel::where('aktiv', 'Y')->first();

    // Mengambil data dari model terkait dengan tapel_id
    $datas = \App\Models\Paket\Kerjasama\HargaPaket::where('tapel_id', $etapels->id)->get();

    // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
    return view('role.paket.kerjasama.hargapaket.harga-paket', compact('title',
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
    $title = 'Tambah Data Paket Kerjasama';
    $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama';

    // Breadcrumb (jika diperlukan)
    $breadcrumb = 'Tambah';

    return view('role.paket.kerjasama.hargapaket.harga-paket-create', compact(
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
    \App\Models\Paket\Kerjasama\HargaPaket::create($validator->validated());

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil disimpan');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function show($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Lihat Detail Paket Kerjasama';
    $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama';
    $data = \App\Models\Paket\Kerjasama\HargaPaket::findOrFail($id);

    return view('role.paket.kerjasama.hargapaket.harga-paket-single', compact(
        'title',
     'breadcrumb',
      'data',
      ));
}
public function edit($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Edit Paket Kerjasama';
    $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama / Edit';
    $data = \App\Models\Paket\Kerjasama\HargaPaket::findOrFail($id);

    return view('role.paket.kerjasama.hargapaket.harga-paket-edit', compact(
        'title',
        'breadcrumb',
        'data',
    ));
}

public function update(Request $request, $id)
{
    // Menemukan data yang akan diupdate berdasarkan ID
    $data = \App\Models\Paket\Kerjasama\HargaPaket::findOrFail($id);

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
    $data = \App\Models\Paket\Kerjasama\HargaPaket::findOrFail($id);

    // Menghapus data
    $data->delete();

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil dihapus');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

}
