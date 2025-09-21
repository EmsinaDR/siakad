<?php

namespace App\Http\Controllers\AdminDev;

use App\Models\AdminDev\DataVendor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;

class DataVendorController extends Controller
{
    public function index()
{
    // Mendapatkan judul halaman sesuai dengan nama kelas
    $title = 'AdminDev';
    $breadcrumb = 'AdminDev / Data Vendor';
        $titleviewModal = 'Lihat AdminDev';
        $titleeditModal = 'Edit AdminDev';
        $titlecreateModal = 'Buat AdminDev';
    $arr_ths = [
            'Fillable',

        ];

    // Mendapatkan data dari tabel Etapel yang sedang aktif
    $etapels = Etapel::where('aktiv', 'Y')->first();

    // Mengambil data dari model terkait dengan tapel_id
    // addHours addMinutes
    $DataVendor = Cache::tags(['Chace_DataVendor'])->remember(
        'Remember_DataVendor',
        now()->addMinutes(30),
        fn () => DataVendor::where('tapel_id', $etapels->id)->get()
    );


    // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
    return view('role.admindev.datavendor.data-vendor', compact('title',
            'title',
            'arr_ths',
            'DataVendor',
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
    $breadcrumb = 'Create AdminDev / Data Vendor';

    // Breadcrumb (jika diperlukan)

    return view('role.admindev.datavendor.data-vendor-create', compact(
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
        'fillable' => 'required|string|min:3|max:255',

    ]);

    // Jika validasi gagal, kembalikan dengan pesan error
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Membuat entri baru berdasarkan validasi
    DataVendor::create($validator->validated());

    HapusCacheDenganTag('Chace_DataVendor');
    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil disimpan');
    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function show($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Lihat Detail AdminDev';
    $breadcrumb = 'Lihat AdminDev / Data Vendor';
    $data = DataVendor::findOrFail($id);

    return view('role.admindev.datavendor.data-vendor-single', compact(
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
    $data = DataVendor::findOrFail($id);


    return view('role.admindev.datavendor.data-vendor-edit', compact(
        'title',
        'breadcrumb',
        'data',
    ));
}

public function update(Request $request, $id)
{
    // Menemukan data yang akan diupdate berdasarkan ID
    $data = DataVendor::findOrFail($id);

    // Validasi input
    $validator = Validator::make($request->all(), [
        // Tambahkan validasi sesuai kebutuhan
        'tapel_id' => 'required|numeric|min:1|max:100',
        'fillable' => 'required|string|min:3|max:255',

    ]);

    // Jika validasi gagal, kembalikan dengan pesan error
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Update data yang ditemukan berdasarkan hasil validasi
    $data->update($validator->validated());


    HapusCacheDenganTag('Chace_DataVendor');
    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil diperbarui');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function destroy($id)
{
    // Menemukan data yang akan dihapus berdasarkan ID
    $data = DataVendor::findOrFail($id);

    // Menghapus data
    $data->delete();

    HapusCacheDenganTag('Chace_DataVendor');

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil dihapus');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

}
