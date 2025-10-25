<?php

namespace App\Http\Controllers\Program\Supervisi\Waka;

use App\Models\Admin\Emapel;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Admin\Identitas;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Program\SetingPengguna;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Supervisi\SupervisiInstrument;
use App\Models\Program\Supervisi\Waka\SupervisiWakaKesiswaan;

class SupervisiWakaKesiswaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Supervisi Waka Kesiswaan';
        $arr_ths = [
            'Tahun Pelajaran',
            'Nama Guru',
            'Indikator',
            'Skor Supervisi',
        ];
        $breadcrumb = 'Data Supervisi / Data Supervisi Waka Kesiswaan';
        $titleviewModal = 'Lihat Data Supervisi Waka Kesiswaan';
        $titleeditModal = 'Edit Data Supervisi Waka Kesiswaan';
        $titlecreateModal = 'Create Data Supervisi Waka Kesiswaan';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SupervisiWakaKesiswaan::where('tapel_id', $etapels->id)->where('bidang', 'Waka Kesiswaan')->groupBy('detailguru_id')->get();
        $Instrumens = SupervisiInstrument::where('bidang', 'Waka Kesiswaan')->count();


        return view('role.program.supervisi.waka.supervisi-waka-kesiswaan', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'Instrumens',
        ));
        //php artisan make:view role.program.supervisi.waka.supervisi-waka-kesiswaan

    }


    public function show($id, Request $request)
    {
        //
        //Title to Controller
        $title = 'Data Supervisi Waka Kesiswaan';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Supervisi / Data Supervisi Waka Kesiswaan';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SupervisiWakaKesiswaan::where('tapel_id', $etapels->id)->get();
        $Tapels = Etapel::where('aktiv', 'Y')->first();

        $DataMapel = Emapel::where('id', request()->mapel_id)->first();
        $Guru = Detailguru::where('id', request()->detailguru_id)->first();
        $Tapels = Etapel::where('aktiv', 'Y')->first();
        $totalNilai = 0;
        $DataSiswa = \App\Models\User\Siswa\Detailsiswa::get();
        $Identitas = Identitas::first();
        // dd($request->bidang);

        $Instrumens = \App\Models\Program\Supervisi\SupervisiInstrument::where('supervisi_instrument.bidang', $request->bidang)
            ->join('supervisi_waka', function ($join) use ($request) {
                $join->on('supervisi_instrument.id', '=', 'supervisi_waka.indikator_id')
                    ->where('supervisi_waka.tapel_id', $request->tapel_id)
                    ->where('supervisi_waka.semester', $request->semester)
                    ->where('supervisi_waka.bidang', $request->bidang);
            })
            ->select('supervisi_instrument.*', 'supervisi_waka.*')
            ->orderBy('supervisi_instrument.id')
            ->get()
            ->groupBy(function ($item) {
                // Menggunakan 'Tanpa Kategori' jika kategori kosong atau null
                return $item->kategori ?: 'Tanpa Kategori';
            });
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.supervisi.waka.supervisi-waka-kurikulum-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'Identitas',
            'DataMapel',
            'Guru',
            'Tapels',
            'totalNilai',
            'Instrumens',
            'DataSiswa',
        ));
        //php artisan make:view role.program.supervisi.waka.supervisi-waka-kesiswaan-single
    }

    public function store(Request $request)
    {
        //
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
        ]);

        // Validasi data
        $request->validate([
            'tapel_id' => 'required|integer',
        ]);
        $User = SetingPengguna::where('nama_program', 'Waka Kurikulum')->first();
        $guruIds = json_decode($User->detailguru_id); // hasilnya array: [1]
        $detailGuru = Detailguru::whereIn('id', $guruIds)->first();

        $Indikators = SupervisiInstrument::where('bidang', $request->bidang)->get();

        foreach ($Indikators as $indikator) {
            $CekData = SupervisiWakaKesiswaan::where('indikator_id', $indikator->id)
                ->where('tapel_id', $request->tapel_id)
                ->where('semester', $request->semester)
                ->where('bidang', $request->bidang)
                ->count();
            // dd($CekData);

            if ($CekData > 0) {
                continue;
            }
            $lastSupervisi = SupervisiWakaKesiswaan::create([
                'tapel_id' => $request->tapel_id,
                'detailguru_id' => $detailGuru->id,
                'indikator_id' => $indikator->id,
                'semester' => $request->input('semester'),
                'detailguru_id' => 1,
                'ketersediaan' => null,
                'bidang' => $request->bidang,
                'nilai' => null,
                'keterangan' => null,
                'analisis' => null,
            ]);
        }
        $lastSupervisi = SupervisiWakaKesiswaan::latest()->first();
        if (!$lastSupervisi) {
            $lastSupervisi = SupervisiWakaKesiswaan::latest('id')->first();
        }

        // Jika tetap tidak ada data, kembalikan error
        if (!$lastSupervisi) {
            return redirect()->back()->with('error', 'Tidak ada data yang tersimpan.');
        }
        // dd($lastSupervisi->tapel_id, $request->all());

        // Debugging: Pastikan ID tidak null
        // dd($lastSupervisi);
        return redirect()->route('supervisi-waka-kesiswaan.show', [
            'supervisi_waka_kesiswaan' => $lastSupervisi->tapel_id, // Pastikan ini tidak null
            'tapel_id' => $request->tapel_id,
            'semester' => $request->semester,
            'bidang' => $request->bidang
        ]);
    }
    public function update(Request $request, $id)
    {
        try {
            // Validasi request
            $validated = $request->validate([
                'field' => 'required|string|in:ketersediaan,nilai,keterangan',
                'value' => 'nullable|string|max:255',
            ]);

            // Cari data berdasarkan ID
            $supervisi = SupervisiWakaKesiswaan::findOrFail($id);

            // Update data dengan field yang dikirim
            $supervisi->update([$validated['field'] => $validated['value']]);

            return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui!']);
        } catch (\Exception $e) {
            Log::error('Error updating data: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memperbarui data.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $tapel_id)
    {
        //SupervisiWakaKesiswaan
        // dd($id);
        // dd($request->all());
        $deleted = SupervisiWakaKesiswaan::where('tapel_id', $tapel_id)->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'Semua data dengan tapel_id ' . $tapel_id . ' telah dihapus!');
        } else {
            return redirect()->back()->with('error', 'Data tidak ditemukan atau gagal dihapus.');
        }
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
