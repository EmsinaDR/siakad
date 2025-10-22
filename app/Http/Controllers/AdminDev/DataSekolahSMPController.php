<?php

namespace App\Http\Controllers\AdminDev;

use App\Models\AdminDev\DataSekolahSMP;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;

class DataSekolahSMPController extends Controller
{
    public function index()
{
    // Mendapatkan judul halaman sesuai dengan nama kelas
    $title = 'AdminDev';
    $breadcrumb = 'AdminDev / Data Sekolah S M P';
        $titleviewModal = 'Lihat AdminDev';
        $titleeditModal = 'Edit AdminDev';
        $titlecreateModal = 'Buat AdminDev';
    $arr_ths = [
            'Ceklist',
'Tanggal Kunjungan',
'Nsm',
'Npsn',
'Akreditasi',
'Nama Sekolah',
'Alamat',
'Kecamatan',
'Kelurahan',
'Status',
'Siswa L',
'Siswa P',
'Nama Kepala',
'Nohp Kepala',
'Nama Operator',

        ];

    // Mendapatkan data dari tabel Etapel yang sedang aktif
    $etapels = Etapel::where('aktiv', 'Y')->first();

    // Mengambil data dari model terkait dengan tapel_id
    // addHours addMinutes
    $DataSekolahSMP = Cache::tags(['Chace_DataSekolahSMP'])->remember(
        'Remember_DataSekolahSMP',
        now()->addMinutes(30),
        fn () => DataSekolahSMP::where('tapel_id', $etapels->id)->get()
    );


    // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
    return view('admindev.datasekolahsmp.data-sekolah-smp', compact('title',
            'title',
            'arr_ths',
            'DataSekolahSMP',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
     ));
}

public function create()
{
    // Judul halaman
    $title = 'Tambah Data AdminDev';
    $breadcrumb = 'Create AdminDev / Data Sekolah S M P';

    // Breadcrumb (jika diperlukan)

    return view('admindev.datasekolahsmp.data-sekolah-smp-create', compact(
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
        'ceklist' => 'required|string|min:3|max:255',
'tanggal_kunjungan' => 'required|string|min:3|max:255',
'nsm' => 'required|string|min:3|max:255',
'npsn' => 'required|string|min:3|max:255',
'akreditasi' => 'required|string|min:3|max:255',
'nama_sekolah' => 'required|string|min:3|max:255',
'alamat' => 'required|string|min:3|max:255',
'kecamatan' => 'required|string|min:3|max:255',
'kelurahan' => 'required|string|min:3|max:255',
'status' => 'required|string|min:3|max:255',
'siswa_l' => 'required|string|min:3|max:255',
'siswa_p' => 'required|string|min:3|max:255',
'nama_kepala' => 'required|string|min:3|max:255',
'nohp_kepala' => 'required|string|min:3|max:255',
'nama_operator' => 'required|string|min:3|max:255',

    ]);

    // Jika validasi gagal, kembalikan dengan pesan error
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Membuat entri baru berdasarkan validasi
    DataSekolahSMP::create($validator->validated());

    HapusCacheDenganTag('Chace_DataSekolahSMP');
    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil disimpan');
    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function show($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Lihat Detail AdminDev';
    $breadcrumb = 'Lihat AdminDev / Data Sekolah S M P';
    $data = DataSekolahSMP::findOrFail($id);

    return view('admindev.datasekolahsmp.data-sekolah-smp-single', compact(
        'title',
     'breadcrumb',
      'data',
      ));
}
public function edit($id)
{
    // Menemukan data berdasarkan ID
    $title = 'Edit AdminDev';
    $breadcrumb = 'xxxxxxxxxxxx / AdminDev / Edit';
    $data = DataSekolahSMP::findOrFail($id);


    return view('admindev.datasekolahsmp.data-sekolah-smp-edit', compact(
        'title',
        'breadcrumb',
        'data',
    ));
}

public function update(Request $request, $id)
{
    // Menemukan data yang akan diupdate berdasarkan ID
    $data = DataSekolahSMP::findOrFail($id);

    // Validasi input
    $validator = Validator::make($request->all(), [
        // Tambahkan validasi sesuai kebutuhan
        'tapel_id' => 'required|numeric|min:1|max:100',
        'ceklist' => 'required|string|min:3|max:255',
'tanggal_kunjungan' => 'required|string|min:3|max:255',
'nsm' => 'required|string|min:3|max:255',
'npsn' => 'required|string|min:3|max:255',
'akreditasi' => 'required|string|min:3|max:255',
'nama_sekolah' => 'required|string|min:3|max:255',
'alamat' => 'required|string|min:3|max:255',
'kecamatan' => 'required|string|min:3|max:255',
'kelurahan' => 'required|string|min:3|max:255',
'status' => 'required|string|min:3|max:255',
'siswa_l' => 'required|string|min:3|max:255',
'siswa_p' => 'required|string|min:3|max:255',
'nama_kepala' => 'required|string|min:3|max:255',
'nohp_kepala' => 'required|string|min:3|max:255',
'nama_operator' => 'required|string|min:3|max:255',

    ]);

    // Jika validasi gagal, kembalikan dengan pesan error
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Update data yang ditemukan berdasarkan hasil validasi
    $data->update($validator->validated());


    HapusCacheDenganTag('Chace_DataSekolahSMP');
    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil diperbarui');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

public function destroy($id)
{
    // Menemukan data yang akan dihapus berdasarkan ID
    $data = DataSekolahSMP::findOrFail($id);

    // Menghapus data
    $data->delete();

    HapusCacheDenganTag('Chace_DataSekolahSMP');

    // Menyimpan pesan sukses di session
    Session::flash('success', 'Data berhasil dihapus');

    // Mengarahkan kembali ke halaman sebelumnya
    return Redirect::back();
}

}
