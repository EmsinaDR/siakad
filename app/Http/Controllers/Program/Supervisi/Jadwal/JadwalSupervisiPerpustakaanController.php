<?php

namespace App\Http\Controllers\Program\Supervisi\Jadwal;

use App\Models\Program\Supervisi\Jadwal\JadwalSupervisiPerpustakaan;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use App\Models\Program\SetingPengguna;
use App\Models\User\Guru\Detailguru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class JadwalSupervisiPerpustakaanController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Jadwal Supervisi Perpustakaan';
        $breadcrumb = 'Program Supervisi / Jadwal Supervisi Perpustakaan';
        $titleviewModal = 'Lihat Jadwal Supervisi Perpustakaan';
        $titleeditModal = 'Edit Jadwal Supervisi Perpustakaan';
        $titlecreateModal = 'Buat Jadwal Supervisi Perpustakaan';
        $arr_ths = [
            'xxxxxxxxxxxxxxxxxxx',
            'xxxxxxxxxxxxxxxxxxx',
            'xxxxxxxxxxxxxxxxxxx',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiPerpustakaan::where('tapel_id', $etapels->id)->get();
        $DataProgram = SetingPengguna::where('nama_program', 'Petugas Perpustakaan')->first();

        // dd($DataProgram);
        if (!$DataProgram) {
            return back()->with('error', 'Data Program tidak ditemukan');
        }

        $petugasIds = json_decode($DataProgram->detailguru_id ?? '[]');



        // Ambil data guru sekaligus, biar lebih efisien
        $petugas = Detailguru::whereIn('id', $petugasIds)->get()->keyBy('id');


        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.program.supervisi.jadwal.jadwalsupervisiperpustakaan.jadwal-supervisi-perpustakaan', compact(
            'title',
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DataProgram',
            'petugasIds',
            'petugas',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Jadwal Supervisi Perpustakaan';
        $breadcrumb = 'Program Supervisi / Jadwal Supervisi Perpustakaan';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.program.supervisi.jadwal.jadwalsupervisiperpustakaan.jadwal-supervisi-perpustakaan-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'petugas_id' => 'integer',
        ]);

        // Ambil data tapel_id yang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Menambahkan tapel_id ke request
        $request->merge(['tapel_id' => $etapels->id]);

        // Update or Create berdasarkan petugas_id dan tapel_id
        $jadwal = JadwalSupervisiPerpustakaan::updateOrCreate(
            [
                'tapel_id' => $etapels->id, // Kondisi untuk pencarian
                'petugas_id' => $request->petugas_id, // Misalnya, menggunakan petugas_id untuk mencari
            ],
            [
                'nama_guru' => $request->nama_guru, // Data yang ingin diupdate atau dibuat
                'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            ]
        );

        // Kembali ke halaman jadwal dengan pesan sukses
        return redirect()->route('jadwal-supervisi-perpustakaan.index')->with('success', 'Jadwal berhasil disimpan atau diperbarui');
    }

    public function update(Request $request, $id)
    {
        // Mengambil data tapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Pastikan ada data tapel yang aktif
        if (!$etapels) {
            return back()->with('error', 'Data Tapel tidak ditemukan');
        }

        // Merge tapel_id ke dalam request
        $request->merge(['tapel_id' => $etapels->id]);

        // Validasi input
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'tapel_id' => 'required|exists:etapels,id', // Validasi tapel_id
        ]);

        // Mencari data untuk diupdate berdasarkan id dan tapel_id
        $jadwal = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiPerpustakaan::where('id', $id)
            ->where('tapel_id', $request->tapel_id) // Pastikan sesuai dengan tapel_id yang diberikan
            ->firstOrFail(); // Jika tidak ditemukan, akan error 404

        // Update data jadwal
        $jadwal->update([
            'nama_guru' => $request->nama_guru,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            // Update data lainnya jika diperlukan
        ]);

        return redirect()->route('jadwal-supervisi-perpustakaan.index')->with('success', 'Jadwal Supervisi Perpustakaan berhasil diperbarui');
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Jadwal Supervisi Perpustakaan';
        $breadcrumb = 'Program Supervisi / Jadwal Supervisi Perpustakaan';
        $data = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiPerpustakaan::findOrFail($id);

        return view('role.program.supervisi.jadwal.jadwalsupervisiperpustakaan.jadwal-supervisi-perpustakaan-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Jadwal Supervisi Perpustakaan';
        $breadcrumb = 'Program Supervisi / Jadwal Supervisi Perpustakaan / Edit';
        $data = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiPerpustakaan::findOrFail($id);

        return view('role.program.supervisi.jadwal.jadwalsupervisiperpustakaan.jadwal-supervisi-perpustakaan-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }


    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiPerpustakaan::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
