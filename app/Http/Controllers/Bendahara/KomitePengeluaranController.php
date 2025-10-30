<?php

namespace App\Http\Controllers\Bendahara;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\Bendahara\BukukasKomite;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Bendahara\BendaharaKomite;
use App\Models\Bendahara\RencanaAnggaran;
use Illuminate\Support\Facades\Validator;
use App\Models\Bendahara\BendaharaKasUmum;
use App\Models\Bendahara\KomitePengeluaran;
use App\Models\Bendahara\RencanaAnggaranList;

class KomitePengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Pengeluaran';
        $arr_ths = [
            'Jenis Pengeluaran',
            'Penerima',
            'Nominal',
            'Persentase',
            // 'Keterangan',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Bendahara / Bendahara Komite / Pengeluaran Anggaran';
        $titleviewModal = 'Lihat Data Pengeluaran';
        $titleeditModal = 'Edit Data Pengeluaran';
        $titlecreateModal = 'Create Data Pengeluaran';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = KomitePengeluaran::orderBy('created_at', 'DESC')->where('tapel_id', $etapels->id)->get();
        $gurus = Detailguru::orderBy('nama_guru')->get();
        $data_keuangan_komite = BendaharaKomite::select('nominal')->where('tapel_id', $etapels->id)->get()->sum('nominal');
        $data_keuangan_komite_keluar = KomitePengeluaran::where('tapel_id', $etapels->id)->sum('nominal');
        $pengerluarans = RencanaAnggaran::where('tapel_id', $etapels->id)->get();
        return view('role.bendahara.komite.pengeluaran', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'gurus',
            'data_keuangan_komite',
            'data_keuangan_komite_keluar',
            'pengerluarans'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Ambil data Etapel yang aktif
            // dd($request->all(), $request->non_anggaran);
            $etapels = Etapel::where('aktiv', 'Y')->first();

            // Merge data tambahan ke request
            $request->merge([
                'tapel_id' => $etapels->id,
                'semester' => $etapels->semester,
                'petugas_id' => Auth::user()->detailguru_id,
            ]);

            // Cek jika jenis_pengeluaran_id adalah "lainnya"
            if ($request->jenis_pengeluaran_id === 'lainnya') {
                // Simpan dulu ke RencanaAnggaranList
                // $newList = RencanaAnggaranList::firstOrCreate(
                //     ['jenis_pengeluaran' => 'Non Anggaran'],
                //     [
                //         'keterangan' => 'Anggaran Tak Terencana: ' . $request->non_anggaran,
                //     ]
                // );

                // if (!$newList->kode) {
                //     $prefix = strtoupper(substr($newList->jenis_pengeluaran, 0, 3)); // Contoh: "NON"
                //     $kodeBaru = $prefix . '-' . $newList->id; // Contoh: "NON-401"

                //     $newList->update([
                //         'kode' => $kodeBaru,
                //     ]);
                // }

                // Simpan ke RencanaAnggaran, hubungkan ke list tadi
                $newAnggaran = RencanaAnggaran::create([
                    'tapel_id' => $request->tapel_id, // field foreign key ke list
                    'semester' => $request->semester, // field foreign key ke list
                    // 'rencana_anggaran_id' => $newList->id, // field foreign key ke list
                    'rencana_anggaran_id' => 1, // field foreign key ke list
                    'nominal' => 150000, // atau bisa dikosongkan
                ]);

                // Masukkan ID anggaran ke request
                $request->merge([
                    'jenis_pengeluaran_id' => $newAnggaran->id
                ]);
            }

            // Validasi request
            $validator = Validator::make($request->all(), [
                'tapel_id' => 'required|numeric',
                'semester' => 'required|string|max:255',
                'petugas_id' => 'required|numeric',
                'penerima_id' => 'required|numeric',
                'nominal' => 'required|numeric',
                'jenis_pengeluaran_id' => 'required|numeric',
                'keterangan' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            // Cek Dana yang sudah keluar untuk mencegah melebihi batas pengeluaran
            $RencanaTotal = RencanaAnggaran::where('tapel_id', $etapels->id)->where('id', $request->jenis_pengeluaran_id)->sum('nominal');
            $PengeluaranTotal = KomitePengeluaran::where('tapel_id', $etapels->id)->where('jenis_pengeluaran_id', $request->jenis_pengeluaran_id)->sum('nominal');
            $SaldoIjin = $RencanaTotal - ($PengeluaranTotal + $request->nominal);

            if (is_null($request->pengeluaran_manual)) {
                if ($SaldoIjin < 0) {
                    $kelebihan = abs($SaldoIjin); // ambil nilai mutlak (positif)
                    throw new \Exception('Pengeluaran melebihi batas anggaran sebesar: ' . number_format($kelebihan, 0));
                }
            }

            // Simpan ke KomitePengeluaran
            $komitePengeluaran = KomitePengeluaran::create($validator->validated());
            // Ambil data relasi
            $RencanaAnggaran = RencanaAnggaran::find($request->jenis_pengeluaran_id);
            $RencanaAnggaranList = RencanaAnggaranList::find($RencanaAnggaran->rencana_anggaran_id);
            $Penerima = Detailguru::find($request->penerima_id);
            $IdPengeluaran = KomitePengeluaran::max('id');
            // Simpan ke Buku Kas Komite
            $datauraian = is_null($request->pengeluaran_manual) ? $request->non_anggaran : $RencanaAnggaranList->jenis_pengeluaran;
            $datauraian = !empty($request->pengeluaran_manual)
                ? $request->pengeluaran_manual
                : (!empty($request->non_anggaran)
                    ? $request->non_anggaran
                    : optional($RencanaAnggaranList)->jenis_pengeluaran);


            // dd($datauraian, $request->non_anggaran, $RencanaAnggaranList->jenis_pengeluaran);
            BukukasKomite::create([
                'tanggal' => now()->toDateString(),
                'uraian' => 'Pengeluaran: ' . $datauraian,
                'program' => $request->non_anggaran !==  null ? 'Tak Terencana' : 'Terencana', //$RencanaAnggaranList->jenis_pengeluaran
                'pengeluaran_id' => $IdPengeluaran,
                'penerimaan' => 0,
                'pengeluaran' => $request->nominal,
                'keterangan' => 'Via Bendahara: ' . (Auth::user()->name ?? '-') . ' Diserahkan kepada: ' . ($Penerima->nama_guru ?? '-'),
                'tapel_id' => $etapels->id,
                'petugas_id' => $request->petugas_id,
            ]);

            // Buku kas Umum
            BendaharaKasUmum::create([
                'tanggal' => now()->toDateString(),
                'uraian' => 'Pengeluaran: ' . $datauraian,
                'sumber_dana' => 'Komite',
                'program' => $request->jenis_pengeluaran_id === 'non_anggaran'
                    ? 'Pembayaran Komite'
                    : 'Tak Terencana',
                'penerimaan' => 0,
                'pengeluaran_komite_id' => $IdPengeluaran,
                'pengeluaran' => $request->nominal,
                'keterangan' => 'Via Bendahara: ' . (Auth::user()->name ?? '-') . ' Diserahkan kepada: ' . ($Penerima->nama_guru ?? '-') . "Untuk Penggunaan (" . $request->non_anggaran . ")",
                'tapel_id' => $etapels->id,
            ]);
            DB::commit(); // WAJIB
            // Redirect dengan pesan sukses
            return redirect()->back()
                ->with('Title', 'Berhasil!')
                ->with('Success', 'Data pengeluaran berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data. Error: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(KomitePengeluaran $komitePengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KomitePengeluaran $komitePengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request, KomitePengeluaran $komitePengeluaran)
    {
        //
        // dd($id);
        // dd($request->all());
        // Ambil tapel aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Tambahkan data tambahan ke request
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
            'petugas_id' => Auth::user()->detailguru_id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'penerima_id' => 'required|numeric',
            'nominal' => 'required|numeric',
        ]);

        // Jika gagal validasi
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Ambil data yang mau di-update
        $komitePengeluaran = KomitePengeluaran::findOrFail($id); // findOrFail = auto 404 kalau ga ketemu

        // Update data
        $komitePengeluaran->update([
            'penerima_id' => $request->penerima_id,
            'nominal' => $request->nominal,
        ]);
        // Simpan ke Buku Kas Komite
        $Penerima = Detailguru::find($request->penerima_id);
        BukukasKomite::where('pengeluaran_id', $id)->update([
            'pengeluaran' => $request->nominal,
            'keterangan' => 'Via Bendahara: ' . (Auth::user()->name ?? '-') . ' Diserahkan kepada: ' . ($Penerima->nama_guru ?? '-'),
        ]);

        // Buku kas Umum
        BendaharaKasUmum::where('pengeluaran_komite_id', $id)->update([
            'pengeluaran' => $request->nominal,
            'keterangan' => 'Via Bendahara: ' . (Auth::user()->name ?? '-') . ' Diserahkan kepada: ' . ($Penerima->nama_guru ?? '-'),
        ]);
        Session::flash('success', 'Data Berhasil Dihapus');
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Hapus dari KomitePengeluaran
            $pengeluaran = KomitePengeluaran::find($id);
            if ($pengeluaran) {
                $pengeluaran->delete();
            }

            // Hapus dari BendaharaKasUmum jika ada pengeluaran_komite_id terkait
            $kasUmum = BendaharaKasUmum::where('pengeluaran_komite_id', $id)
                ->where('sumber_dana', 'Komite')
                ->first();
            if ($kasUmum) {
                $kasUmum->delete();
            }

            // Hapus dari BukuKasKomite jika ada
            $bukuKas = BukukasKomite::where('pengeluaran_id', $id)->first();
            if ($bukuKas) {
                $bukuKas->delete();
            }

            return redirect()->back()
                ->with('Title', 'Berhasil !!!')
                ->with('success', 'Data berhasil dihapus dari database');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('Title', 'Gagal !!!')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}



/*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
php artisan migrate:fresh --seed


composer dump-autoload

*/