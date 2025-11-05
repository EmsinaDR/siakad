<?php

namespace App\Http\Controllers\Program\Eijazah;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Eijazah\EIjazahSiswa;
use App\Models\WakaKurikulum\Elearning\Nilai\KurulumDataPesertaUjian;

class EIjazahSiswaController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Program Eijazah';
        $breadcrumb = 'xxxxxxxxxxxx / Program Eijazah';
        $titleviewModal = 'Lihat Program Eijazah';
        $titleeditModal = 'Edit Program Eijazah';
        $titlecreateModal = 'Buat Program Eijazah';
        $arr_ths = [
            'Nama Siswa',
            'xxxxxxxxxxxxxxxxxxx',
            'xxxxxxxxxxxxxxxxxxx',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Program\Eijazah\EIjazahSiswa::where('tapel_id', $etapels->id)->get();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $DataPesertaUjian = KurulumDataPesertaUjian::where('tapel_id', $etapels->id)->orderBy('kelas_id', 'ASC')->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.program.eijazah.eijazahsiswa.eijazah-siswa', compact(
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
        $title = 'Tambah Data Program Eijazah';
        $breadcrumb = 'xxxxxxxxxxxx / Program Eijazah';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.program.eijazah.eijazahsiswa.eijazah-siswa-create', compact(
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
        \App\Models\Program\Eijazah\EIjazahSiswa::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Program Eijazah';
        $breadcrumb = 'xxxxxxxxxxxx / Program Eijazah';
        $data = \App\Models\Program\Eijazah\EIjazahSiswa::findOrFail($id);

        return view('role.program.eijazah.eijazahsiswa.eijazah-siswa-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Program Eijazah';
        $breadcrumb = 'xxxxxxxxxxxx / Program Eijazah / Edit';
        $data = \App\Models\Program\Eijazah\EIjazahSiswa::findOrFail($id);

        return view('role.program.eijazah.eijazahsiswa.eijazah-siswa-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Program\Eijazah\EIjazahSiswa::findOrFail($id);

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
        $data = \App\Models\Program\Eijazah\EIjazahSiswa::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
