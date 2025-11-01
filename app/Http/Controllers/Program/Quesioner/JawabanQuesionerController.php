<?php

namespace App\Http\Controllers\Program\Quesioner;

use App\Models\Program\Quesioner\JawabanQuesioner;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class JawabanQuesionerController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Program Quesioner';
        $breadcrumb = 'Program Quesioner / Jawaban Quesioner';
        $titleviewModal = 'Lihat Program Quesioner';
        $titleeditModal = 'Edit Program Quesioner';
        $titlecreateModal = 'Buat Program Quesioner';
        $arr_ths = [
            'Tapel Id',
            'Detailsiswa Id',
            'Pertanyaan Id',
            'Jawaban',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $JawabanQuesioner = Cache::tags(['JawabanQuesioner_Chace'])->remember(
            'JawabanQuesioner_Remember',
            now()->addHours(2),
            fn() => JawabanQuesioner::where('tapel_id', $etapels->id)->get()
        );


        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.program.quesioner.jawabanquesioner.jawaban-quesioner', compact(
            'title',
            'title',
            'arr_ths',
            'JawabanQuesioner',
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
        $breadcrumb = 'Create Program Quesioner / Jawaban Quesioner';

        // Breadcrumb (jika diperlukan)

        return view('role.program.quesioner.jawabanquesioner.jawaban-quesioner-create', compact(
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
        JawabanQuesioner::create($validator->validated());

        HapusCacheDenganTag('JawabanQuesioner_Chace');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');
        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Program Quesioner';
        $breadcrumb = 'Lihat Program Quesioner / Jawaban Quesioner';
        $data = JawabanQuesioner::findOrFail($id);

        return view('role.program.quesioner.jawabanquesioner.jawaban-quesioner-single', compact(
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
        $data = JawabanQuesioner::findOrFail($id);


        return view('role.program.quesioner.jawabanquesioner.jawaban-quesioner-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = JawabanQuesioner::findOrFail($id);

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

        // Update data yang ditemukan berdasarkan hasil validasi
        $data->update($validator->validated());


        HapusCacheDenganTag('JawabanQuesioner_Chace');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = JawabanQuesioner::findOrFail($id);

        // Menghapus data
        $data->delete();

        HapusCacheDenganTag('JawabanQuesioner_Chace');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
