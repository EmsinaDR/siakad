<?php

namespace App\Http\Controllers\Program\Supervisi;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Admin\Identitas;
use App\Models\Learning\Emengajar;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Supervisi\SupervisiInstrument;
use App\Models\Program\Supervisi\SupervisiPembelajaran;

class SupervisiPembelajaranController extends Controller
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




     */
    /*
    SupervisiPembelajaran
    $spemb
    role.program.supervisi
    role.program.supervisi.supervisi-pembelajaran
    role.program.supervisi.blade_show
    Index = Data Supervisi Pembelajaran
    Breadcume Index = 'Supervisi / Data Supervisi Pembelajaran';
    Single = Data Supervisi Pembelajaran
    php artisan make:view role.program.supervisi.supervisi-pembelajaran
    php artisan make:view role.program.supervisi.supervisi-pembelajaran-single
    php artisan make:seed SupervisiPembelajaranSeeder



    */

    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Supervisi Pembelajaran';
        $arr_ths = [
            'Nama Guru',
            'Mapel',
            'Kelas',
        ];
        $Identitas = Identitas::first();
        $breadcrumb = 'Supervisi / Data Supervisi Pembelajaran';
        $titleviewModal = 'Lihat Data Supervisi Pembelajaran';
        $titleeditModal = 'Edit Data Supervisi Pembelajaran';
        $titlecreateModal = 'Create Data Supervisi Pembelajaran';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SupervisiPembelajaran::where('tapel_id', $etapels->id)->get();
        $datas = Emengajar::where('tapel_id', $etapels->id)->get();

        $datas = Emengajar::where('tapel_id', $etapels->id)->get()
            ->groupBy('tingkat_id') // Kelompokkan berdasarkan tingkat_id
            ->map(function ($group) {
                return $group->unique('detailguru_id')->values(); // Hilangkan duplikat berdasarkan detailguru_id
            });



        return view('role.program.supervisi.supervisi-pembelajaran', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'Identitas',
        ));
        //php artisan make:view role.program.supervisi.supervisi-pembelajaran

    }
    public function create()
    {
        //dd($request->all());
        $title = 'Data Supervisi Pembelajaran';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $Identitas = Identitas::first();
        $DataKelas = Ekelas::where('id', request()->kelas_id)->first();
        $DataMapel = Emapel::where('id', request()->mapel_id)->first();
        $breadcrumb = 'Supervisi / Data Supervisi Pembelajaran';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $Tapels = Etapel::where('aktiv', 'Y')->first();
        $Guru = Detailguru::where('id', request()->detailguru_id)->first();
        $datas = SupervisiInstrument::where('kategori', 'Pelaksanaan Pembelajaran')->get();


        return view('role.program.supervisi.supervisi-pembelajaran-create', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'Identitas',
            'Guru',
            'Tapels',
            'DataKelas',
            'DataMapel',
        ));
    }

    public function show($id, Request $request)
    {
        //
        //Title to Controller
        $title = 'Data Supervisi Pembelajaran';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Supervisi / Data Supervisi Pembelajaran';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SupervisiPembelajaran::where('tapel_id', $request->tapel_id)
            ->where('semester', $request->semester)
            ->where('kelas_id', $request->kelas_id)
            ->where('mapel_id', $request->mapel_id)
            ->where('detailguru_id', $request->detailguru_id)
            ->get();

        $Instrumens = \App\Models\Program\Supervisi\SupervisiInstrument::where('kategori', 'Pelaksanaan Pembelajaran')
            ->join('supervisi_pembelajaran', 'supervisi_instrument.id', '=', 'supervisi_pembelajaran.indikator_id')
            ->select('supervisi_instrument.*', 'supervisi_pembelajaran.*')
            // ->distinct()
            ->OrderBy('id')
            ->get()
            ->groupBy('sub_kategori');

        $Identitas = Identitas::first();
        $DataKelas = Ekelas::where('id', request()->kelas_id)->first();
        $DataMapel = Emapel::where('id', request()->mapel_id)->first();
        $Guru = Detailguru::where('id', request()->detailguru_id)->first();
        $Tapels = Etapel::where('aktiv', 'Y')->first();

        $datas = SupervisiPembelajaran::where('tapel_id', $request->tapel_id)
            ->where('semester', $request->semester)
            ->where('kelas_id', $request->kelas_id)
            ->where('mapel_id', $request->mapel_id)
            ->where('detailguru_id', $request->detailguru_id)
            ->get()
            ->groupBy('kategori'); // Kelompokkan berdasarkan kategori

        $Instrumens = \App\Models\Program\Supervisi\SupervisiInstrument::where('kategori', 'Pelaksanaan Pembelajaran')
            ->join('supervisi_pembelajaran', function ($join) use ($request) {
                $join->on('supervisi_instrument.id', '=', 'supervisi_pembelajaran.indikator_id')
                    ->where('supervisi_pembelajaran.tapel_id', $request->tapel_id)
                    ->where('supervisi_pembelajaran.semester', $request->semester)
                    ->where('supervisi_pembelajaran.kelas_id', $request->kelas_id)
                    ->where('supervisi_pembelajaran.mapel_id', $request->mapel_id)
                    ->where('supervisi_pembelajaran.detailguru_id', $request->detailguru_id);
            })
            ->select('supervisi_instrument.*', 'supervisi_pembelajaran.*')
            ->orderBy('supervisi_instrument.id')
            ->get()
            ->groupBy('sub_kategori')
            ->map(function ($group) {
                // Kelompokkan berdasarkan sub_kategori dan urutkan berdasarkan ID
                return $group->sortBy('id')->groupBy('sub_kategori')
                    ->map(function ($subGroup) {
                        // Kelompokkan berdasarkan sub_sub_kategori dan urutkan berdasarkan ID
                        return $subGroup->sortBy('id')->groupBy('sub_sub_kategori')
                            ->map(function ($subSubGroup) {
                                // Urutkan berdasarkan ID di dalam sub_sub_kategori
                                return $subSubGroup->sortBy('id');
                            });
                    });
            });
        return view('role.program.supervisi.supervisi-pembelajaran-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'Instrumens',
            // 'Identitas',
            'DataKelas',
            'DataMapel',
            'Guru',
            'Tapels',
        ));
        //php artisan make:view role.program.supervisi.supervisi-pembelajaran-single
    }

    public function store(Request $request)
    {
        // Validasi data

        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);
        $request->validate([
            'tapel_id' => 'required|integer',
            'detailguru_id' => 'required|integer',
            'detailguru_id' => 'string',
        ]);

        $Indikators = SupervisiInstrument::where('kategori', 'Pelaksanaan Pembelajaran')->get();
        $firstId = null; // Inisialisasi variabel ID pertama
        $lastSupervisi = null;

        foreach ($Indikators as $indikator) {
            $CekData = SupervisiPembelajaran::where('indikator_id', $indikator->id)
                ->where('kelas_id', $request->kelas_id)
                ->where('mapel_id', $request->mapel_id)
                ->where('tapel_id', $request->tapel_id)
                ->where('semester', $request->semester)
                ->count();

            if ($CekData > 0) {
                continue;
            }

            $lastSupervisi = SupervisiPembelajaran::create([
                'tapel_id' => $request->tapel_id,
                'detailguru_id' => $request->input('detailguru_id'),
                'indikator_id' => $indikator->id,
                'kelas_id' => $request->input('kelas_id'),
                'mapel_id' => $request->input('mapel_id'),
                'semester' => $request->input('semester'),
                'ketersediaan' => null,
                'nilai' => null,
                'keterangan' => null,
                'analisis' => null,
            ]);
        }

        // Jika tidak ada data yang baru tersimpan, ambil ID terakhir dari database
        if (!$lastSupervisi) {
            $lastSupervisi = SupervisiPembelajaran::latest('id')->first();
        }

        if (!$lastSupervisi) {
            return redirect()->back()->with('error', 'Tidak ada data yang tersimpan.');
        }

        return redirect()->route('supervisi-pembelajaran.show', [
            'supervisi_pembelajaran' => $lastSupervisi->id, // Pastikan ini tidak null
            'detailguru_id' => $request->input('detailguru_id'),
            'tapel_id' => $request->tapel_id,
            'semester' => $request->semester,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'kategori' => 'pembelajaran'
        ]);
    }
    public function update(Request $request, $id)
    {
        try {
            // Validasi request
            $validated = $request->validate([
                'field' => 'required|string',
                'value' => 'required|string',
            ]);

            // Cari data berdasarkan ID
            $indicator = SupervisiPembelajaran::find($id);

            // Cek apakah data ditemukan
            if (!$indicator) {
                return response()->json(['success' => false, 'message' => 'Indikator tidak ditemukan']);
            }

            // Update sesuai field yang dikirimkan
            $indicator->{$validated['field']} = $validated['value'];

            // Cek apakah perubahan berhasil disimpan
            if ($indicator->save()) {
                return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui']);
            } else {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data']);
            }
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
        //SupervisiPembelajaran
        // dd($request->all());
        $data = SupervisiPembelajaran::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
    public function analisis()
    {
        //dd($request->all());
        $title = 'Data Supervisi Pembelajaran';
        $arr_ths = [
            'Indikator',
            'Mapel',
            'Kelas',
        ];
        $Identitas = Identitas::first();
        $breadcrumb = 'Supervisi / Data Analisis Supervisi Pembelajaran';
        $titleviewModal = 'Lihat Data Supervisi Pembelajaran';
        $titleeditModal = 'Edit Data Supervisi Pembelajaran';
        $titlecreateModal = 'Create Data Supervisi Pembelajaran';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $InstrumenIds = SupervisiInstrument::where('kategori', 'Pelaksanaan Pembelajaran')->pluck('id');

        $datas = SupervisiPembelajaran::whereIn('indikator_id', $InstrumenIds)
            ->where('nilai', '<=', 2)
            ->groupBy('indikator_id')
            ->get();
        return view('role.program.supervisi.supervisi-pembelajaran-analisis', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'Identitas',
        ));
    }
}
