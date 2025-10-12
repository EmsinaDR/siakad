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
use App\Models\Laboratorium\RiwayatLaboratorium;
use App\Models\Program\Supervisi\SupervisiLaboran;
use App\Models\Program\Supervisi\SupervisiInstrument;
use App\Models\Program\Supervisi\SupervisiLaboratorium;

class SupervisiLaboranController extends Controller
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

php artisan make:view role.program.supervisi.supervisi-laboran
php artisan make:view role.program.supervisi.supervisi-laboran-single
php artisan make:model Program/Supervisi/SupervisiLaboran
php artisan make:controller Program/Supervisi/SupervisiLaboranController --resource



php artisan make:seeder Program/Supervisi/SupervisiLaboranSeeder
php artisan make:migration Migration_SupervisiLaboran




*/
    /*
    SupervisiLaboran
    $suplaboran
    role.program.supervisi
    role.program.supervisi.supervisi-laboran
    role.program.supervisi.blade_show
    Index = Data Supervisi Laboran
    Breadcume Index = 'Data Supervisi / Data Supervisi Laboran';
    Single = Data Supervisi Laboran
    php artisan make:view role.program.supervisi.supervisi-laboran
    php artisan make:view role.program.supervisi.supervisi-laboran-single
    php artisan make:seed SupervisiLaboranSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Supervisi Laboran';
        $arr_ths = [
            'Nama Laboratorium',
            'Penanggung Jawab',
        ];
        $breadcrumb = 'Data Supervisi / Data Supervisi Laboran';
        $titleviewModal = 'Lihat Data Supervisi Laboran';
        $titleeditModal = 'Edit Data Supervisi Laboran';
        $titlecreateModal = 'Create Data Supervisi Laboran';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SupervisiLaboran::where('tapel_id', $etapels->id)->get();
        // $datas = SupervisiLaboratorium::where('tapel_id', $etapels->id)->get();
        $datas = RiwayatLaboratorium::where('tapel_id', $etapels->id)->get();

        return view('role.program.supervisi.supervisi-laboran', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.supervisi.supervisi-laboran

    }


    public function show($id, Request $request)
    {
        //
        //Title to Controller
        $title = 'Data Supervisi Laboran';
        $arr_ths = [
            'Nama Laboratorium',
            'Penanggung Jawab',
        ];
        $breadcrumb = 'Data Supervisi / Data Supervisi Laboran';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SupervisiLaboran::where('tapel_id', $etapels->id)->get();

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SupervisiLaboratorium::where('tapel_id', $etapels->id)->get();
        //where('bidang', 'Laboran')->get();
        // dd($id);
        $Instrumens = \App\Models\Program\Supervisi\SupervisiInstrument::where('bidang', 'Laboran')
            ->join('supervisi_laboratorium', function ($join) use ($request, $id) {
                $join->on('supervisi_instrument.id', '=', 'supervisi_laboratorium.indikator_id')
                    ->where('supervisi_laboratorium.tapel_id', $request->tapel_id)
                    ->where('supervisi_laboratorium.semester', $request->semester)
                    ->where('supervisi_laboratorium.laboratorium_id', $id);
            })
            ->select('supervisi_instrument.*', 'supervisi_laboratorium.*')
            ->orderBy('supervisi_instrument.id')
            ->get()
            ->groupBy('kategori');

        // dd($datas);
        // dump($Instrumens);
        $Identitas = Identitas::first();
        $DataKelas = Ekelas::where('id', request()->kelas_id)->first();
        $DataMapel = Emapel::where('id', request()->mapel_id)->first();
        $Guru = Detailguru::where('id', request()->detailguru_id)->first();
        $Tapels = Etapel::where('aktiv', 'Y')->first();
        $totalNilai = 0;
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.supervisi.supervisi-laboran-single', compact(
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
        ));
        //php artisan make:view role.program.supervisi.supervisi-laboran-single
    }

    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
        ]);

        // Validasi data
        $request->validate([
            'tapel_id' => 'required|integer',
            'laboratorium_id' => 'required|integer',
        ]);

        $Indikators = SupervisiInstrument::where('bidang', 'Laboran')->get();
        // dd($Indikators);
        foreach ($Indikators as $indikator) {
            $CekData = SupervisiLaboratorium::where('indikator_id', $indikator->id)
                ->where('laboratorium_id', $request->laboratorium_id)
                ->where('tapel_id', $request->tapel_id)
                ->where('semester', $request->semester)
                ->count();

            if ($CekData > 0) {
                continue;
            }
            // dd($request->all(), $indikator);
            // dd($request->input('laboratorium_id'));
            // dd($indikator);
            // dd($CekData);
            $lastSupervisi = SupervisiLaboratorium::create([
                'tapel_id' => $request->tapel_id,
                'indikator_id' => $indikator->id,
                'laboratorium_id' => $request->input('laboratorium_id'),
                'semester' => $request->input('semester'),
                'ketersediaan' => null,
                'nilai' => null,
                'keterangan' => null,
                'analisis' => null,
            ]);
        }
        $lastSupervisi = SupervisiLaboratorium::latest()->first();

        // dd($request->all());
        // Jika tidak ada data yang baru tersimpan, ambil ID terakhir dari database
        // $lastSupervisi = $lastSupervisis->last();

        // Jika tidak ada data baru yang tersimpan, coba ambil data terakhir dari database
        if (!$lastSupervisi) {
            $lastSupervisi = SupervisiLaboratorium::latest('id')->first();
        }

        // Jika tetap tidak ada data, kembalikan error
        if (!$lastSupervisi) {
            return redirect()->back()->with('error', 'Tidak ada data yang tersimpan.');
        }


        // Debugging: Pastikan ID tidak null
        // dd($lastSupervisi);
        return redirect()->route('supervisi-laboran.show', [
            'supervisi_laboran' => $lastSupervisi->laboratorium_id, // Pastikan ini tidak null
            'tapel_id' => $request->tapel_id,
            'semester' => $request->semester,
            'kategori' => 'Laboran'
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
            $supervisi = SupervisiLaboratorium::findOrFail($id);

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
        //SupervisiLaboratorium
        // dd($id);
        // dd($request->all());
        $data = SupervisiLaboratorium::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
