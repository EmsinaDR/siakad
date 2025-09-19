<?php

namespace App\Http\Controllers\AdminDev;

use App\Models\AdminDev\ProgresAplikasi;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class ProgresAplikasiController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'AdminDev';
        $breadcrumb = 'xxxxxxxxxxxx / AdminDev';
        $titleviewModal = 'Lihat AdminDev';
        $titleeditModal = 'Edit AdminDev';
        $titlecreateModal = 'Buat AdminDev';
        $arr_ths = [
            'Judul',
            'Role',
            'Fitur',
            'Model',
            'Tanggal Mulai',
            'Tanggal Akhir',
            'Persentase',
            'Keterangan',
            'Html',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\AdminDev\ProgresAplikasi::orderBy('judul', 'ASC')->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.admindev.progresaplikasi.progres-aplikasi', compact(
            'title',
            'title',
            'arr_ths',
            'datas',
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
        $breadcrumb = 'xxxxxxxxxxxx / AdminDev';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.admindev.progresaplikasi.progres-aplikasi-create', compact(
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
        \App\Models\AdminDev\ProgresAplikasi::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail AdminDev';
        $breadcrumb = 'xxxxxxxxxxxx / AdminDev';
        $data = \App\Models\AdminDev\ProgresAplikasi::findOrFail($id);

        return view('role.admindev.progresaplikasi.progres-aplikasi-single', compact(
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
        $data = \App\Models\AdminDev\ProgresAplikasi::findOrFail($id);

        return view('role.admindev.progresaplikasi.progres-aplikasi-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\AdminDev\ProgresAplikasi::findOrFail($id);

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

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = \App\Models\AdminDev\ProgresAplikasi::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
    public function CopyData($id)
    {
        // dd($id);
        //dd($request->all());
        $data = \App\Models\AdminDev\ProgresAplikasi::findOrFail($id);
        \App\Models\AdminDev\ProgresAplikasi::create(
            [
                'judul' => $data->judul,
                'role' => $data->role,
                'fitur' => $data->fitur,
                'model_class' => 'xxxxxxxxx',
                'tanggal_mulai' => now(),
                'tanggal_akhir' => now()->addDay(1),
                'persentase' => 0,
                'keterangan' => '-',
            ]
        );
        Session::flash('success','Data Berhasil Disimpan');
        return Redirect::back();
    }
}
