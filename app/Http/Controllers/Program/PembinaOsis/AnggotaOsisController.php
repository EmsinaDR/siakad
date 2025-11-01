<?php

namespace App\Http\Controllers\Program\PembinaOsis;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\PembinaOsis\AnggotaOsis;

class AnggotaOsisController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Anggota Osis';
        $breadcrumb = 'Pembina Osis / Anggota Osis';
        $titleviewModal = 'Lihat Anggota Osis';
        $titleeditModal = 'Edit Anggota Osis';
        $titlecreateModal = 'Buat Anggota Osis';
        $arr_ths = [
            'Nama Siswa',
            'Kelas',
            'Jabatan',
            'Tahun Masuk',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // ->where('tapel_id', $etapels->id)

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Program\PembinaOsis\AnggotaOsis::with(['Siswa'])->orderBy('tahun_masuk', 'DESC')->get();
        $datasAnggota = \App\Models\Program\PembinaOsis\AnggotaOsis::select('tahun_masuk', DB::raw('count(*) as total'))
            ->groupBy('tahun_masuk')
            ->orderBy('tahun_masuk', 'DESC')
            ->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.program.pembinaosis.anggotaosis.anggota-osis', compact(
            'title',
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'datasAnggota',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Anggota Osis';
        $breadcrumb = 'xxxxxxxxxxxx / Anggota Osis';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.program.pembinaosis.anggotaosis.anggota-osis-create', compact(
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
            'tapel_id' => 'integer',
            'Anggota' => 'string',
            'tahun_masuk' => 'numeric',
            'keterangan' => 'numeric',
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        foreach ($request->detailsiswa_id as $SiswaId) {
            $SaveData = AnggotaOsis::create([
                // 'tapel_id' => $request->tapel_id,
                'detailsiswa_id' => $SiswaId,
                'jabatan' => $request->jabatan,
                'tahun_masuk' => date('Y'),
                'keterangan' => Null,
            ]);
            // dd($SaveData);
        }
        // \App\Models\Program\PembinaOsis\AnggotaOsis::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Anggota Osis';
        $breadcrumb = 'xxxxxxxxxxxx / Anggota Osis';
        $data = \App\Models\Program\PembinaOsis\AnggotaOsis::findOrFail($id);

        return view('role.program.pembinaosis.anggotaosis.anggota-osis-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Anggota Osis';
        $breadcrumb = 'xxxxxxxxxxxx / Anggota Osis / Edit';
        $data = \App\Models\Program\PembinaOsis\AnggotaOsis::findOrFail($id);

        return view('role.program.pembinaosis.anggotaosis.anggota-osis-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Program\PembinaOsis\AnggotaOsis::findOrFail($id);

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
        $data = \App\Models\Program\PembinaOsis\AnggotaOsis::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
