<?php

namespace App\Http\Controllers\WaliKelas;

use App\Models\WaliKelas\DokumenSiswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;

class DokumenSiswaController extends Controller
{
    public function index()
{
    // Mendapatkan judul halaman sesuai dengan nama kelas
    $title = 'WaliKelas';
    $breadcrumb = 'WaliKelas / Dokumen Siswa';
        $titleviewModal = 'Lihat WaliKelas';
        $titleeditModal = 'Edit WaliKelas';
        $titlecreateModal = 'Buat WaliKelas';
    $arr_ths = [
            'Kk:ayah Ktp:ibu Ktp:ijazah:ijazah Sd:raport',

        ];

    // Mendapatkan data dari tabel Etapel yang sedang aktif
    $etapels = Etapel::where('aktiv', 'Y')->first();

    // Mengambil data dari model terkait dengan tapel_id
    // addHours addMinutes
    $DokumenSiswa = Cache::tags(['Chace_DokumenSiswa'])->remember(
        'Remember_DokumenSiswa',
        now()->addMinutes(30),
        fn () => DokumenSiswa::where('tapel_id', $etapels->id)->get()
    );


    // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
    return view('walikelas.dokumensiswa.dokumen-siswa', compact('title',
            'title',
            'arr_ths',
            'DokumenSiswa',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
     ));
}

public function create()
{
    // Judul halaman
    $title = 'Tambah Data WaliKelas';
    $breadcrumb = 'Create WaliKelas / Dokumen Siswa';

    // Breadcrumb (jika diperlukan)

    return view('walikelas.dokumensiswa.dokumen-siswa-create', compact(
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
        'tapel_id' => 'required|numeric|min:1|max:100',
        'kk:ayah_ktp:ibu_ktp:ijazah:ijazah_sd:raport' => 'required|string|min:3|max:255',

    ]);

    // Jika validasi gagal, kembalikan dengan pesan error
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Membuat entri baru berdasarkan validasi
    DokumenSiswa::create($validator->validated());

    HapusCacheDenganTag('Chace_DokumenSiswa');
    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil disimpan');
    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function show($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Lihat Detail WaliKelas';
    $breadcrumb = 'Lihat WaliKelas / Dokumen Siswa';
    $data = DokumenSiswa::findOrFail($id);

    return view('walikelas.dokumensiswa.dokumen-siswa-single', compact(
        'title',
     'breadcrumb',
      'data',
      ));
}
public function edit($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Edit WaliKelas';
    $breadcrumb = 'xxxxxxxxxxxx / WaliKelas / Edit';
    $data = DokumenSiswa::findOrFail($id);


    return view('walikelas.dokumensiswa.dokumen-siswa-edit', compact(
        'title',
        'breadcrumb',
        'data',
    ));
}

public function update(Request $request, $id)
{
    // Menemukan data yang akan diupdate berdasarkan ID
    $data = DokumenSiswa::findOrFail($id);

    // Validasi input
    $validator = Validator::make($request->all(), [
        // Tambahkan validasi sesuai kebutuhan
        'tapel_id' => 'required|numeric|min:1|max:100',
        'kk:ayah_ktp:ibu_ktp:ijazah:ijazah_sd:raport' => 'required|string|min:3|max:255',

    ]);

    // Jika validasi gagal, kembalikan dengan pesan error
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Update data yang ditemukan berdasarkan hasil validasi
    $data->update($validator->validated());


    HapusCacheDenganTag('Chace_DokumenSiswa');
    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil diperbarui');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function destroy($id)
{
    // Menemukan data yang akan dihapus berdasarkan ID
    $data = DokumenSiswa::findOrFail($id);

    // Menghapus data
    $data->delete();

    HapusCacheDenganTag('Chace_DokumenSiswa');

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil dihapus');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

}
