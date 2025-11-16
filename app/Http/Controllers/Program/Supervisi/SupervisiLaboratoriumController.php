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

class SupervisiLaboratoriumController extends Controller
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

php artisan make:view role.program.supervisi.supervisi-laboratorium
php artisan make:view role.program.supervisi.supervisi-laboratorium-single
php artisan make:model Program/Supervisi/SupervisiLaboratorium
php artisan make:controller Program/Supervisi/SupervisiLaboratoriumController --resource



php artisan make:seeder Program/Supervisi/SupervisiLaboratoriumSeeder
php artisan make:migration Migration_SupervisiLaboratorium




*/
    /*
    SupervisiLaboratorium
    $suplabs
    role.program.supervisi
    role.program.supervisi.supervisi-laboratorium
    role.program.supervisi.blade_show
    Index = Data Supervisi Laboratorium
    Breadcume Index = 'Data Supervisi / Data Supervisi Laboratorium';
    Single = Data Supervisi Laboratorium
    php artisan make:view role.program.supervisi.supervisi-laboratorium
    php artisan make:view role.program.supervisi.supervisi-laboratorium-single
    php artisan make:seed SupervisiLaboratoriumSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Supervisi Laboratorium';
        $arr_ths = [
            'Nama Laboratorium',
            'Penanggung Jawab',
        ];
        $breadcrumb = 'Data Supervisi / Data Supervisi Laboratorium';
        $titleviewModal = 'Lihat Data Supervisi Laboratorium';
        $titleeditModal = 'Edit Data Supervisi Laboratorium';
        $titlecreateModal = 'Create Data Supervisi Laboratorium';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // $datas = SupervisiLaboratorium::where('tapel_id', $etapels->id)->get();
        $datas = RiwayatLaboratorium::where('tapel_id', $etapels->id)->get();
        // dump($datas);



        return view('role.program.supervisi.supervisi-laboratorium', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.supervisi.supervisi-laboratorium

    }


    public function show($id, Request $request)
    {
        //
        //Title to Controller
        // dd($request->all());
        $title = 'Data Supervisi Laboratorium';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Supervisi / Data Supervisi Laboratorium';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SupervisiLaboratorium::where('tapel_id', $etapels->id)->get();
        //where('bidang', 'Laboratorium')->get();
        // dd($id);
        $Instrumens = \App\Models\Program\Supervisi\SupervisiInstrument::where('bidang', 'Laboratorium')
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
        // dd($Instrumens);
        $Identitas = Identitas::first();
        $DataKelas = Ekelas::where('id', request()->kelas_id)->first();
        $DataMapel = Emapel::where('id', request()->mapel_id)->first();
        $Guru = Detailguru::where('id', request()->detailguru_id)->first();
        $Tapels = Etapel::where('aktiv', 'Y')->first();
        $totalNilai = 0;

        // Loop untuk menghitung total nilai berdasarkan nilai yang dikirim
        // foreach ($Instrumens as $kategori => $indikatorList) {
        //     foreach ($indikatorList as $indikator) {
        //         $kode = substr($indikator->nilai, 0, 1); // Ambil angka pertama sebagai kode posisi
        //         $nilai = substr($indikator->nilai, 1); // Sisanya sebagai nilai input

        //         // Pastikan $nilai adalah integer
        //         $nilai = intval($nilai); // Mengonversi ke integer jika berupa string

        //         $totalNilai += $nilai; // Menjumlahkan nilai
        //     }
        // }

        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.supervisi.supervisi-laboratorium-single', compact(
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
        //php artisan make:view role.program.supervisi.supervisi-laboratorium-single
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

        $Indikators = SupervisiInstrument::where('bidang', 'Laboratorium')->get();
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
        return redirect()->route('supervisi-laboratorium.show', [
            'supervisi_laboratorium' => $lastSupervisi->laboratorium_id, // Pastikan ini tidak null
            'tapel_id' => $request->tapel_id,
            'semester' => $request->semester,
            'kategori' => 'Laboratorium'
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
/*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
php artisan migrate:fresh --seed


composer dump-autoload

*/