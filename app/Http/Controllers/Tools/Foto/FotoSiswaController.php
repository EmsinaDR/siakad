<?php

namespace App\Http\Controllers\Tools\Foto;


use Illuminate\Support\Facades\File;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tools\Foto\FotoSiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FotoSiswaController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Tools Foto';
        $breadcrumb = 'Foto Digital / Foto Siswa';
        $titleviewModal = 'Lihat Tools Foto';
        $titleeditModal = 'Edit Tools Foto';
        $titlecreateModal = 'Buat Tools Foto';
        $arr_ths = [
            'Nama Siswa',
            'NIS',
            'Kelas',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Tools\Foto\FotoSiswa::WhereNotNull('kelas_id')->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.tools.foto.fotosiswa.foto-siswa', compact(
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
        $title = 'Tambah Data Tools Foto';
        $breadcrumb = 'xxxxxxxxxxxx / Tools Foto';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.tools.foto.fotosiswa.foto-siswa-create', compact(
            'title',
            'breadcrumb',
        ));
    }
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'foto' => 'required',
    //         'nis' => 'required',
    //     ]);

    //     // Tangkap base64
    //     $foto = $request->input('foto');

    //     // Bersihkan header base64
    //     $foto = str_replace('data:image/png;base64,', '', $foto);
    //     $foto = str_replace(' ', '+', $foto);

    //     // Decode ke binary
    //     $fotoBinary = base64_decode($foto);

    //     // Buat nama file unik
    //     $filename = $request->nis.'.png';

    //     // Pastikan foldernya ada
    //     $path = public_path('img/siswa');
    //     if (!File::exists($path)) {
    //         File::makeDirectory($path, 0755, true); // Bikin folder kalau belum ada
    //     }

    //     // Simpan file langsung ke public/img/siswa/
    //     file_put_contents($path . '/' . $filename, $fotoBinary);

    //     return response()->json([
    //         'message' => 'Foto siswa berhasil diunggah!',
    //         'filename' => $filename,
    //     ]);
    // }
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required',
            'nis' => 'required',
            'ukuran' => 'required', // <--- Tambahkan validasi ukuran
        ]);

        $foto = $request->input('foto');
        $nis = $request->input('nis');
        $ukuran = $request->input('ukuran');

        // Bersihkan base64 header
        if (strpos($foto, 'data:image/png;base64,') === 0) {
            $foto = substr($foto, strlen('data:image/png;base64,'));
        }

        $foto = str_replace(' ', '+', $foto); // Ganti spasi jadi +
        $fotoBinary = base64_decode($foto);

        if ($fotoBinary === false) {
            return response()->json([
                'message' => 'Gagal decode base64',
            ], 400);
        }

        // Pastikan folder public/img/siswa ada
        $path = public_path('img/siswa');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        // Buat nama file: nis-ukuran.png
        $filename = $nis . '-' . $ukuran . '.png';

        // Simpan file
        $fullPath = $path . '/' . $filename;
        $saved = file_put_contents($fullPath, $fotoBinary);

        if (!$saved) {
            return response()->json([
                'message' => 'Gagal simpan file ke server',
            ], 500);
        }

        return response()->json([
            'message' => 'Foto siswa berhasil diunggah!',
            'filename' => $filename,
            'path' => asset('img/siswa/' . $filename), // Biar link bisa langsung diakses browser
        ]);
    }

    public function storex(Request $request)
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
        \App\Models\Tools\Foto\FotoSiswa::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Tools Foto';
        $breadcrumb = 'xxxxxxxxxxxx / Tools Foto';
        $data = \App\Models\Tools\Foto\FotoSiswa::findOrFail($id);

        return view('role.tools.foto.fotosiswa.foto-siswa-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Tools Foto';
        $breadcrumb = 'xxxxxxxxxxxx / Tools Foto / Edit';
        $data = \App\Models\Tools\Foto\FotoSiswa::findOrFail($id);

        return view('role.tools.foto.fotosiswa.foto-siswa-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Tools\Foto\FotoSiswa::findOrFail($id);

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
        $data = \App\Models\Tools\Foto\FotoSiswa::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
