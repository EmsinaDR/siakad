<?php

namespace App\Http\Controllers\Program\DataTestter;

use App\Models\Program\DataTestter\DataTestered;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class DataTesteredController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Program DataTestter';
        $breadcrumb = 'xxxxxxxxxxxx / Program DataTestter';
        $titleviewModal = 'Lihat Program DataTestter';
        $titleeditModal = 'Edit Program DataTestter';
        $titlecreateModal = 'Buat Program DataTestter';
        $arr_ths = [
            'Hari dan Tanggal',
            'Jam',
            'NIS',
            'Nama',
            'Kelas',
            'Absen'
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Program\DataTestter\DataTestered::where('tapel_id', $etapels->id)->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.program.datatestter.datatestered.data-testered', compact(
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
        $title = 'Tambah Data Program DataTestter';
        $breadcrumb = 'xxxxxxxxxxxx / Program DataTestter';

        return view('role.program.datatestter.datatestered.data-testered-create', compact(
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
        \App\Models\Program\DataTestter\DataTestered::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Program DataTestter';
        $breadcrumb = 'xxxxxxxxxxxx / Program DataTestter';
        $data = \App\Models\Program\DataTestter\DataTestered::findOrFail($id);

        // Judul halaman
        $title = 'Detail DataTesteredController';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Detail';

        return view('role.program.datatestter.datatestered.data-testered-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Program DataTestter';
        $breadcrumb = 'xxxxxxxxxxxx / Program DataTestter / Edit';
        $data = \App\Models\Program\DataTestter\DataTestered::findOrFail($id);

        // Judul halaman
        $title = 'Edit DataTesteredController';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Edit';

        return view('role.program.datatestter.datatestered.data-testered-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Program\DataTestter\DataTestered::findOrFail($id);

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
        $data = \App\Models\Program\DataTestter\DataTestered::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
