<?php

namespace App\Http\Controllers\AdminDev;

use App\Models\Admindev\SosialisasiAdminDev;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;

class SosialisasiAdminDevController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Admindev';
        $breadcrumb = 'Admindev / Sosialisasi Admin Dev';
        $titleviewModal = 'Lihat Admindev';
        $titleeditModal = 'Edit Admindev';
        $titlecreateModal = 'Buat Admindev';
        $arr_ths = [
            'Judul',
            'Kategori',
            'Aplikasi',
            'Pesan',
            'Target',
            'Jam',
            'Tanggal',
            'Keterangan',
            'Jumlah Terkirim',
            '',

        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        // addHours addMinutes
        $SosialisasiAdminDev = Cache::tags(['Chace_SosialisasiAdminDev'])->remember(
            'Remember_SosialisasiAdminDev',
            now()->addMinutes(30),
            fn() => SosialisasiAdminDev::where('tapel_id', $etapels->id)->get()
        );


        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.admindev.sosialisasiadmindev.sosialisasi-admin-dev', compact(
            'title',
            'title',
            'arr_ths',
            'SosialisasiAdminDev',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Admindev';
        $breadcrumb = 'Create Admindev / Sosialisasi Admin Dev';

        // Breadcrumb (jika diperlukan)

        return view('role.admindev.sosialisasiadmindev.sosialisasi-admin-dev-create', compact(
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
            'kategori' => 'required|string|min:3|max:255',
            'aplikasi' => 'required|string|min:3|max:255',
            'pesan' => 'required|string|min:3|max:255',
            'target' => 'required|string|min:3|max:255',
            'jam' => 'required|string|min:3|max:255',
            'tanggal' => 'required|string|min:3|max:255',
            'keterangan' => 'required|string|min:3|max:255',
            'jumlah_terkirim' => 'required|string|min:3|max:255',
            '' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        SosialisasiAdminDev::create($validator->validated());

        HapusCacheDenganTag('Chace_SosialisasiAdminDev');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');
        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Admindev';
        $breadcrumb = 'Lihat Admindev / Sosialisasi Admin Dev';
        $data = SosialisasiAdminDev::findOrFail($id);

        return view('role.admindev.sosialisasiadmindev.sosialisasi-admin-dev-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Admindev';
        $breadcrumb = 'xxxxxxxxxxxx / Admindev / Edit';
        $data = SosialisasiAdminDev::findOrFail($id);


        return view('role.admindev.sosialisasiadmindev.sosialisasi-admin-dev-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = SosialisasiAdminDev::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'tapel_id' => 'required|numeric|min:1|max:100',
            'judul' => 'required|string|min:3|max:255',
            'kategori' => 'required|string|min:3|max:255',
            'aplikasi' => 'required|string|min:3|max:255',
            'pesan' => 'required|string|min:3|max:255',
            'target' => 'required|string|min:3|max:255',
            'jam' => 'required|string|min:3|max:255',
            'tanggal' => 'required|string|min:3|max:255',
            'keterangan' => 'required|string|min:3|max:255',
            'jumlah_terkirim' => 'required|string|min:3|max:255',
            '' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data yang ditemukan berdasarkan hasil validasi
        $data->update($validator->validated());


        HapusCacheDenganTag('Chace_SosialisasiAdminDev');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = SosialisasiAdminDev::findOrFail($id);

        // Menghapus data
        $data->delete();

        HapusCacheDenganTag('Chace_SosialisasiAdminDev');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
