<?php

namespace App\Http\Controllers\Program\Surat\Undangan;

use App\Models\Program\Surat\Undangan\SuratUndangan;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class SuratUndanganController extends Controller
{
    public function index()
{
    // Mendapatkan judul halaman sesuai dengan nama kelas
    $title = 'Program Surat Undangan';
    $breadcrumb = 'xxxxxxxxxxxx / Program Surat Undangan';
        $titleviewModal = 'Lihat Program Surat Undangan';
        $titleeditModal = 'Edit Program Surat Undangan';
        $titlecreateModal = 'Buat Program Surat Undangan';
    $arr_ths = [
            'xxxxxxxxxxxxxxxxxxx',
            'xxxxxxxxxxxxxxxxxxx',
            'xxxxxxxxxxxxxxxxxxx',
        ];

    // Mendapatkan data dari tabel Etapel yang sedang aktif
    $etapels = Etapel::where('aktiv', 'Y')->first();

    // Mengambil data dari model terkait dengan tapel_id
    $datas = \App\Models\Program\Surat\Undangan\SuratUndangan::where('tapel_id', $etapels->id)->get();

    // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
    return view('role.program.surat.undangan.suratundangan.surat-undangan', compact('title',
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
    $title = 'Tambah Data Program Surat Undangan';
    $breadcrumb = 'xxxxxxxxxxxx / Program Surat Undangan';

    // Breadcrumb (jika diperlukan)
    $breadcrumb = 'Tambah';

    return view('role.program.surat.undangan.suratundangan.surat-undangan-create', compact(
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
    \App\Models\Program\Surat\Undangan\SuratUndangan::create($validator->validated());

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil disimpan');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function show($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Lihat Detail Program Surat Undangan';
    $breadcrumb = 'xxxxxxxxxxxx / Program Surat Undangan';
    $data = \App\Models\Program\Surat\Undangan\SuratUndangan::findOrFail($id);

    return view('role.program.surat.undangan.suratundangan.surat-undangan-single', compact(
        'title',
     'breadcrumb',
      'data',
      ));
}
public function edit($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Edit Program Surat Undangan';
    $breadcrumb = 'xxxxxxxxxxxx / Program Surat Undangan / Edit';
    $data = \App\Models\Program\Surat\Undangan\SuratUndangan::findOrFail($id);

    return view('role.program.surat.undangan.suratundangan.surat-undangan-edit', compact(
        'title',
        'breadcrumb',
        'data',
    ));
}

public function update(Request $request, $id)
{
    // Menemukan data yang akan diupdate berdasarkan ID
    $data = \App\Models\Program\Surat\Undangan\SuratUndangan::findOrFail($id);

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
    $data = \App\Models\Program\Surat\Undangan\SuratUndangan::findOrFail($id);

    // Menghapus data
    $data->delete();

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil dihapus');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

}
