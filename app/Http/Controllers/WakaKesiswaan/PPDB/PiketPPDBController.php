<?php

namespace App\Http\Controllers\WakaKesiswaan\PPDB;

use App\Models\WakaKesiswaan\PPDB\PiketPPDB;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class PiketPPDBController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Data Piket PPDB';
        $breadcrumb = 'Waka Kesiswaan PPDB / Data Piket PPDB';
        $titleviewModal = 'Lihat Data Piket PPDB';
        $titleeditModal = 'Edit Data Piket PPDB';
        $titlecreateModal = 'Buat Data Piket PPDB';
        $arr_ths = [
            'Hari',
            'Guru',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\WakaKesiswaan\PPDB\PiketPPDB::where('tapel_id', $etapels->id)
            ->orderByRaw("
                    CASE hari
                        WHEN 'Senin' THEN 1
                        WHEN 'Selasa' THEN 2
                        WHEN 'Rabu' THEN 3
                        WHEN 'Kamis' THEN 4
                        WHEN 'Jumat' THEN 5
                        WHEN 'Sabtu' THEN 6
                        WHEN 'Minggu' THEN 7
                        ELSE 8
                    END
                ")
            ->get();



        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.wakakesiswaan.ppdb.piketppdb.piket-ppdb', compact(
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
        $title = 'Tambah Data Data Piket PPDB';
        $breadcrumb = 'xxxxxxxxxxxx / Data Piket PPDB';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.wakakesiswaan.ppdb.piketppdb.piket-ppdb-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {
        // Mendapatkan data Etapel yang aktif
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge(['tapel_id' => $etapels->id]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'tapel_id' => 'integer',
            'hari' => 'string',
            'detailguru_id' => 'array',
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $CekHari = PiketPPDB::where('tapel_id', $request->tapel_id)->where('hari', $request->hari)->count();
        if ($CekHari > 0) {
            Session::flash('error', 'Data hari sudah ada');
            // Mengarahkan kembali ke halaman sebelumnya
            return Redirect::back();
        }
        // Membuat entri baru berdasarkan validasi
        \App\Models\WakaKesiswaan\PPDB\PiketPPDB::create([
            'tapel_id' => $request->tapel_id,
            'hari' => $request->hari,
            'detailguru_id' => json_encode($request->detailguru_id),
        ]);

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Data Piket PPDB';
        $breadcrumb = 'xxxxxxxxxxxx / Data Piket PPDB';
        $data = \App\Models\WakaKesiswaan\PPDB\PiketPPDB::findOrFail($id);

        return view('role.wakakesiswaan.ppdb.piketppdb.piket-ppdb-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Data Piket PPDB';
        $breadcrumb = 'xxxxxxxxxxxx / Data Piket PPDB / Edit';
        $data = \App\Models\WakaKesiswaan\PPDB\PiketPPDB::findOrFail($id);

        return view('role.wakakesiswaan.ppdb.piketppdb.piket-ppdb-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\WakaKesiswaan\PPDB\PiketPPDB::findOrFail($id);

        // dd($request->all(), $data);
        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'hari' => 'string',
            'detailguru_id' => 'array',
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
        $data = \App\Models\WakaKesiswaan\PPDB\PiketPPDB::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
