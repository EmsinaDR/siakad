<?php

namespace App\Http\Controllers\WakaKurikulum\Surat;

use App\Models\WakaKurikulum\Surat\SuratKelulusan;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use App\Models\WakaKurikulum\Kelulusan\PesertaKelulusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class SuratKelulusanController extends Controller
{
    public function index()
{
    // Mendapatkan judul halaman sesuai dengan nama kelas
    $title = 'WakaKurikulum Surat';
    $breadcrumb = 'xxxxxxxxxxxx / WakaKurikulum Surat';
        $titleviewModal = 'Lihat WakaKurikulum Surat';
        $titleeditModal = 'Edit WakaKurikulum Surat';
        $titlecreateModal = 'Buat WakaKurikulum Surat';
    $arr_ths = [
            'No Ujian',
            'Nama Siswa',
            'Kelas',
        ];

    // Mendapatkan data dari tabel Etapel yang sedang aktif
    $etapels = Etapel::where('aktiv', 'Y')->first();

    // Mengambil data dari model terkait dengan tapel_id
    $datas = \App\Models\WakaKurikulum\Surat\SuratKelulusan::where('tapel_id', $etapels->id)->get();
    $datas = PesertaKelulusan::where('tapel_id', $etapels->id)->get();

    // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
    return view('role.wakakurikulum.surat.suratkelulusan.surat-kelulusan', compact('title',
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
    $title = 'Tambah Data WakaKurikulum Surat';
    $breadcrumb = 'xxxxxxxxxxxx / WakaKurikulum Surat';

    // Breadcrumb (jika diperlukan)
    $breadcrumb = 'Tambah';

    return view('role.wakakurikulum.surat.suratkelulusan.surat-kelulusan-create', compact(
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
    \App\Models\WakaKurikulum\Surat\SuratKelulusan::create($validator->validated());

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil disimpan');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function show($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Lihat Detail WakaKurikulum Surat';
    $breadcrumb = 'xxxxxxxxxxxx / WakaKurikulum Surat';
    $data = \App\Models\WakaKurikulum\Surat\SuratKelulusan::findOrFail($id);

    return view('role.wakakurikulum.surat.suratkelulusan.surat-kelulusan-single', compact(
        'title',
     'breadcrumb',
      'data',
      ));
}
public function edit($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Edit WakaKurikulum Surat';
    $breadcrumb = 'xxxxxxxxxxxx / WakaKurikulum Surat / Edit';
    $data = \App\Models\WakaKurikulum\Surat\SuratKelulusan::findOrFail($id);

    return view('role.wakakurikulum.surat.suratkelulusan.surat-kelulusan-edit', compact(
        'title',
        'breadcrumb',
        'data',
    ));
}

public function update(Request $request, $id)
{
    // Menemukan data yang akan diupdate berdasarkan ID
    $data = \App\Models\WakaKurikulum\Surat\SuratKelulusan::findOrFail($id);

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
    $data = \App\Models\WakaKurikulum\Surat\SuratKelulusan::findOrFail($id);

    // Menghapus data
    $data->delete();

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil dihapus');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

}
