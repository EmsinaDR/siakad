<?php

namespace App\Http\Controllers\Program\Quesioner;

use App\Models\Program\Quesioner\xDasboardQuesioner;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class xDasboardQuesionerController extends Controller
{
    public function index()
{
    // Mendapatkan judul halaman sesuai dengan nama kelas
    $title = 'Program Quesioner';
    $breadcrumb = 'Program Quesioner / X Dasboard Quesioner';
        $titleviewModal = 'Lihat Program Quesioner';
        $titleeditModal = 'Edit Program Quesioner';
        $titlecreateModal = 'Buat Program Quesioner';
    $arr_ths = [
            '{{ aaaa }}',
            'xxxxxxxxxxxxxxxxxxx',
            'xxxxxxxxxxxxxxxxxxx',
        ];

    // Mendapatkan data dari tabel Etapel yang sedang aktif
    $etapels = Etapel::where('aktiv', 'Y')->first();

    // Mengambil data dari model terkait dengan tapel_id
    $xDasboardQuesioner = Cache::tags(['xDasboardQuesioner_Chace'])->remember(
        'xDasboardQuesioner_Remember',
        now()->addHours(2),
        fn () => xDasboardQuesioner::where('tapel_id', $etapels->id)->get()
    );


    HapusCacheDenganTag('xDasboardQuesioner_Chace');
    // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
    return view('role.program.quesioner.xdasboardquesioner.x-dasboard-quesioner', compact('title',
            'title',
            'arr_ths',
            'xDasboardQuesioner',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
     ));
}

public function create()
{
    // Judul halaman
    $title = 'Tambah Data Program Quesioner';
    $breadcrumb = 'Create Program Quesioner / X Dasboard Quesioner';

    // Breadcrumb (jika diperlukan)

    return view('role.program.quesioner.xdasboardquesioner.x-dasboard-quesioner-create', compact(
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
    xDasboardQuesioner::create($validator->validated());

    HapusCacheDenganTag('xDasboardQuesioner_Chace');
    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil disimpan');
    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function show($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Lihat Detail Program Quesioner';
    $breadcrumb = 'Lihat Program Quesioner / X Dasboard Quesioner';
    $data = xDasboardQuesioner::findOrFail($id);

    return view('role.program.quesioner.xdasboardquesioner.x-dasboard-quesioner-single', compact(
        'title',
     'breadcrumb',
      'data',
      ));
}
public function edit($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Edit Program Quesioner';
    $breadcrumb = 'xxxxxxxxxxxx / Program Quesioner / Edit';
    $data = xDasboardQuesioner::findOrFail($id);


    return view('role.program.quesioner.xdasboardquesioner.x-dasboard-quesioner-edit', compact(
        'title',
        'breadcrumb',
        'data',
    ));
}

public function update(Request $request, $id)
{
    // Menemukan data yang akan diupdate berdasarkan ID
    $data = xDasboardQuesioner::findOrFail($id);

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


    HapusCacheDenganTag('xDasboardQuesioner_Chace');
    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil diperbarui');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function destroy($id)
{
    // Menemukan data yang akan dihapus berdasarkan ID
    $data = xDasboardQuesioner::findOrFail($id);

    // Menghapus data
    $data->delete();

    HapusCacheDenganTag('xDasboardQuesioner_Chace');

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil dihapus');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

}
