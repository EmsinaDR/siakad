<?php

namespace App\Http\Controllers\Program\Quesioner;

use App\Models\Program\Quesioner\JawabnQuesioner;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class JawabnQuesionerController extends Controller
{
    public function index()
{
    // Mendapatkan judul halaman sesuai dengan nama kelas
    $title = 'Program Quesioner';
    $breadcrumb = 'Program Quesioner / Jawabn Quesioner';
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
    $JawabnQuesioner = Cache::tags(['JawabnQuesioner_Chace'])->remember(
        'JawabnQuesioner_Remember',
        now()->addHours(2),
        fn () => JawabnQuesioner::where('tapel_id', $etapels->id)->get()
    );


    // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
    return view('role.program.quesioner.jawabnquesioner.jawabn-quesioner', compact('title',
            'title',
            'arr_ths',
            'JawabnQuesioner',
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
    $breadcrumb = 'Create Program Quesioner / Jawabn Quesioner';

    // Breadcrumb (jika diperlukan)

    return view('role.program.quesioner.jawabnquesioner.jawabn-quesioner-create', compact(
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
        'tapel_id' => 'required|string|min:3|max:255',
'detailsiswa_id' => 'required|string|min:3|max:255',
'pertanyaan_id' => 'required|string|min:3|max:255',
'jawaban' => 'required|string|min:3|max:255',

    ]);

    // Jika validasi gagal, kembalikan dengan pesan error
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Membuat entri baru berdasarkan validasi
    JawabnQuesioner::create($validator->validated());

    HapusCacheDenganTag('JawabnQuesioner_Chace');
    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil disimpan');
    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function show($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Lihat Detail Program Quesioner';
    $breadcrumb = 'Lihat Program Quesioner / Jawabn Quesioner';
    $data = JawabnQuesioner::findOrFail($id);

    return view('role.program.quesioner.jawabnquesioner.jawabn-quesioner-single', compact(
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
    $data = JawabnQuesioner::findOrFail($id);


    return view('role.program.quesioner.jawabnquesioner.jawabn-quesioner-edit', compact(
        'title',
        'breadcrumb',
        'data',
    ));
}

public function update(Request $request, $id)
{
    // Menemukan data yang akan diupdate berdasarkan ID
    $data = JawabnQuesioner::findOrFail($id);

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


    HapusCacheDenganTag('JawabnQuesioner_Chace');
    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil diperbarui');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function destroy($id)
{
    // Menemukan data yang akan dihapus berdasarkan ID
    $data = JawabnQuesioner::findOrFail($id);

    // Menghapus data
    $data->delete();

    HapusCacheDenganTag('JawabnQuesioner_Chace');

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil dihapus');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

}
