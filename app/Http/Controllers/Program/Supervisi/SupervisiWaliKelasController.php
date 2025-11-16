<?php

namespace App\Http\Controllers\Program\Supervisi;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Admin\Identitas;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Supervisi\SupervisiWaliKelas;
use App\Models\Program\Supervisi\SupervisiInstrument;
use App\Models\User\Siswa\Detailsiswa;

class SupervisiWaliKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Supervisi Wali Kelas';
        $arr_ths = [
            'Kelas',
            'Nama Wali Kelas',
            'Jumlah Siswa',
            'Skor Supervisi',
        ];
        $breadcrumb = 'Data Supervisi / Data Supervisi Wali Kelas';
        $titleviewModal = 'Lihat Data Supervisi Wali Kelas';
        $titleeditModal = 'Edit Data Supervisi Wali Kelas';
        $titlecreateModal = 'Create Data Supervisi Wali Kelas';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SupervisiWaliKelas::where('tapel_id', $etapels->id)->get();
        $datas = Ekelas::with('supervisiWaliKelas')
            ->where('tapel_id', $etapels->id)
            ->get();
        $DataSiswa = \App\Models\User\Siswa\Detailsiswa::get();



        return view('role.program.supervisi.supervisi-wali-kelas', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DataSiswa',
        ));
        //php artisan make:view role.program.supervisi.supervisi-wali-kelas

    }

    public function show($id, Request $request)
    {
        //
        //Title to Controller
        // dd($request->all());
        $title = 'Data Supervisi Wali Kelas';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Supervisi / Data Supervisi Wali Kelas';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SupervisiWaliKelas::where('tapel_id', $etapels->id)->get();

        // dd($request->bidang);
        $Instrumens = \App\Models\Program\Supervisi\SupervisiInstrument::where('bidang', $request->bidang)
            ->join('supervisi_wali_kelas', function ($join) use ($request) {
                $join->on('supervisi_instrument.id', '=', 'supervisi_wali_kelas.indikator_id')
                    ->where('supervisi_wali_kelas.tapel_id', $request->tapel_id)
                    ->where('supervisi_wali_kelas.semester', $request->semester)
                    ->where('supervisi_wali_kelas.kelas_id', $request->supervisi_wali_kela);
            })
            ->select('supervisi_instrument.*', 'supervisi_wali_kelas.*')
            ->orderBy('supervisi_instrument.id')
            ->get()
            ->groupBy('kategori');
        $Identitas = Identitas::first();
        $DataKelas = Ekelas::where('id', request()->supervisi_wali_kela)->first();
        // dump($DataKelas);
        $DataMapel = Emapel::where('id', request()->mapel_id)->first();
        $Guru = Detailguru::where('id', request()->detailguru_id)->first();
        $Tapels = Etapel::where('aktiv', 'Y')->first();
        $totalNilai = 0;
        $DataSiswa = \App\Models\User\Siswa\Detailsiswa::get();
        // dd($Instrumens);
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.supervisi.supervisi-wali-kelas-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'Identitas',
            'DataKelas',
            'DataMapel',
            'Guru',
            'Tapels',
            'totalNilai',
            'Instrumens',
            'DataSiswa',
        ));
        //php artisan make:view role.program.supervisi.supervisi-wali-kelas-single
    }
    public function SaveSaranSupervisiWalkes(Request $request)
    {
        dd($request->all());
        $SaranSupervisi = SupervisiWaliKelas::find();
        SupervisiWaliKelas::create([
            'catatan' => $request->catatan
        ]);

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
            'kelas_id' => 'required|integer',
        ]);

        $Indikators = SupervisiInstrument::where('bidang', $request->bidang)->get();

        foreach ($Indikators as $indikator) {
            $CekData = SupervisiWaliKelas::where('indikator_id', $indikator->id)
                ->where('kelas_id', $request->kelas_id)
                ->where('tapel_id', $request->tapel_id)
                ->where('semester', $request->semester)
                ->count();
            // dd($CekData);

            if ($CekData > 0) {
                continue;
            }
            $lastSupervisi = SupervisiWaliKelas::create([
                'tapel_id' => $request->tapel_id,
                'indikator_id' => $indikator->id,
                'kelas_id' => $request->input('kelas_id'),
                'semester' => $request->input('semester'),
                'ketersediaan' => null,
                'nilai' => null,
                'keterangan' => null,
                'analisis' => null,
            ]);
        }
        $lastSupervisi = SupervisiWaliKelas::latest()->first();
        if (!$lastSupervisi) {
            $lastSupervisi = SupervisiWaliKelas::latest('id')->first();
        }

        // Jika tetap tidak ada data, kembalikan error
        if (!$lastSupervisi) {
            return redirect()->back()->with('error', 'Tidak ada data yang tersimpan.');
        }


        // Debugging: Pastikan ID tidak null
        // dd($lastSupervisi);
        return redirect()->route('supervisi-wali-kelas.show', [
            'supervisi_wali_kela' => $lastSupervisi->kelas_id, // Pastikan ini tidak null
            'tapel_id' => $request->tapel_id,
            'semester' => $request->semester,
            'bidang' => 'Wali Kelas'
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
            $supervisi = SupervisiWaliKelas::findOrFail($id);

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
    public function destroy($id)
    {
        //SupervisiWaliKelas
        // dd($id);
        // dd($request->all());
        $data = SupervisiWaliKelas::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
