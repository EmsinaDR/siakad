<?php

namespace App\Http\Controllers\Bendahara\RencanaAnggaran;

use Carbon\Carbon;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Bendahara\RencanaAnggaran;
use Illuminate\Support\Facades\Validator;
use App\Models\Bendahara\KomitePengeluaran;
use App\Models\Bendahara\RencanaAnggaran\RencanaAnggaranList as RencanaAnggaranRencanaAnggaranList;
use App\Models\Bendahara\RencanaAnggaranList;
use App\Models\Bendahara\RencanaAnggaran\RencanaAnggaranSekolah;

class RencanaAnggaranSekolahController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Rencana Anggaran';
        $breadcrumb = 'Bendahara / Rencana Anggaran';
        $titleviewModal = 'Lihat Rencana Anggaran';
        $titleeditModal = 'Edit Rencana Anggaran';
        $titlecreateModal = 'Buat Rencana Anggaran';
        $arr_ths = [
            'Kode',
            'Kategori',
            'Rencana Anggaran',
            'Nominal',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id

        $RencanaAnggaranSekolahAll = Cache::tags(['cache_RencanaAnggaranSekolahAll'])->remember('remember_RencanaAnggaranSekolahAll', now()->addHours(2), function () use ($etapels) {
            return RencanaAnggaranSekolah::with(['RencanaAnggaranLis'])->where('tapel_id', $etapels->id)->orderBy('created_at', 'DESC')->get();
        });
        $rencanaAnggaransList = RencanaAnggaranList::where('id', '!=', 1)->orderBy('jenis_pengeluaran', 'ASC')->get();
        $rencanaAnggaransSekolah = RencanaAnggaranSekolah::with(['RencanaAnggaranLis'])->where('tapel_id', $etapels->id)->get();
        $rencanaAnggaransSekolah = Cache::tags(['cache_rencanaAnggaransSekolah'])->remember('remember_rencanaAnggaransSekolah', now()->addHours(2), function () use ($etapels) {
            return RencanaAnggaranSekolah::with(['RencanaAnggaranLis'])->where('tapel_id', $etapels->id)->orderBy('created_at', 'DESC')->get();
        });
        $bulanDepan = Carbon::now()->addMonth(1);

        $RencanaBulanDepan = Cache::tags(['cache_RencanaBulanDepan'])->remember('remember_RencanaBulanDepan', now()->addHours(2), function () use ($bulanDepan, $rencanaAnggaransSekolah, $etapels) {
            return RencanaAnggaranSekolah::with(['RencanaAnggaranLis'])->where('tapel_id', $etapels->id)
                ->whereMonth('tanggal', $bulanDepan->month)
                ->whereYear('tanggal', $bulanDepan->year)
                ->get();;
        });
        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.bendahara.rencanaanggaran.rencanaanggaransekolah.rencana-anggaran-sekolah', compact(
            'title',
            'title',
            'arr_ths',
            'RencanaAnggaranSekolahAll',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'rencanaAnggaransList',
            'rencanaAnggaransSekolah',
            'RencanaBulanDepan',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Rencana Anggaran';
        $breadcrumb = 'Bendahara / Rencana Anggaran';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.bendahara.rencanaanggaran.rencanaanggaransekolah.rencana-anggaran-sekolah-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Mendapatkan data Etapel yang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $DataRencana = RencanaAnggaranRencanaAnggaranList::where('id', $request->rencana_anggaran)->first();
        // dd($DataRencana);
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
            'rencana_anggaran_id' => $request->rencana_anggaran,
            // 'kode' => $DataRencana->kode
        ]);


        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'rencana_anggaran_id' => 'required|integer', // <--- tambahkan ini
            'tanggal' => 'required|date',
            // 'kode' => 'required|string',
            'nominal' => 'required|numeric',
            'keterangan' => 'required|string',
            'semester' => 'required|string',
            'tapel_id' => 'required|integer',
            'semester' => 'required|string',
            'kategori' => 'required|string',
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        \App\Models\Bendahara\RencanaAnggaran\RencanaAnggaranSekolah::create($validator->validated());

        HapusCacheDenganTag('cache_rencanaAnggaransSekolah');
        HapusCacheDenganTag('cache_RencanaBulanDepan');
        // dd($request->all());
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Rencana Anggaran';
        $breadcrumb = 'Bendahara / Rencana Anggaran';
        $data = \App\Models\Bendahara\RencanaAnggaran\RencanaAnggaranSekolah::findOrFail($id);

        return view('role.bendahara.rencanaanggaran.rencanaanggaransekolah.rencana-anggaran-sekolah-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Rencana Anggaran';
        $breadcrumb = 'Bendahara / Rencana Anggaran / Edit';
        $data = \App\Models\Bendahara\RencanaAnggaran\RencanaAnggaranSekolah::findOrFail($id);

        return view('role.bendahara.rencanaanggaran.rencanaanggaransekolah.rencana-anggaran-sekolah-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Bendahara\RencanaAnggaran\RencanaAnggaranSekolah::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // 'rencana_anggaran_id' => 'required|integer', // <--- tambahkan ini
            'tanggal' => 'required|date',
            // 'kode' => 'required|string',
            'nominal' => 'required|numeric',
            // 'keterangan' => 'required|string',
            // 'semester' => 'required|string',
            // 'tapel_id' => 'required|integer',
            // 'semester' => 'required|string',
            // 'kategori' => 'required|string',
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
        $data = \App\Models\Bendahara\RencanaAnggaran\RencanaAnggaranSekolah::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
    public function UbahKategori(Request $request)
    {
        // dd($request->all());
        // Mendapatkan data Etapel yang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $data = \App\Models\Bendahara\RencanaAnggaran\RencanaAnggaranSekolah::whereIn('id', $request->rencana_anggaran)->update([
            'kategori' => $request->kategori
        ]);
        // dd($data);

        HapusCacheDenganTag('cache_rencanaAnggaransSekolah');
        HapusCacheDenganTag('cache_RencanaBulanDepan');
        HapusCacheDenganTag('cache_RencanaAnggaranSekolahAll');
        Session::flash('success', 'Data Berhasil Dihapus');
        return Redirect::back();
    }
}
