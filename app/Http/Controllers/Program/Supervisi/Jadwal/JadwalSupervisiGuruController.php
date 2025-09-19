<?php

namespace App\Http\Controllers\Program\Supervisi\Jadwal;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Learning\Emengajar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Supervisi\Jadwal\JadwalSupervisiGuru;

class JadwalSupervisiGuruController extends Controller
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
            'Nama Guru',
            'Mapel',
            'Kelas',
            'Pembelajaran',
            'ATP',
            'Modul Ajar',
            'Perangkat',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = Emengajar::where('tapel_id', $etapels->id)->get()
            ->groupBy('tingkat_id') // Kelompokkan berdasarkan tingkat_id
            ->map(function ($group) {
                return $group->unique('detailguru_id')->values(); // Hilangkan duplikat berdasarkan detailguru_id
            });

        // $datasJadwal = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiGuru::where('tapel_id', $etapels->id)->where('kelas_id', $datas->kelas_id)->where('mapel_id', $datas->mapel_id)->where('detailguru_id', $datas->detailguru_id)->get();
        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun

        return view('role.program.supervisi.jadwal.jadwalsupervisiguru.jadwal-supervisi-guru', compact(
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

    public function create(Request $request)
    {
        // Judul halaman
        $title = 'Tambah Data Program Supervisi Jadwal';
        $breadcrumb = 'xxxxxxxxxxxx / Program Supervisi Jadwal';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.program.supervisi.jadwal.jadwalsupervisiguru.jadwal-supervisi-guru-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {
// dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
        ]);

        $validator = Validator::make($request->all(), [
            'tapel_id' => 'integer',
            'semester' => 'string',
            'detailguru_id' => 'integer',
            'mapel_id' => 'integer',
            'kelas_id' => 'integer',
            'pembelajaran' => 'date',
            'modul_ajar' => 'date',
            'perangkat' => 'date',
            'atp' => 'date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $detailguru_id = $request->detailguru_id;
        $mapel_id = $request->mapel_id;
        $kelas_id = $request->kelas_id;
        $tapel_id = $request->tapel_id;
        $semester = $request->semester;

        $data = [
            'tapel_id' => $tapel_id,
            'semester' => $semester,
            'detailguru_id' => $detailguru_id,
            'mapel_id' => $mapel_id,
            'kelas_id' => $kelas_id,
        ];

        $items = [
            'Pelaksanaan Pembelajaran' => $request->pembelajaran,
            'Modul Ajar' => $request->modul_ajar,
            'Alur Tujuan Pembelajaran' => $request->atp,
            'Administrasi Pembelajaran' => $request->perangkat,
        ];

        foreach ($items as $kategori => $tanggal) {
            if (!$tanggal) continue;

            $criteria = [
                'tapel_id' => (int) $tapel_id,
                'semester' => (string) $semester,
                'detailguru_id' => (int) $detailguru_id,
                'mapel_id' => (int) $mapel_id,
                'kelas_id' => (int) $kelas_id,
                'kategori' => trim($kategori),
            ];

            $values = ['tanggal_pelaksanaan' => $tanggal];

            logger("Proses updateOrCreate:", $criteria + $values);

            \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiGuru::updateOrCreate(
                $criteria,
                $values
            );
        }

        // Session::flash('success', 'Data berhasil disimpan');
        // return Redirect::back();
    }


    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Program Supervisi Jadwal';
        $breadcrumb = 'xxxxxxxxxxxx / Program Supervisi Jadwal';
        $data = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiGuru::findOrFail($id);

        return view('role.program.supervisi.jadwal.jadwalsupervisiguru.jadwal-supervisi-guru-single', compact(
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
        $data = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiGuru::findOrFail($id);

        return view('role.program.supervisi.jadwal.jadwalsupervisiguru.jadwal-supervisi-guru-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiGuru::findOrFail($id);

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
        $data = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiGuru::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
