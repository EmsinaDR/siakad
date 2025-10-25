<?php

namespace App\Http\Controllers\WakaKesiswaan\PPDB;

use Exception;
use Carbon\Carbon;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKesiswaan\PPDB\DataSiswaTarget;

class DataSiswaTargetController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Whatsapp';
        $breadcrumb = 'Whatsapp / Data Siswa Target';
        $titleviewModal = 'Lihat Whatsapp';
        $titleeditModal = 'Edit Whatsapp';
        $titlecreateModal = 'Buat Whatsapp';
        $arr_ths = [
            'Nama Siswa',
            'No Hp',
            'Asal Sd',
            'Keterangan',

        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $DataSiswaTarget = Cache::tags(['DataSiswaTarget_Chace'])->remember(
            'DataSiswaTarget_Remember',
            now()->addHours(2),
            fn() => DataSiswaTarget::where('tapel_id', $etapels->id)->get()
        );


        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.whatsapp.datasiswatarget.data-siswa-target', compact(
            'title',
            'title',
            'arr_ths',
            'DataSiswaTarget',
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
        $breadcrumb = 'Create Whatsapp / Data Siswa Target';

        // Breadcrumb (jika diperlukan)

        return view('role.whatsapp.datasiswatarget.data-siswa-target-create', compact(
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
            'nama_siswa' => 'required|string|min:3|max:255',
            'no_hp' => 'required|string|min:3|max:255',
            'asal_sd' => 'required|string|min:3|max:255',
            'keterangan' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        DataSiswaTarget::create($validator->validated());

        HapusCacheDenganTag('DataSiswaTarget_Chace');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');
        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Whatsapp';
        $breadcrumb = 'Lihat Whatsapp / Data Siswa Target';
        $data = DataSiswaTarget::findOrFail($id);

        return view('role.whatsapp.datasiswatarget.data-siswa-target-single', compact(
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
        $data = DataSiswaTarget::findOrFail($id);


        return view('role.whatsapp.datasiswatarget.data-siswa-target-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = DataSiswaTarget::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'tapel_id' => 'required|numeric|min:1|max:100',
            'nama_siswa' => 'required|string|min:3|max:255',
            'no_hp' => 'required|string|min:3|max:255',
            'asal_sd' => 'required|string|min:3|max:255',
            'keterangan' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data yang ditemukan berdasarkan hasil validasi
        $data->update($validator->validated());


        HapusCacheDenganTag('DataSiswaTarget_Chace');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = DataSiswaTarget::findOrFail($id);

        // Menghapus data
        $data->delete();

        HapusCacheDenganTag('DataSiswaTarget_Chace');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
