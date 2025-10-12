<?php

namespace App\Http\Controllers\Program\Supervisi;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Admin\Identitas;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Program\Supervisi\Jadwal\JadwalSupervisiPerpustakaan;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Supervisi\SupervisiInstrument;
use App\Models\Program\Supervisi\SupervisiPerpustakaan;

class SupervisiPerpustakaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view role.role.program.supervisi.supervisi-perpustakaan
php artisan make:view role.role.program.supervisi.supervisi-perpustakaan-single
php artisan make:model Program/Supervisi/SupervisiPerpustakaan
php artisan make:controller Program/Supervisi/SupervisiPerpustakaanController --resource



php artisan make:seeder Program/Supervisi/SupervisiPerpustakaanSeeder
php artisan make:migration Migration_SupervisiPerpustakaan




*/
    /*
    SupervisiPerpustakaan
    $supperpus
    role.program.supervisi
    role.program.supervisi.supervisi-perpustakaan
    role.program.supervisi.blade_show
    Index = Data Supervisi Perpustakaan
    Breadcume Index = 'Data Supervisi / Data Supervisi Perpustakaan';
    Single = Data Supervisi Perpustakaan
    php artisan make:view role.program.supervisi.supervisi-perpustakaan
    php artisan make:view role.program.supervisi.supervisi-perpustakaan-single
    php artisan make:seed SupervisiPerpustakaanSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Supervisi Perpustakaan';
        $arr_ths = [
            'Tahun Pelajaran',
            'Petugas',
            'Indikator',
            'Skor Supervisi',
        ];
        $breadcrumb = 'Data Supervisi / Data Supervisi Perpustakaan';
        $titleviewModal = 'Lihat Data Supervisi Perpustakaan';
        $titleeditModal = 'Edit Data Supervisi Perpustakaan';
        $titlecreateModal = 'Create Data Supervisi Perpustakaan';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SupervisiPerpustakaan::where('tapel_id', $etapels->id)->groupBy('tapel_id')->get();
        $Instrumens = SupervisiInstrument::where('bidang', 'Perpustakaan')->count();




        return view('role.program.supervisi.supervisi-perpustakaan', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'Instrumens',
        ));
        //php artisan make:view role.program.supervisi.supervisi-perpustakaan

    }


    public function show($id, Request $request)
    {
        //
        //Title to Controller
        $title = 'Data Supervisi Perpustakaan';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Supervisi / Data Supervisi Perpustakaan';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $Tapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SupervisiPerpustakaan::where('tapel_id', $Tapels->id)->get();
        $Instrumens = \App\Models\Program\Supervisi\SupervisiInstrument::where('bidang', $request->bidang)
            ->join('supervisi_perpustakaan', function ($join) use ($request) {
                $join->on('supervisi_instrument.id', '=', 'supervisi_perpustakaan.indikator_id')
                    ->where('supervisi_perpustakaan.tapel_id', $request->tapel_id)
                    ->where('supervisi_perpustakaan.semester', $request->semester);
            })
            ->select('supervisi_instrument.*', 'supervisi_perpustakaan.*')
            ->orderBy('supervisi_instrument.id')
            ->get()
            ->groupBy('kategori');

        $Tapels = Etapel::where('aktiv', 'Y')->first();
        $totalNilai = 0;

        $PetugasIds = $datas->first();
        $PetugasId = Detailguru::where('id', $PetugasIds->detailguru_id)->first();
        // dd($PetugasId, $PetugasIds->detailguru_id, $PetugasIds);

        $Guru = Detailguru::where('id', request()->detailguru_id)->first();
        $DataSiswa = \App\Models\User\Siswa\Detailsiswa::get();
        $Identitas = Identitas::first();
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.supervisi.supervisi-perpustakaan-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'Identitas',
            // 'DataMapel',
            'Guru',
            'Tapels',
            'totalNilai',
            'Instrumens',
            'DataSiswa',
            'PetugasId',
        ));
        //php artisan make:view role.program.supervisi.supervisi-perpustakaan-single
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

        $Indikators = SupervisiInstrument::where('bidang', $request->bidang)->get();

        foreach ($Indikators as $indikator) {
            $CekData = SupervisiPerpustakaan::where('indikator_id', $indikator->id)
                ->where('tapel_id', $request->tapel_id)
                ->where('semester', $request->semester)
                ->count();
            // dd($CekData);

            if ($CekData > 0) {
                continue;
            }
            $SupervisiJadwal = JadwalSupervisiPerpustakaan::where('tapel_id', $etapels->id)->first();

            // dd($SupervisiJadwal->petugas_id);
            $lastSupervisi = SupervisiPerpustakaan::create([
                'tapel_id' => $request->tapel_id,
                'indikator_id' => $indikator->id,
                'detailguru_id' => $SupervisiJadwal->petugas_id,
                'semester' => $request->input('semester'),
                'ketersediaan' => null,
                'nilai' => null,
                'keterangan' => null,
                'analisis' => null,
            ]);
        }
        $lastSupervisi = SupervisiPerpustakaan::latest()->first();
        if (!$lastSupervisi) {
            $lastSupervisi = SupervisiPerpustakaan::latest('id')->first();
        }

        // Jika tetap tidak ada data, kembalikan error
        if (!$lastSupervisi) {
            return redirect()->back()->with('error', 'Tidak ada data yang tersimpan.');
        }


        // Debugging: Pastikan ID tidak null
        // dd($lastSupervisi);
        return redirect()->route('supervisi-perpustakaan.show', [
            'supervisi_perpustakaan' => $lastSupervisi->tapel_id, // Pastikan ini tidak null
            'tapel_id' => $request->tapel_id,
            'semester' => $request->semester,
            'bidang' => 'Perpustakaan'
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
            $supervisi = SupervisiPerpustakaan::findOrFail($id);

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
        //SupervisiPerpustakaan
        // dd($id);
        // dd($request->all());
        $deleted = SupervisiPerpustakaan::where('tapel_id', $tapel_id)->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'Semua data dengan tapel_id ' . $tapel_id . ' telah dihapus!');
        } else {
            return redirect()->back()->with('error', 'Data tidak ditemukan atau gagal dihapus.');
        }
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
