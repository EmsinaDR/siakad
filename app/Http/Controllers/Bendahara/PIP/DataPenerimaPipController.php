<?php

namespace App\Http\Controllers\Bendahara\PIP;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Bendahara\PIP\DataPenerimaPip;
use App\Models\Bendahara\PIP\PemasukkanBendaharaPip;

class DataPenerimaPipController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Bendahara PIP';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara PIP';
        $titleviewModal = 'Lihat Bendahara PIP';
        $titleeditModal = 'Edit Bendahara PIP';
        $titlecreateModal = 'Buat Bendahara PIP';
        $arr_ths = [
            'Nama',
            'Kelas',
            'Saldo',
            'Petugas',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Bendahara\PIP\DataPenerimaPip::with(['Siswa', 'Kelas'])->orderBy('kelas_id')->orderBy('nama_siswa')->where('tapel_id', $etapels->id)->get();
        $datas = \App\Models\Bendahara\PIP\DataPenerimaPip::with(['Siswa', 'Kelas']) // Memuat relasi Siswa dan Kelas
            ->join('detailsiswas', 'data_penerima_pip.detailsiswa_id', '=', 'detailsiswas.id') // Bergabung dengan tabel detailsiswa
            ->join('ekelas', 'detailsiswas.kelas_id', '=', 'ekelas.id') // Bergabung dengan tabel ekelas
            ->orderBy('detailsiswas.nama_siswa') // Mengurutkan berdasarkan nama_siswa di Detailsiswa
            ->orderBy('ekelas.kelas') // Mengurutkan berdasarkan nama kelas di Ekelas
            ->get();
        $datas = \App\Models\Bendahara\PIP\DataPenerimaPip::with(['Siswa', 'Kelas']) // Memuat relasi Siswa dan Kelas
            ->join('detailsiswas', 'data_penerima_pip.detailsiswa_id', '=', 'detailsiswas.id') // Bergabung dengan tabel detailsiswa
            ->orderBy('kelas_id')
            ->join('ekelas', 'detailsiswas.kelas_id', '=', 'ekelas.id') // Bergabung dengan tabel ekelas
            // ->orderBy('ekelas.kelas') // Mengurutkan berdasarkan kelas di Ekelas
            ->orderBy('detailsiswas.nama_siswa') // Mengurutkan berdasarkan nama_siswa di Detailsiswa
            ->get();

        $TotalPemasukkan = DB::table('pemasukkan_pip')
            ->select('tapel_id', DB::raw('SUM(nominal) as total_nominal'))
            ->groupBy('tapel_id')
            ->get();
        $TotalPemasukkan = \App\Models\Bendahara\PIP\PemasukkanBendaharaPip::with('Tapel')
            ->select('tapel_id', DB::raw('SUM(nominal) as total_nominal'))
            ->groupBy('tapel_id')
            ->get();
        $IDPenerima = DataPenerimaPip::pluck('detailsiswa_id')->toArray();
        $DataPenerima = DataPenerimaPip::select('detailsiswa_id')->distinct()
            ->join('detailsiswas', 'data_penerima_pip.detailsiswa_id', '=', 'detailsiswas.id')
            ->join('ekelas', 'detailsiswas.kelas_id', '=', 'ekelas.id') // Bergabung dengan tabel ekelas
            ->orderBy('detailsiswas.nama_siswa') // Mengurutkan berdasarkan nama_siswa di Detailsiswa
            ->orderBy('ekelas.kelas') // Mengurutkan berdasarkan nama kelas di Ekelas
            ->get();
        // dump($IDPenerima);
        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.bendahara.pip.datapenerimapip.data-penerima-pip', compact(
            'title',
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'TotalPemasukkan',
            'IDPenerima',
            'DataPenerima',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Bendahara PIP';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara PIP';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.bendahara.pip.datapenerimapip.data-penerima-pip-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {
        // Mendapatkan data Etapel yang aktif
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();

        $request->merge([
            'tapel_id' => $etapels->id,
            'detailguru_id' => Auth::User()->detailguru_id
        ]);


        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'detailsiswa_id' => 'required|array',
            'detailguru_id' => 'required|integer',
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        foreach ($request->detailsiswa_id as $data) {
        }
        // Membuat entri baru berdasarkan validasi
        // Ambil semua detailsiswa_id yang sudah ada di DataPenerimaPip
        $CekDetailsiswas = DataPenerimaPip::pluck('detailsiswa_id')->toArray();

        // Looping melalui setiap detailsiswa_id yang ada di request
        foreach ($request->detailsiswa_id as $detailsiswa_id) {
            // Cek apakah detailsiswa_id sudah ada di database
            if (!in_array($detailsiswa_id, $CekDetailsiswas)) {
                // Jika belum ada, simpan data baru
                \App\Models\Bendahara\PIP\DataPenerimaPip::create(array_merge($validator->validated(), ['detailsiswa_id' => $detailsiswa_id]));
            }
            // Jika sudah ada, lewati tanpa melakukan apa-apa
        }

        // foreach ($request->detailsiswa_id as $detailsiswa_id) {
        //     \App\Models\Bendahara\PIP\PemasukkanBendaharaPip::create([
        //         'detailsiswa_id' => $detailsiswa_id,
        //         'tapel_id' => $etapels->id,
        //         'detailguru_id' => Auth::user()->detailguru_id,
        //         'tanggal_penerimaan' => now(),
        //         'nominal' => 0,
        //         // Tambahkan field lain kalau ada
        //     ]);
        // }

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Bendahara PIP';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara PIP';
        $data = \App\Models\Bendahara\PIP\DataPenerimaPip::findOrFail($id);

        return view('role.bendahara.pip.datapenerimapip.data-penerima-pip-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Bendahara PIP';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara PIP / Edit';
        $data = \App\Models\Bendahara\PIP\DataPenerimaPip::findOrFail($id);

        return view('role.bendahara.pip.datapenerimapip.data-penerima-pip-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Bendahara\PIP\DataPenerimaPip::findOrFail($id);

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
        $data = \App\Models\Bendahara\PIP\DataPenerimaPip::find($id);

        if (!$data) {
            Session::flash('error', 'Data tidak ditemukan!');
            return Redirect::back();
        }

        $data->delete();

        Session::flash('success', 'Data berhasil dihapus');
        return Redirect::back();
    }
    public function DeletPenerima(Request $request, $penerima_pip)
    {

        // dd($request->all(), $penerima_pip);
        $data = \App\Models\Bendahara\PIP\DataPenerimaPip::where('detailsiswa_id', $penerima_pip);

        if (!$data) {
            Session::flash('error', 'Data tidak ditemukan!');
            return Redirect::back();
        }

        $data->delete();

        Session::flash('success', 'Data berhasil dihapus');
        return Redirect::back();
    }
}
