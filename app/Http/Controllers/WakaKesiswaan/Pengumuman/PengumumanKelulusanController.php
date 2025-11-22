<?php

namespace App\Http\Controllers\WakaKesiswaan\Pengumuman;

use Carbon\Carbon;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKesiswaan\Pengumuman\PengumumanKelulusan;

class PengumumanKelulusanController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'WakaKesiswaan Pengumuman';
        $breadcrumb = 'xxxxxxxxxxxx / WakaKesiswaan Pengumuman';
        $titleviewModal = 'Lihat WakaKesiswaan Pengumuman';
        $titleeditModal = 'Edit WakaKesiswaan Pengumuman';
        $titlecreateModal = 'Buat WakaKesiswaan Pengumuman';
        $arr_ths = [
            'xxxxxxxxxxxxxxxxxxx',
            'xxxxxxxxxxxxxxxxxxx',
            'xxxxxxxxxxxxxxxxxxx',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\WakaKesiswaan\Pengumuman\PengumumanKelulusan::where('tapel_id', $etapels->id)->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.wakakesiswaan.pengumuman.pengumumankelulusan.pengumuman-kelulusan', compact(
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
        $title = 'Tambah Data WakaKesiswaan Pengumuman';
        $breadcrumb = 'xxxxxxxxxxxx / WakaKesiswaan Pengumuman';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.wakakesiswaan.pengumuman.pengumumankelulusan.pengumuman-kelulusan-create', compact(
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
        \App\Models\WakaKesiswaan\Pengumuman\PengumumanKelulusan::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
    public function show($pengumuman_kelulusan)
    {
        $title = 'Lihat Detail WakaKesiswaan Pengumuman';
        $breadcrumb = 'xxxxxxxxxxxx / WakaKesiswaan Pengumuman';

        $data = PengumumanKelulusan::find($pengumuman_kelulusan);

        if (!$data) {
            return redirect()->route('pengumuman-kelulusan.index')->with('error', 'Pengumuman tidak ditemukan');
        }

        if (!$data->tanggal_pengumuman) {
            return redirect()->route('pengumuman-kelulusan.index')->with('error', 'Pengumuman belum ditentukan');
        }

        $tanggal_pengumuman = Carbon::parse($data->tanggal_pengumuman);
        $sekarang = Carbon::now();

        $show_pengumuman = $sekarang->greaterThanOrEqualTo($tanggal_pengumuman);

        return view('role.wakakesiswaan.pengumuman.pengumumankelulusan.pengumuman-kelulusan-single', compact(
            'title',
            'breadcrumb',
            'data',
            'show_pengumuman'
        ));
    }




    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit WakaKesiswaan Pengumuman';
        $breadcrumb = 'xxxxxxxxxxxx / WakaKesiswaan Pengumuman / Edit';
        $data = \App\Models\WakaKesiswaan\Pengumuman\PengumumanKelulusan::findOrFail($id);

        return view('role.wakakesiswaan.pengumuman.pengumumankelulusan.pengumuman-kelulusan-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\WakaKesiswaan\Pengumuman\PengumumanKelulusan::findOrFail($id);

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
        $data = \App\Models\WakaKesiswaan\Pengumuman\PengumumanKelulusan::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
