<?php

namespace App\Http\Controllers\Program\Supervisi\Jadwal;

use App\Models\Program\Supervisi\Jadwal\JadwalSupervisiLaboratorium;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Laboratorium\RiwayatLaboratorium;

class JadwalSupervisiLaboratoriumController extends Controller
{
    public function index()
{
    // Mendapatkan judul halaman sesuai dengan nama kelas
    $title = 'Program Supervisi Jadwal';
    $breadcrumb = 'xxxxxxxxxxxx / Program Supervisi Jadwal';
        $titleviewModal = 'Lihat Program Supervisi Jadwal';
        $titleeditModal = 'Edit Program Supervisi Jadwal';
        $titlecreateModal = 'Buat Program Supervisi Jadwal';
    $arr_ths = [
            'Nama Laboratorium',
            'Laboran',
            'Jadwal Pelaksanaan',
        ];

    // Mendapatkan data dari tabel Etapel yang sedang aktif
    $etapels = Etapel::where('aktiv', 'Y')->first();

    // Mengambil data dari model terkait dengan tapel_id
    $datas = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiLaboratorium::where('tapel_id', $etapels->id)->get();
    $datas = RiwayatLaboratorium::where('tapel_id', $etapels->id)->get();

    // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
    return view('role.program.supervisi.jadwal.jadwalsupervisilaboratorium.jadwal-supervisi-laboratorium', compact('title',
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
    $title = 'Tambah Data Program Supervisi Jadwal';
    $breadcrumb = 'xxxxxxxxxxxx / Program Supervisi Jadwal';

    // Breadcrumb (jika diperlukan)
    $breadcrumb = 'Tambah';

    return view('role.program.supervisi.jadwal.jadwalsupervisilaboratorium.jadwal-supervisi-laboratorium-create', compact(
        'title',
        'breadcrumb',
        ));
}

public function store(Request $request)
{
    // Validasi input
    // dd($request->all());
    // Menambahkan tapel_id ke request
    // Ambil Etapel aktif untuk mendapatkan tapel_id
    $etapels = Etapel::where('aktiv', 'Y')->first();
    if (!$etapels) {
        // Jika tidak ada Etapel yang aktif, kembalikan dengan pesan error
        return redirect()->back()->with('error', 'Tidak ada Etapel yang aktif.');
    }

    // Tambahkan tapel_id ke dalam request
    $request->merge(['tapel_id' => $etapels->id]);

    // Validasi input
    $validator = Validator::make($request->all(), [
        'tanggal_pelaksanaan' => 'required|date',
        'petugas_id' => 'required|integer',
        'laboratorium_id' => 'required|integer',
    ]);

    // Jika validasi gagal, kembalikan dengan pesan error
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Tentukan kondisi untuk mencari data
    $data = JadwalSupervisiLaboratorium::updateOrCreate(
        [
            'petugas_id' => $request->petugas_id,
            'laboratorium_id' => $request->laboratorium_id,
            'tapel_id' => $etapels->id,
        ],
        [
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
        ]
    );

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil disimpan atau diperbarui.');

    // Redirect kembali ke halaman sebelumnya
    return redirect()->route('jadwal-supervisi-laboratorium.index');
}
public function show($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Lihat Detail Program Supervisi Jadwal';
    $breadcrumb = 'xxxxxxxxxxxx / Program Supervisi Jadwal';
    $data = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiLaboratorium::findOrFail($id);

    return view('role.program.supervisi.jadwal.jadwalsupervisilaboratorium.jadwal-supervisi-laboratorium-single', compact(
        'title',
     'breadcrumb',
      'data',
      ));
}
public function edit($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Edit Program Supervisi Jadwal';
    $breadcrumb = 'xxxxxxxxxxxx / Program Supervisi Jadwal / Edit';
    $data = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiLaboratorium::findOrFail($id);

    return view('role.program.supervisi.jadwal.jadwalsupervisilaboratorium.jadwal-supervisi-laboratorium-edit', compact(
        'title',
        'breadcrumb',
        'data',
    ));
}

public function update(Request $request, $id)
{
    // Debugging: Cek semua input yang diterima
    dd($request->all());

    // Pastikan data tapel tersedia
    $etapels = \App\Models\Tapel::find(1); // Ganti dengan logika yang sesuai untuk $etapels

    // Jika $etapels tidak ditemukan, hentikan eksekusi
    if (!$etapels) {
        dd('Tapel not found');
    }

    // Menambahkan tapel_id ke request
    $request->merge(['tapel_id' => $etapels->id]);

    // Validasi input
    $validator = Validator::make($request->all(), [
        'tanggal_pelaksanaan' => 'date',
        'tapel_id' => 'integer',
        // Tambahkan validasi sesuai kebutuhan
    ]);

    // Jika validasi gagal, kembalikan dengan pesan error
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Update atau buat data berdasarkan ID dan data yang divalidasi
    $data = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiLaboratorium::updateOrCreate(
        ['id' => $id], // Kondisi pencarian data (berdasarkan ID)
        $validator->validated() // Data yang akan diupdate atau dibuat
    );

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil diperbarui');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}



public function destroy($id)
{
    // Menemukan data yang akan dihapus berdasarkan ID
    $data = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiLaboratorium::findOrFail($id);

    // Menghapus data
    $data->delete();

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil dihapus');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

}
