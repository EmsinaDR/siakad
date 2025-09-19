<?php

namespace App\Http\Controllers\Absensi;

use App\Models\Absensi\DataIjinDigital;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class DataIjinDigitalController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Absensi';
        $breadcrumb = 'Absensi / Data Ijin Digital';
        $titleviewModal = 'Lihat Absensi';
        $titleeditModal = 'Edit Absensi';
        $titlecreateModal = 'Buat Absensi';
        $arr_ths = [
            'Nama',
            'Kelas',
            'Ijin',
            'Keterangan',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        // $DataIjinDigital = Cache::tags(['DataIjinDigital_Chace'])->remember(
        //     'DataIjinDigital_Remember',
        //     now()->addMinute(10),
        //     fn() => DataIjinDigital::with('Siswa.KelasOne')->where('tapel_id', $etapels->id)->get()
        // );
        $DataIjinDigital = DataIjinDigital::with('Siswa.KelasOne')->where('tapel_id', $etapels->id)->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.absensi.dataijindigital.data-ijin-digital', compact(
            'title',
            'title',
            'arr_ths',
            'DataIjinDigital',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Absensi';
        $breadcrumb = 'Create Absensi / Data Ijin Digital';

        // Breadcrumb (jika diperlukan)

        return view('role.absensi.dataijindigital.data-ijin-digital-create', compact(
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
            'tapel_id' => 'required|numeric|min:1|max:100',
            'detailsiswa_id' => 'required|integer',
            'ijin' => 'required|string|min:3|max:255',
            'keterangan' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        DataIjinDigital::create($validator->validated());

        HapusCacheDenganTag('DataIjinDigital_Chace');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');
        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Absensi';
        $breadcrumb = 'Lihat Absensi / Data Ijin Digital';
        $data = DataIjinDigital::findOrFail($id);

        return view('role.absensi.dataijindigital.data-ijin-digital-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Absensi';
        $breadcrumb = 'xxxxxxxxxxxx / Absensi / Edit';
        $data = DataIjinDigital::findOrFail($id);


        return view('role.absensi.dataijindigital.data-ijin-digital-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = DataIjinDigital::findOrFail($id);

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


        HapusCacheDenganTag('DataIjinDigital_Chace');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = DataIjinDigital::findOrFail($id);

        // Menghapus data
        $data->delete();

        HapusCacheDenganTag('DataIjinDigital_Chace');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
