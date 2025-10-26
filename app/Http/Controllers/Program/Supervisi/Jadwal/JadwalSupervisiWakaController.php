<?php

namespace App\Http\Controllers\Program\Supervisi\Jadwal;

use App\Models\User;
use App\Models\Admin\Role;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Admin\RoleUser;
use App\Models\Learning\Emengajar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Supervisi\Jadwal\JadwalSupervisiWaka;

class JadwalSupervisiWakaController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Jadwal Supervisi';
        $breadcrumb = 'Program Supervisi  / Jadwal Supervisi Waka';
        $titleviewModal = 'Lihat Jadwal Supervisi';
        $titleeditModal = 'Edit Jadwal Supervisi';
        $titlecreateModal = 'Buat Jadwal Supervisi';
        $arr_ths = [
            'Tahun Pelajaran',
            'Jabatan',
            'Nama Guru',
            'Tanggal Pelaksanaan',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id

        $datas = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiWaka::where('tapel_id', $etapels->id)->get();
        // Ambil data berdasarkan tapel_id
        // Ambil data jadwal supervisi berdasarkan tapel_id
        $datas = JadwalSupervisiWaka::where('tapel_id', $etapels->id)->get();

        // Ambil data role yang sesuai
        $roles = Role::where('name', 'like', '%Waka%')->get();

        foreach ($roles as $role) {
            // Cek apakah data sudah ada di dalam JadwalSupervisiWaka berdasarkan tapel_id dan kategori
            $existingData = JadwalSupervisiWaka::where('tapel_id', $etapels->id)
                ->where('kategori', $role->name)
                ->first();

            // Jika data belum ada, maka buat data baru
            if (!$existingData) {
                // Cek RoleUser yang terhubung dengan role ini
                $RoleUsers = RoleUser::where('role_id', $role->id)->first();

                if ($RoleUsers) {
                    $User = User::find($RoleUsers->user_id); // Menggunakan find(), tanpa first()

                    if ($User) {
                        // Create data baru untuk JadwalSupervisiWaka
                        JadwalSupervisiWaka::create([
                            'tapel_id' => $etapels->id,
                            'kategori' => $role->name,
                            'detailguru_id' => $User->detailguru_id,
                            'tanggal_pelaksanaan' => null,  // Misalnya masih null
                            'keterangan' => null,  // Misalnya masih null
                        ]);
                    } else {
                        // dd('User tidak ditemukan untuk RoleUser ID: ' . $RoleUsers->user_id);
                    }
                } else {
                    // dd('RoleUser tidak ditemukan untuk Role ID: ' . $role->id);
                }
            } else {
                // Data sudah ada, tidak perlu ditambahkan lagi
                // Bisa tambahkan logika lain jika perlu (misalnya log atau notifikasi)
                // echo "Data sudah ada untuk kategori: " . $role->name . "<br>";
            }
        }


        // dd($datas);

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.program.supervisi.jadwal.jadwalsupervisiwaka.jadwal-supervisi-waka', compact(
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
        $title = 'Tambah Data Jadwal Supervisi';
        $breadcrumb = 'xxxxxxxxxxxx / Jadwal Supervisi';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.program.supervisi.jadwal.jadwalsupervisiwaka.jadwal-supervisi-waka-create', compact(
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
        \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiWaka::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Jadwal Supervisi';
        $breadcrumb = 'xxxxxxxxxxxx / Jadwal Supervisi';
        $data = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiWaka::findOrFail($id);

        return view('role.program.supervisi.jadwal.jadwalsupervisiwaka.jadwal-supervisi-waka-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Jadwal Supervisi';
        $breadcrumb = 'xxxxxxxxxxxx / Jadwal Supervisi / Edit';
        $data = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiWaka::findOrFail($id);

        return view('role.program.supervisi.jadwal.jadwalsupervisiwaka.jadwal-supervisi-waka-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        $data = JadwalSupervisiWaka::findOrFail($id);
        $data->update([
            'kategori' => $request->kategori,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
        ]);

        // INI YANG PERLU DIGANTI
        // return view('role.program.supervisi.jadwal.jadwalsupervisiwaka.jadwal-supervisi-waka', [...]);

        // GANTI DENGAN REDIRECT:
        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }


    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiWaka::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
