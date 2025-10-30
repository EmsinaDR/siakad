<?php

namespace App\Http\Controllers\Program\PembinaOsis;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\PembinaOsis\PendaftaranOsis;

class PendaftaranOsisController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Program PembinaOsis';
        $breadcrumb = 'xxxxxxxxxxxx / Program PembinaOsis';
        $titleviewModal = 'Lihat Program PembinaOsis';
        $titleeditModal = 'Edit Program PembinaOsis';
        $titlecreateModal = 'Buat Program PembinaOsis';
        $arr_ths = [
            'Tahun Pelajaran',
            'Nama Siswa',
            'Kelas',
            'Validasi',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Program\PembinaOsis\PendaftaranOsis::with('Siswa')->where('validasi', '!=', 'Disetujui')->orWhereNull('validasi')->orderBy('tapel_id', 'DESC')->get();
        // $datas = \App\Models\Program\PembinaOsis\PendaftaranOsis::with('Siswa')->get();
        $jumlahPerTapel = \App\Models\Program\PembinaOsis\PendaftaranOsis::orderBy('tapel_id', 'DESC')->select('tapel_id', DB::raw('count(*) as total'))
            ->groupBy('tapel_id')

            ->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.program.pembinaosis.pendaftaranosis.pendaftaran-osis', compact(
            'title',
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'jumlahPerTapel',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Program PembinaOsis';
        $breadcrumb = 'xxxxxxxxxxxx / Program PembinaOsis';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.program.pembinaosis.pendaftaranosis.pendaftaran-osis-create', compact(
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
            'tapel_id' => 'nullable|integer|exists:etapels,id',
            'validasi' => 'nullable|string|max:255',
            'detailsiswa_id' => 'nullable|integer|exists:detailsiswas,id',
            'tujuan' => 'nullable|string|max:255',
            'moto_hidup' => 'nullable|string|max:255',
            'visi' => 'nullable|string|max:255',
            'misi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        \App\Models\Program\PembinaOsis\PendaftaranOsis::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Program PembinaOsis';
        $breadcrumb = 'xxxxxxxxxxxx / Program PembinaOsis';
        $data = \App\Models\Program\PembinaOsis\PendaftaranOsis::findOrFail($id);

        return view('role.program.pembinaosis.pendaftaranosis.pendaftaran-osis-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Program PembinaOsis';
        $breadcrumb = 'xxxxxxxxxxxx / Program PembinaOsis / Edit';
        $data = \App\Models\Program\PembinaOsis\PendaftaranOsis::findOrFail($id);

        return view('role.program.pembinaosis.pendaftaranosis.pendaftaran-osis-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Program\PembinaOsis\PendaftaranOsis::findOrFail($id);

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
        $data = \App\Models\Program\PembinaOsis\PendaftaranOsis::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
