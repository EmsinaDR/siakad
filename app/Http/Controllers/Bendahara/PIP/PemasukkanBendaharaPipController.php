<?php

namespace App\Http\Controllers\Bendahara\PIP;

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

class PemasukkanBendaharaPipController extends Controller
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
            'Tahun',
            'Tahap',
            'Nama Siswa',
            'Kelas',
            'Pemasukkan',
            'Keterangan',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Bendahara\PIP\PemasukkanBendaharaPip::where('tapel_id', $etapels->id)->get();
        $datas = \App\Models\Bendahara\PIP\DataPenerimaPip::with(['Siswa', 'Kelas']) // Memuat relasi Siswa dan Kelas
            ->join('detailsiswas', 'data_penerima_pip.detailsiswa_id', '=', 'detailsiswas.id') // Bergabung dengan tabel detailsiswa
            ->orderBy('kelas_id')
            ->join('ekelas', 'detailsiswas.kelas_id', '=', 'ekelas.id') // Bergabung dengan tabel ekelas
            // ->orderBy('ekelas.kelas') // Mengurutkan berdasarkan kelas di Ekelas
            ->orderBy('detailsiswas.nama_siswa') // Mengurutkan berdasarkan nama_siswa di Detailsiswa
            ->get();


        $datas = \App\Models\Bendahara\PIP\PemasukkanBendaharaPip::with('Tapel')->orderBy('tapel_id', 'DESC')
            ->join('detailsiswas', 'pemasukkan_pip.detailsiswa_id', '=', 'detailsiswas.id')
            ->orderBy('kelas_id')
            ->orderBy('pemasukkan_pip.detailsiswa_id')
            ->orderBy('detailsiswas.nama_siswa')
            ->get();

        $TotalPemasukkan = \App\Models\Bendahara\PIP\PemasukkanBendaharaPip::with('Tapel')
            ->select('tapel_id', DB::raw('SUM(nominal) as total_nominal'))
            ->groupBy('tapel_id')
            ->get();
        $Etapels = Etapel::get();
        $DataPenerimaDropdwon = \App\Models\Bendahara\PIP\DataPenerimaPip::with(['Siswa', 'Kelas']) // Memuat relasi Siswa dan Kelas
            ->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.bendahara.pip.pemasukkanbendaharapip.pemasukkan-bendahara-pip', compact(
            'title',
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'Etapels',
            'DataPenerimaDropdwon',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Bendahara PIP';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara PIP';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.bendahara.pip.pemasukkanbendaharapip.pemasukkan-bendahara-pip-create', compact(
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
        \App\Models\Bendahara\PIP\PemasukkanBendaharaPip::create($validator->validated());

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
        $data = \App\Models\Bendahara\PIP\PemasukkanBendaharaPip::findOrFail($id);

        return view('role.bendahara.pip.pemasukkanbendaharapip.pemasukkan-bendahara-pip-single', compact(
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
        $data = \App\Models\Bendahara\PIP\PemasukkanBendaharaPip::findOrFail($id);

        return view('role.bendahara.pip.pemasukkanbendaharapip.pemasukkan-bendahara-pip-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Bendahara\PIP\PemasukkanBendaharaPip::findOrFail($id);

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
        $data = \App\Models\Bendahara\PIP\PemasukkanBendaharaPip::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
    public function PIPAnggaran(Request $request)
    {
        // dd($request->all());

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge(['tapel_id' => $etapels->id]);

        // Validasi input
        // $validator = Validator::make($request->all(), [
        //     // Tambahkan validasi sesuai kebutuhan
        // ]);
        foreach ($request->detailsiswa_id as $Siswa) {
            $data = PemasukkanBendaharaPip::whereYear('created_at', $request->tahun)->create([
                'tapel_id' => $request->tapel_id,
                'detailguru_id' => Auth::user()->detailguru_id,
                'detailsiswa_id' => $Siswa,
                'tanggal_penerimaan' => now(),
                'tahap' => $request->tahap,
                'nominal' => $request->nominal,
                'keterangan' => $request->keterangan,
            ]);
        }
        // $data = PemasukkanBendaharaPip::whereYear('created_at', $request->tahun)->update([
        //     'tahap' => $request->tahap,
        //     'nominal' => $request->nominal,
        //     'keterangan' => $request->keterangan,
        // ]);
        Session::flash('success', 'Data Berhasil Dihapus');
        return Redirect::back();
    }
}
