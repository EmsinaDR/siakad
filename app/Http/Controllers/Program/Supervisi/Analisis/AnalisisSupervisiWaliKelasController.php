<?php

namespace App\Http\Controllers\Program\Supervisi\Analisis;

use App\Models\Program\Supervisi\Analisis\AnalisisSupervisiWaliKelas;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AnalisisSupervisiWaliKelasController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Program Supervisi Analisis';
        $breadcrumb = 'xxxxxxxxxxxx / Program Supervisi Analisis';
        $titleviewModal = 'Lihat Program Supervisi Analisis';
        $titleeditModal = 'Edit Program Supervisi Analisis';
        $titlecreateModal = 'Buat Program Supervisi Analisis';
        $arr_ths = [
            'xxxxxxxxxxxxxxxxxxx',
            'xxxxxxxxxxxxxxxxxxx',
            'xxxxxxxxxxxxxxxxxxx',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Program\Supervisi\Analisis\AnalisisSupervisiWaliKelas::where('tapel_id', $etapels->id)->where('nilai', '<=', 2)->groupBy('indikator_id')->get();

        $datas = AnalisisSupervisiWaliKelas::with(['indikator', 'kelas'])
            ->where('tapel_id', $etapels->id)
            ->where('nilai', '<=', 2)
            ->get()
            ->groupBy('indikator_id');
        $datasx = AnalisisSupervisiWaliKelas::with(['indikator', 'kelas'])
            ->where('tapel_id', $etapels->id)
            ->get()
            ->groupBy('indikator_id');

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.program.supervisi.analisis.analisissupervisiwalikelas.analisis-supervisi-wali-kelas', compact(
            'title',
            'title',
            'arr_ths',
            'datas',
            'datasx',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            // 'daftarKelas',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Program Supervisi Analisis';
        $breadcrumb = 'xxxxxxxxxxxx / Program Supervisi Analisis';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.program.supervisi.analisis.analisissupervisiwalikelas.analisis-supervisi-wali-kelas-create', compact(
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
        \App\Models\Program\Supervisi\Analisis\AnalisisSupervisiWaliKelas::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Program Supervisi Analisis';
        $breadcrumb = 'xxxxxxxxxxxx / Program Supervisi Analisis';
        $data = \App\Models\Program\Supervisi\Analisis\AnalisisSupervisiWaliKelas::findOrFail($id);

        return view('role.program.supervisi.analisis.analisissupervisiwalikelas.analisis-supervisi-wali-kelas-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Program Supervisi Analisis';
        $breadcrumb = 'xxxxxxxxxxxx / Program Supervisi Analisis / Edit';
        $data = \App\Models\Program\Supervisi\Analisis\AnalisisSupervisiWaliKelas::findOrFail($id);

        return view('role.program.supervisi.analisis.analisissupervisiwalikelas.analisis-supervisi-wali-kelas-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Program\Supervisi\Analisis\AnalisisSupervisiWaliKelas::findOrFail($id);

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
        $data = \App\Models\Program\Supervisi\Analisis\AnalisisSupervisiWaliKelas::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
