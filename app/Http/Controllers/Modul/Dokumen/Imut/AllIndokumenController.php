<?php

namespace App\Http\Controllers\Modul\Dokumen\Imut;

use App\Models\Modul\Dokumen\Imut\AllIndokumen;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;

class AllIndokumenController extends Controller
{
    public function index()
{
    // Mendapatkan judul halaman sesuai dengan nama kelas
    $title = 'Modul\Dokumen Imut';
    $breadcrumb = 'Modul\Dokumen Imut / All Indokumen';
        $titleviewModal = 'Lihat Modul\Dokumen Imut';
        $titleeditModal = 'Edit Modul\Dokumen Imut';
        $titlecreateModal = 'Buat Modul\Dokumen Imut';
    $arr_ths = [
            'Nama Dokumen',
'Slug',
'Keterangan',

        ];

    // Mendapatkan data dari tabel Etapel yang sedang aktif
    $etapels = Etapel::where('aktiv', 'Y')->first();

    // Mengambil data dari model terkait dengan tapel_id
    // addHours addMinutes
    $AllIndokumen = Cache::tags(['Chace_AllIndokumen'])->remember(
        'Remember_AllIndokumen',
        now()->addMinutes(30),
        fn () => AllIndokumen::where('tapel_id', $etapels->id)->get()
    );


    // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
    return view('modul\dokumen.imut.allindokumen.all-indokumen', compact('title',
            'title',
            'arr_ths',
            'AllIndokumen',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
     ));
}

public function create()
{
    // Judul halaman
    $title = 'Tambah Data Modul\Dokumen Imut';
    $breadcrumb = 'Create Modul\Dokumen Imut / All Indokumen';

    // Breadcrumb (jika diperlukan)

    return view('modul\dokumen.imut.allindokumen.all-indokumen-create', compact(
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
        'nama_dokumen' => 'required|string|min:3|max:255',
'slug' => 'required|string|min:3|max:255',
'keterangan' => 'required|string|min:3|max:255',

    ]);

    // Jika validasi gagal, kembalikan dengan pesan error
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Membuat entri baru berdasarkan validasi
    AllIndokumen::create($validator->validated());

    HapusCacheDenganTag('Chace_AllIndokumen');
    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil disimpan');
    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function show($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Lihat Detail Modul\Dokumen Imut';
    $breadcrumb = 'Lihat Modul\Dokumen Imut / All Indokumen';
    $data = AllIndokumen::findOrFail($id);

    return view('modul\dokumen.imut.allindokumen.all-indokumen-single', compact(
        'title',
     'breadcrumb',
      'data',
      ));
}
public function edit($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Edit Modul\Dokumen Imut';
    $breadcrumb = 'xxxxxxxxxxxx / Modul\Dokumen Imut / Edit';
    $data = AllIndokumen::findOrFail($id);


    return view('modul\dokumen.imut.allindokumen.all-indokumen-edit', compact(
        'title',
        'breadcrumb',
        'data',
    ));
}

public function update(Request $request, $id)
{
    // Menemukan data yang akan diupdate berdasarkan ID
    $data = AllIndokumen::findOrFail($id);

    // Validasi input
    $validator = Validator::make($request->all(), [
        // Tambahkan validasi sesuai kebutuhan
        'tapel_id' => 'required|numeric|min:1|max:100',
        'nama_dokumen' => 'required|string|min:3|max:255',
'slug' => 'required|string|min:3|max:255',
'keterangan' => 'required|string|min:3|max:255',

    ]);

    // Jika validasi gagal, kembalikan dengan pesan error
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Update data yang ditemukan berdasarkan hasil validasi
    $data->update($validator->validated());


    HapusCacheDenganTag('Chace_AllIndokumen');
    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil diperbarui');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function destroy($id)
{
    // Menemukan data yang akan dihapus berdasarkan ID
    $data = AllIndokumen::findOrFail($id);

    // Menghapus data
    $data->delete();

    HapusCacheDenganTag('Chace_AllIndokumen');

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil dihapus');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

}
