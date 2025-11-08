<?php

namespace App\Http\Controllers\Program\Supervisi\Analisis;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Supervisi\Analisis\AnalisisSupervisiPembelajaran;

class AnalisisSupervisiPembelajaranController extends Controller
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
        $datas = \App\Models\Program\Supervisi\Analisis\AnalisisSupervisiPembelajaran::with(['indikator', 'kelas'])
            ->where('tapel_id', $etapels->id)
            ->get()
            ->groupBy('indikator_id');
        $datasx = \App\Models\Program\Supervisi\Analisis\AnalisisSupervisiPembelajaran::with(['supervisiInstrument'])
            ->where('tapel_id', $etapels->id)
            ->get()
            ->groupBy(function ($item) {
                // Kelompokkan berdasarkan kategori atau sub_kategori yang ada dalam supervisiInstrument
                return $item->supervisiInstrument ? $item->supervisiInstrument->kategori : 'N/A'; // Memastikan supervisiInstrument ada
            });

        $results = DB::table('supervisi_pembelajaran')
            ->join('supervisi_instrument', 'supervisi_pembelajaran.indikator_id', '=', 'supervisi_instrument.id')
            ->select(
                'supervisi_instrument.id',
                'supervisi_instrument.sub_kategori',
                'supervisi_instrument.sub_sub_kategori',
                'supervisi_instrument.indikator',
                DB::raw('COUNT(supervisi_pembelajaran.id) as total_pembelajaran'),
                DB::raw('COUNT(CASE WHEN supervisi_pembelajaran.nilai <= 2 THEN 1 END) as total_pembelajaran_buruk')
            )
            ->groupBy('supervisi_instrument.id', 'supervisi_instrument.sub_kategori', 'supervisi_instrument.sub_sub_kategori', 'supervisi_instrument.indikator')
            ->get();

        // dump($results);
        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.program.supervisi.analisis.analisissupervisipembelajaran.analisis-supervisi-pembelajaran', compact(
            'title',
            'title',
            'arr_ths',
            'datas',
            'datasx',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'results',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Program Supervisi Analisis';
        $breadcrumb = 'xxxxxxxxxxxx / Program Supervisi Analisis';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.program.supervisi.analisis.analisissupervisipembelajaran.analisis-supervisi-pembelajaran-create', compact(
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
        \App\Models\Program\Supervisi\Analisis\AnalisisSupervisiPembelajaran::create($validator->validated());

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
        $data = \App\Models\Program\Supervisi\Analisis\AnalisisSupervisiPembelajaran::findOrFail($id);

        return view('role.program.supervisi.analisis.analisissupervisipembelajaran.analisis-supervisi-pembelajaran-single', compact(
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
        $data = \App\Models\Program\Supervisi\Analisis\AnalisisSupervisiPembelajaran::findOrFail($id);

        return view('role.program.supervisi.analisis.analisissupervisipembelajaran.analisis-supervisi-pembelajaran-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Program\Supervisi\Analisis\AnalisisSupervisiPembelajaran::findOrFail($id);

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
        $data = \App\Models\Program\Supervisi\Analisis\AnalisisSupervisiPembelajaran::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
