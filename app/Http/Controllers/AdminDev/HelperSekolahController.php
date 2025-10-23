<?php

namespace App\Http\Controllers\AdminDev;

use App\Models\AdminDev\HelperSekolah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;

class HelperSekolahController extends Controller
{
    public function index()
{
    // Mendapatkan judul halaman sesuai dengan nama kelas
    $title = 'AdminDev';
    $breadcrumb = 'AdminDev / Helper Sekolah';
        $titleviewModal = 'Lihat AdminDev';
        $titleeditModal = 'Edit AdminDev';
        $titlecreateModal = 'Buat AdminDev';
    $arr_ths = [
            'Judul',
'Slug',
'Content',
'Keterangan',

        ];

    // Mendapatkan data dari tabel Etapel yang sedang aktif
    $etapels = Etapel::where('aktiv', 'Y')->first();

    // Mengambil data dari model terkait dengan tapel_id
    // addHours addMinutes
    $HelperSekolah = Cache::tags(['Chace_HelperSekolah'])->remember(
        'Remember_HelperSekolah',
        now()->addMinutes(30),
        fn () => HelperSekolah::where('tapel_id', $etapels->id)->get()
    );


    // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
    return view('admindev.helpersekolah.helper-sekolah', compact('title',
            'title',
            'arr_ths',
            'HelperSekolah',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
     ));
}

public function create()
{
    // Judul halaman
    $title = 'Tambah Data AdminDev';
    $breadcrumb = 'Create AdminDev / Helper Sekolah';

    // Breadcrumb (jika diperlukan)

    return view('admindev.helpersekolah.helper-sekolah-create', compact(
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
        'judul' => 'required|string|min:3|max:255',
'slug' => 'required|string|min:3|max:255',
'content' => 'required|string|min:3|max:255',
'keterangan' => 'required|string|min:3|max:255',

    ]);

    // Jika validasi gagal, kembalikan dengan pesan error
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Membuat entri baru berdasarkan validasi
    HelperSekolah::create($validator->validated());

    HapusCacheDenganTag('Chace_HelperSekolah');
    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil disimpan');
    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function show($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Lihat Detail AdminDev';
    $breadcrumb = 'Lihat AdminDev / Helper Sekolah';
    $data = HelperSekolah::findOrFail($id);

    return view('admindev.helpersekolah.helper-sekolah-single', compact(
        'title',
     'breadcrumb',
      'data',
      ));
}
public function edit($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Edit AdminDev';
    $breadcrumb = 'xxxxxxxxxxxx / AdminDev / Edit';
    $data = HelperSekolah::findOrFail($id);


    return view('admindev.helpersekolah.helper-sekolah-edit', compact(
        'title',
        'breadcrumb',
        'data',
    ));
}

public function update(Request $request, $id)
{
    // Menemukan data yang akan diupdate berdasarkan ID
    $data = HelperSekolah::findOrFail($id);

    // Validasi input
    $validator = Validator::make($request->all(), [
        // Tambahkan validasi sesuai kebutuhan
        'tapel_id' => 'required|numeric|min:1|max:100',
        'judul' => 'required|string|min:3|max:255',
'slug' => 'required|string|min:3|max:255',
'content' => 'required|string|min:3|max:255',
'keterangan' => 'required|string|min:3|max:255',

    ]);

    // Jika validasi gagal, kembalikan dengan pesan error
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Update data yang ditemukan berdasarkan hasil validasi
    $data->update($validator->validated());


    HapusCacheDenganTag('Chace_HelperSekolah');
    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil diperbarui');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function destroy($id)
{
    // Menemukan data yang akan dihapus berdasarkan ID
    $data = HelperSekolah::findOrFail($id);

    // Menghapus data
    $data->delete();

    HapusCacheDenganTag('Chace_HelperSekolah');

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil dihapus');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

}
