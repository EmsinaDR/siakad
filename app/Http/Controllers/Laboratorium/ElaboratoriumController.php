<?php

namespace App\Http\Controllers\Laboratorium;

use Carbon\Carbon;

use App\Models\elab;
use App\Models\User;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Laboratorium\Laboratorium;
use App\Models\Laboratorium\Elaboratorium;
use App\Models\WakaSarpras\Inventaris\KIBC;
use App\Models\Laboratorium\RiwayatLaboratorium;
use App\Models\WakaSarpras\Inventaris\Inventaris;

class ElaboratoriumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Laboratorium';
        $arr_ths = [
            'Kode Ruangan',
            'Nama Lab',
            'Penanggung Jawab',
        ];
        $breadcrumb = "Admin Data / Data Laboratorium";
        $etapels = Etapel::where('aktiv', 'Y')->first();

        $Laboratoriums = Cache::tags(['chace_Laboaratoriums'])->remember('remember_Laboaratoriums', now()->addMinutes(5), function () {
            return Elaboratorium::get();
        });
        $riwayat_lab = Cache::tags(['chace_riwayat_lab'])->remember('remember_riwayat_lab', now()->addMinutes(5), function () use ($etapels) {
            return RiwayatLaboratorium::where('aktiv', 'Y')->where('tapel_id', $etapels->id)->get();
        });
        $titleviewModal = 'Lihat Data Laboratorium';
        $titleeditModal = 'Edit Data Laboratorium';
        $titlecreateModal = 'Tambah Data Laboratorium';
        return view('admin.e_laboratorium', compact(
            'title',
            'riwayat_lab',
            'breadcrumb',
            'arr_ths',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'Laboratoriums',
        ));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $etapels = Etapel::where('aktiv', 'Y')->first();
            if (!$etapels) {
                return back()->with('error', 'Tapel aktif tidak ditemukan.');
            }
            $laboratorium = Laboratorium::findOrFail($request->laboratorium_id);
            // Hitung kode baru
            $jumlahRiwayat = RiwayatLaboratorium::where('kode_ruangan', 'like', $laboratorium->kode_ruangan . '%')->count();
            $jumlahInventaris = Inventaris::where('kode', 'like', $laboratorium->kode_ruangan . '%')->count();
            // Buat kode ruangan baru
            $kodeRuanganBaru = $laboratorium->kode_ruangan . '-' . ($jumlahInventaris + 1);

            // 1. Simpan ke Inventaris
            $inventaris = Inventaris::create([
                'kode' => $kodeRuanganBaru,
                'system' => 'N',
                'nama_barang' => $laboratorium->nama_laboratorium,
                'kategori' => 'Ruangan',
                'sub_kategori' => 'Fasilitas Pendidikan',
                'keterangan' => 'Digunakan sebagai fasilitas pembelajaran terkait dengan guru masing masing',
            ]);

            // 2. Cek dan Simpan ke KIBC (jika belum ada)
            $kibc = KIBC::where('kode_ruangan', $kodeRuanganBaru)->first();

            if (!$kibc) {
                $kibc = KIBC::create([
                    'inventaris_id' => $inventaris->id,
                    'kode_ruangan' => $kodeRuanganBaru,
                    'nama_ruangan' => $laboratorium->nama_laboratorium,
                    'panjang' => 0,
                    'lebar' => 0,
                    'spesifikasi' => 'Spesifikasi umum ruang ini ' . $laboratorium->nama_laboratorium,
                    'keterangan' => 'Tempat atau ' . $laboratorium->nama_laboratorium . ' digunakan untuk',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // 3. Masukkan ke Riwayat Laboratorium
            RiwayatLaboratorium::create([
                'tapel_id' => $etapels->id,
                'kode_ruangan' => $kodeRuanganBaru,
                'ruang_id' => $kibc->id,
                'laboratorium_id' => $laboratorium->id,
                'aktiv' => 'Y',
                'detailguru_id' => $request->detailguru_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 4. Hapus Cache
            HapusCacheDenganTag('chace_riwayat_lab');

            DB::commit();

            return back()->with('success', 'Data laboratorium berhasil disimpan!');
        } catch (\Throwable $e) {
            DB::rollback();

            // Debug log (opsional)
            Log::error('Gagal simpan data lab: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function update($id, Request $request)
    {

        $data = $request->except(['_token', '_method']);
        // dd($data);
        $data = RiwayatLaboratorium::findOrFail($id);
        $data->laboratorium_id = $request->laboratorium_id;
        $data->detailguru_id = $request->detailguru_id;
        $data->updated_at = now();
        $data->update();
        Session::flash('success', 'Data Berhasil Diperbaharui');
        return Redirect::back();
        // return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  berhasil diperbaharui');
    }


    public function destroy($id, Request $request)
    {
        // dd($request->all());
        //Proses Modal Delete
        //Form Modal Delete ada di index
        //Detailguru
        // dd(id);
        //keterangan delete :
        // 1. KIBC
        // 2. Invetaris
        // 3. Baru Data Lab
        // dd(request->all());
        try {
            DB::beginTransaction();

            // Ambil data riwayat laboratorium
            $data = RiwayatLaboratorium::findOrFail($id);
            $data->delete();

            // Hapus data KIBC berdasarkan kode_ruangan
            KIBC::where('kode_ruangan', $data->kode_ruangan)->delete();

            // Jika semua berhasil, commit
            DB::commit();
        } catch (\Exception $e) {
            // Kalau ada error, rollback semuanya
            DB::rollBack();

            // Kamu bisa log error atau kirim respon gagal
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
        // $Invetaris = Inventaris::where('kode_ruangan', $data->kode_ruangan)->delete();
        HapusCacheDenganTag('chace_riwayat_lab');

        // $data->delete();

        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahaps Berhasil dihapus dari databse');
    }
}
