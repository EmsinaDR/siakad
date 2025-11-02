<?php

namespace App\Http\Controllers\Tools\Qr;

use App\Models\Tools\Qr\GeneratorQr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;

class GeneratorQrController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Tools Qr';
        $breadcrumb = 'Tools Qr / Generator Qr';
        $titleviewModal = 'Lihat Tools Qr';
        $titleeditModal = 'Edit Tools Qr';
        $titlecreateModal = 'Buat Tools Qr';
        $arr_ths = [
            'Prview',
            'Judul',
            'Isi',

        ];
        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $GeneratorQr = Cache::tags(['Chace_GeneratorQr'])->remember(
            'Remember_GeneratorQr',
            now()->addHours(2),
            fn() => GeneratorQr::get()
        );


        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.tools.qr.generatorqr.generator-qr', compact(
            'title',
            'title',
            'arr_ths',
            'GeneratorQr',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Tools Qr';
        $breadcrumb = 'Create Tools Qr / Generator Qr';

        // Breadcrumb (jika diperlukan)

        return view('role.tools.qr.generatorqr.generator-qr-create', compact(
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
            // 'tapel_id' => 'required|numeric|min:1|max:100',
            'judul' => 'required|string|min:3|max:255',
            'isi' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        GeneratorQr::create($validator->validated());
        QrGen($request->judul, $request->isi, 'img/qrcode/qrgenerator');
        HapusCacheDenganTag('Chace_GeneratorQr');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');
        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Tools Qr';
        $breadcrumb = 'Lihat Tools Qr / Generator Qr';
        $data = GeneratorQr::findOrFail($id);

        return view('role.tools.qr.generatorqr.generator-qr-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Tools Qr';
        $breadcrumb = 'xxxxxxxxxxxx / Tools Qr / Edit';
        $data = GeneratorQr::findOrFail($id);


        return view('role.tools.qr.generatorqr.generator-qr-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = GeneratorQr::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            // 'tapel_id' => 'required|numeric|min:1|max:100',
            'judul' => 'required|string|min:3|max:255',
            'isi' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data yang ditemukan berdasarkan hasil validasi
        $data->update($validator->validated());


        HapusCacheDenganTag('Chace_GeneratorQr');
        QrGen($request->judul, $request->isi, 'img/qrcode/qrgenerator');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = GeneratorQr::findOrFail($id);

        // Menghapus data
        $data->delete();

        HapusCacheDenganTag('Chace_GeneratorQr');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
