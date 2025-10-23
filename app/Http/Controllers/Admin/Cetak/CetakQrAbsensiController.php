<?php

namespace App\Http\Controllers\Admin\Cetak;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Cache;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Cetak\CetakQrAbsensi;

class CetakQrAbsensiController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Admin Cetak';
        $breadcrumb = 'xxxxxxxxxxxx / Admin Cetak';
        $titleviewModal = 'Lihat Admin Cetak';
        $titleeditModal = 'Edit Admin Cetak';
        $titlecreateModal = 'Buat Admin Cetak';
        $arr_ths = [
            'xxxxxxxxxxxxxxxxxxx',
            'xxxxxxxxxxxxxxxxxxx',
            'xxxxxxxxxxxxxxxxxxx',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Admin\Cetak\CetakQrAbsensi::where('tapel_id', $etapels->id)->get();
        $datas = \App\Models\Admin\Cetak\CetakQrAbsensi::groupby('tapel')->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.admin.cetak.cetakqrabsensi.cetak-qr-absensi', compact(
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
        $title = 'Tambah Data Admin Cetak';
        $breadcrumb = 'xxxxxxxxxxxx / Admin Cetak';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.admin.cetak.cetakqrabsensi.cetak-qr-absensi-create', compact(
            'title',
            'breadcrumb',
        ));
    }
    public function CetakGuru()
    {
        // Judul halaman
        $title = 'Tambah Data Admin Cetak';
        $breadcrumb = 'xxxxxxxxxxxx / Admin Cetak';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';
        $QrGuru = Detailguru::whereNotIn('id', [1,2,3])->get();
        return view('role.admin.cetak.cetakqrabsensi.cetak-guru', compact(
            'title',
            'breadcrumb',
            'QrGuru',
        ));
    }
    public function CetakSiswa()
    {
        // Judul halaman
        $title = 'Tambah Data Admin Cetak';
        $breadcrumb = 'xxxxxxxxxxxx / Admin Cetak';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';
        // HapusCacheDenganTag('cache_QrSiswa');
        // HapusFile('img/qrcode/siswa');


        // $QrSiswax = Detailsiswa::whereNotNull('kelas_id')->orderBy('kelas_id', 'ASC')->get();
        $QrSiswa = Cache::tags(['cache_QrSiswa'])->remember('remember_QrSiswa', now()->addHours(2), function () {
            return Detailsiswa::whereNotNull('kelas_id')->orderBy('kelas_id', 'ASC')->get();
        });
        // dd($QrSiswa);
        // foreach($QrSiswa as $ButaQr){
        //     generateQrSiswa($ButaQr->nis);
        // }

        return view('role.admin.cetak.cetakqrabsensi.cetak-siswa', compact(
            'title',
            'breadcrumb',
            'QrSiswa',
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
        \App\Models\Admin\Cetak\CetakQrAbsensi::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Admin Cetak';
        $breadcrumb = 'xxxxxxxxxxxx / Admin Cetak';
        $data = \App\Models\Admin\Cetak\CetakQrAbsensi::findOrFail($id);

        return view('role.admin.cetak.cetakqrabsensi.cetak-qr-absensi-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Admin Cetak';
        $breadcrumb = 'xxxxxxxxxxxx / Admin Cetak / Edit';
        $data = \App\Models\Admin\Cetak\CetakQrAbsensi::findOrFail($id);

        return view('role.admin.cetak.cetakqrabsensi.cetak-qr-absensi-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Admin\Cetak\CetakQrAbsensi::findOrFail($id);

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
        $data = \App\Models\Admin\Cetak\CetakQrAbsensi::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
