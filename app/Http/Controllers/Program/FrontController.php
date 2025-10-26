<?php

namespace App\Http\Controllers\Program;

use App\Models\Program\Front;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;

class FrontController extends Controller
{
    public function index()
{
    // Mendapatkan judul halaman sesuai dengan nama kelas
    $title = 'Program';
    $breadcrumb = 'Program / Front';
        $titleviewModal = 'Lihat Program';
        $titleeditModal = 'Edit Program';
        $titlecreateModal = 'Buat Program';
    $arr_ths = [
            'Fillable',

        ];

    // Mendapatkan data dari tabel Etapel yang sedang aktif
    $etapels = Etapel::where('aktiv', 'Y')->first();

    // Mengambil data dari model terkait dengan tapel_id
    // $Front = Cache::tags(['Front_Chace'])->remember(
    //     'Front_Remember',
    //     now()->addHours(2),
    //     fn () => Front::where('tapel_id', $etapels->id)->get()
    // );


    // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
    return view('role.program.front.front', compact('title',
            'title',
            'arr_ths',
            // 'Front',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
     ));
}

public function create()
{
    // Judul halaman
    $title = 'Tambah Data Program';
    $breadcrumb = 'Create Program / Front';

    // Breadcrumb (jika diperlukan)

    return view('role.program.front.front-create', compact(
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
    Front::create($validator->validated());

    HapusCacheDenganTag('Front_Chace');
    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil disimpan');
    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function show($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Lihat Detail Program';
    $breadcrumb = 'Lihat Program / Front';
    $data = Front::findOrFail($id);

    return view('role.program.front.front-single', compact(
        'title',
     'breadcrumb',
      'data',
      ));
}
public function edit($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Edit Program';
    $breadcrumb = 'xxxxxxxxxxxx / Program / Edit';
    $data = Front::findOrFail($id);


    return view('role.program.front.front-edit', compact(
        'title',
        'breadcrumb',
        'data',
    ));
}

public function update(Request $request, $id)
{
    // Menemukan data yang akan diupdate berdasarkan ID
    $data = Front::findOrFail($id);

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


    HapusCacheDenganTag('Front_Chace');
    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil diperbarui');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function destroy($id)
{
    // Menemukan data yang akan dihapus berdasarkan ID
    $data = Front::findOrFail($id);

    // Menghapus data
    $data->delete();

    HapusCacheDenganTag('Front_Chace');

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil dihapus');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

}
