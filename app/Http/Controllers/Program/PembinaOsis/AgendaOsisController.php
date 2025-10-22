<?php

namespace App\Http\Controllers\Program\PembinaOsis;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Helpers\DataGuruHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Program\SetingPengguna;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\PembinaOsis\AgendaOsis;

class AgendaOsisController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Agenda Osis';
        $breadcrumb = 'Program Pembina Osis / Agenda Osis';
        $titleviewModal = 'Lihat Agenda Osis';
        $titleeditModal = 'Edit Agenda Osis';
        $titlecreateModal = 'Buat Agenda Osis';
        $arr_ths = [
            'Tanggal Pelaksanaan',
            'Nama Kegiatan',
            'Jumlah Peserta',
            'Lokasi Kegiatan',
            'Status Kegiatan',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $programs = SetingPengguna::whereJsonContains('detailguru_id', DataGuruHelper::GuruId())
            ->pluck('nama_program')
            ->toArray();
        // dd($programs, Auth::user()->detailguru_id);
        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Program\PembinaOsis\AgendaOsis::where('tapel_id', $etapels->id)->orderBy('tanggal_kegiatan', 'DESC')->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.program.pembinaosis.agendaosis.agenda-osis', compact(
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
        $title = 'Tambah Data Agenda Osis';
        $breadcrumb = 'xxxxxxxxxxxx / Agenda Osis';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.program.pembinaosis.agendaosis.agenda-osis-create', compact(
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
            'tapel_id' => ['nullable', 'exists:etapels,id'],
            'nama_kegiatan' => ['nullable', 'string', 'max:255'],
            'tanggal_kegiatan' => ['nullable', 'date'],
            'jumlah_peserta' => ['nullable'],
            'tujuan_kegiatan' => ['nullable', 'string', 'max:255'],
            'lokasi_kegiatan' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            // 'status_kegiatan' => ['required', 'in:Direncanakan,Berjalan,Selesai,Dibatalkan'],
            'dokumentasi_url' => ['nullable', 'url', 'max:255'],
        ]);
        // dd($validator, $request->all());

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        \App\Models\Program\PembinaOsis\AgendaOsis::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Agenda Osis';
        $breadcrumb = 'xxxxxxxxxxxx / Agenda Osis';
        $data = \App\Models\Program\PembinaOsis\AgendaOsis::findOrFail($id);

        return view('role.program.pembinaosis.agendaosis.agenda-osis-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Agenda Osis';
        $breadcrumb = 'xxxxxxxxxxxx / Agenda Osis / Edit';
        $data = \App\Models\Program\PembinaOsis\AgendaOsis::findOrFail($id);

        return view('role.program.pembinaosis.agendaosis.agenda-osis-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Program\PembinaOsis\AgendaOsis::findOrFail($id);

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
        $data = \App\Models\Program\PembinaOsis\AgendaOsis::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
