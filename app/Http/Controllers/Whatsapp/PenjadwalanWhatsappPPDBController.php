<?php

namespace App\Http\Controllers\Whatsapp;

use App\Models\Whatsapp\PenjadwalanWhatsappPPDB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;

class PenjadwalanWhatsappPPDBController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Whatsapp';
        $breadcrumb = 'Whatsapp / Penjadwalan Whatsapp PPDB';
        $titleviewModal = 'Lihat Whatsapp';
        $titleeditModal = 'Edit Whatsapp';
        $titlecreateModal = 'Buat Whatsapp';
        $arr_ths = [
            'Judul',
            'Pesan',
            'Scheduled At',

        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $PenjadwalanWhatsappPPDB = Cache::tags(['PenjadwalanWhatsappPPDB_Chace'])->remember(
            'PenjadwalanWhatsappPPDB_Remember',
            now()->addHours(2),
            fn() => PenjadwalanWhatsappPPDB::get()
        );


        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.whatsapp.penjadwalanwhatsappppdb.penjadwalan-whatsapp-ppdb', compact(
            'title',
            'title',
            'arr_ths',
            'PenjadwalanWhatsappPPDB',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Whatsapp';
        $breadcrumb = 'Create Whatsapp / Penjadwalan Whatsapp P P D B';

        // Breadcrumb (jika diperlukan)

        return view('role.whatsapp.penjadwalanwhatsappppdb.penjadwalan-whatsapp-ppdb-create', compact(
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
            'pesan' => 'required|string|min:3|max:255',
            'scheduled_at' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        PenjadwalanWhatsappPPDB::create($validator->validated());

        HapusCacheDenganTag('PenjadwalanWhatsappPPDB_Chace');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');
        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Whatsapp';
        $breadcrumb = 'Lihat Whatsapp / Penjadwalan Whatsapp P P D B';
        $data = PenjadwalanWhatsappPPDB::findOrFail($id);

        return view('role.whatsapp.penjadwalanwhatsappppdb.penjadwalan-whatsapp-ppdb-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Whatsapp';
        $breadcrumb = 'xxxxxxxxxxxx / Whatsapp / Edit';
        $data = PenjadwalanWhatsappPPDB::findOrFail($id);


        return view('role.whatsapp.penjadwalanwhatsappppdb.penjadwalan-whatsapp-ppdb-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = PenjadwalanWhatsappPPDB::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'tapel_id' => 'required|numeric|min:1|max:100',
            'judul' => 'required|string|min:3|max:255',
            'pesan' => 'required|string|min:3|max:255',
            'scheduled_at' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data yang ditemukan berdasarkan hasil validasi
        $data->update($validator->validated());


        HapusCacheDenganTag('PenjadwalanWhatsappPPDB_Chace');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = PenjadwalanWhatsappPPDB::findOrFail($id);

        // Menghapus data
        $data->delete();

        HapusCacheDenganTag('PenjadwalanWhatsappPPDB_Chace');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
