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
use App\Models\Program\Supervisi\SupervisiATP;
use App\Models\Program\Supervisi\SupervisiInstrument;

class SupervisiATPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
/*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view role.program.supervisi.supervisi-atp
php artisan make:view role.program.supervisi.supervisi-atp-single
php artisan make:model Program/Supervisi/SupervisiATP
php artisan make:controller Program/Supervisi/SupervisiATPController --resource



php artisan make:seeder Program/Supervisi/SupervisiATPSeeder
php artisan make:migration Migration_SupervisiATP




*/
    /*
    SupervisiATP
    $SupervisiATP
    role.program.supervisi
    role.program.supervisi.supervisi-atp
    role.program.supervisi.blade_show
    Index = Data Supervisi ATP
    Breadcume Index = 'Data Supervisi / Data Supervisi ATP';
    Single = Data Supervisi ATP
    php artisan make:view role.program.supervisi.supervisi-atp
    php artisan make:view role.program.supervisi.supervisi-atp-single
    php artisan make:seed SupervisiATPSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Supervisi ATP';
        $arr_ths = [
            'Nama Guru',
            'Mapel',
            'Kelas',
        ];
        $breadcrumb = 'Data Supervisi / Data Supervisi ATP';
        $titleviewModal = 'Lihat Data Supervisi ATP';
        $titleeditModal = 'Edit Data Supervisi ATP';
        $titlecreateModal = 'Create Data Supervisi ATP';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // $datas = SupervisiATP::where('tapel_id', $etapels->id)->get();

        $datas = Emengajar::where('tapel_id', $etapels->id)->get()
            ->groupBy('tingkat_id') // Kelompokkan berdasarkan tingkat_id
            ->map(function ($group) {
                return $group->unique('detailguru_id')->values(); // Hilangkan duplikat berdasarkan detailguru_id
            });


        return view('role.program.supervisi.supervisi-atp', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.supervisi.supervisi-atp

    }


    public function show($id, Request $request)
    {
        //
        //Title to Controller
        $title = 'Data Supervisi Perangkat';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Supervisi Guru / Data Supervisi Perangkat';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // dd($request->detailguru_id);
        $datas = SupervisiATP::where('tapel_id', $request->tapel_id)
            ->where('semester', $request->semester)
            ->where('kelas_id', $request->kelas_id)
            ->where('mapel_id', $request->mapel_id)
            ->where('detailguru_id', $request->detailguru_id)
            ->get();
        // dd($datas);
        // $Instrumens = SupervisiInstrument::where('kategori', 'Alur Tujuan Pembelajaran')->get()->groupBy('sub_kategori');

        // Gabungkan data dari SupervisiInstrument dengan join dan pastikan tidak ada duplikasi

        $Instrumens = \App\Models\Program\Supervisi\SupervisiInstrument::where('kategori', 'Alur Tujuan Pembelajaran')
            ->join('supervisi_pembelajaran', 'supervisi_instrument.id', '=', 'supervisi_pembelajaran.indikator_id')
            ->select('supervisi_instrument.*', 'supervisi_pembelajaran.*')
            ->distinct()
            ->OrderBy('id')
            ->get()
            ->groupBy('sub_kategori');

        $Identitas = Identitas::first();
        $DataKelas = Ekelas::where('id', request()->kelas_id)->first();
        $DataMapel = Emapel::where('id', request()->mapel_id)->first();
        $Guru = Detailguru::where('id', request()->detailguru_id)->first();
        $Tapels = Etapel::where('aktiv', 'Y')->first();
        // Ambil data berdasarkan filter yang diberikan
        // Ambil data berdasarkan filter yang diberikan
        // dd($request->detailguru_id);
        // $datas = SupervisiATP::where('tapel_id', $request->tapel_id)
        //     ->where('semester', $request->semester)
        //     ->where('kelas_id', $request->kelas_id)
        //     ->where('mapel_id', $request->mapel_id)
        //     ->where('detailguru_id', $request->detailguru_id)
        //     ->get();

        // // Gabungkan data berdasarkan kategori dan sub-kategori, menggunakan relasi jika perlu
        // $Instrumens = SupervisiInstrument::where('kategori', 'Alur Tujuan Pembelajaran')
        //     ->join('supervisi_pembelajaran', 'supervisi_instrument.id', '=', 'supervisi_pembelajaran.indikator_id')
        //     ->select('supervisi_instrument.*', 'supervisi_pembelajaran.*')
        //     ->orderBy('supervisi_instrument.kategori')  // Urutkan berdasarkan kategori
        //     ->orderBy('supervisi_instrument.sub_kategori')  // Urutkan berdasarkan sub_kategori
        //     ->orderBy('supervisi_instrument.sub_sub_kategori')  // Urutkan berdasarkan sub_sub_kategori
        //     ->orderBy('supervisi_instrument.id')  // Pastikan urutkan berdasarkan ID
        //     ->get()
        //     ->groupBy('kategori')  // Mengelompokkan berdasarkan kategori
        //     ->map(function ($group) {
        //         // Kelompokkan berdasarkan sub_kategori dan urutkan berdasarkan ID
        //         return $group->sortBy('id')->groupBy('sub_kategori')
        //             ->map(function ($subGroup) {
        //                 // Kelompokkan berdasarkan sub_sub_kategori dan urutkan berdasarkan ID
        //                 return $subGroup->sortBy('id')->groupBy('sub_sub_kategori')
        //                     ->map(function ($subSubGroup) {
        //                         // Urutkan berdasarkan ID di dalam sub_sub_kategori
        //                         return $subSubGroup->sortBy('id');
        //                     });
        //             });
        //     });

        // dd($Instrumens);
        // dd($datas->toSql(), $query->getBindings(), $request->all());

        // 'detailguru_id' => $request->input('detailguru_id'),
        //             'tapel_id' => $request->tapel_id,
        //             'semester' => $request->semester,
        //             'mapel_id' => $request->mapel_id,
        //             'kelas_id' => $request->kelas_id,
        //             'kategori' => 'pembelajaran'

        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'


        $datas = SupervisiATP::where('tapel_id', $request->tapel_id)
            ->where('semester', $request->semester)
            ->where('kelas_id', $request->kelas_id)
            ->where('mapel_id', $request->mapel_id)
            ->where('detailguru_id', $request->detailguru_id)
            ->get();

        $Instrumens = \App\Models\Program\Supervisi\SupervisiInstrument::where('kategori', 'Alur Tujuan Pembelajaran')
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
            ->groupBy('sub_kategori'); // Kelompokkan berdasarkan kategori

        $totalNilai = 0;

        // Loop untuk menghitung total nilai berdasarkan nilai yang dikirim
        foreach ($Instrumens as $kategori => $indikatorList) {
            foreach ($indikatorList as $indikator) {
                $kode = substr($indikator->nilai, 0, 1); // Ambil angka pertama sebagai kode posisi
                $nilai = substr($indikator->nilai, 1); // Sisanya sebagai nilai input

                // Pastikan $nilai adalah integer
                $nilai = intval($nilai); // Mengonversi ke integer jika berupa string

                $totalNilai += $nilai; // Menjumlahkan nilai
            }
        }
        // dd($kategori);


        // Kirim data ke view
        return view('role.program.supervisi.supervisi-atp-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'Instrumens',
            'Identitas',
            'DataKelas',
            'DataMapel',
            'Guru',
            'Tapels',
            'totalNilai',
        ));



        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.supervisi.supervisi-atp-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.program.supervisi.supervisi-atp-guru-single
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

        $Indikators = SupervisiInstrument::where('kategori', 'Alur Tujuan Pembelajaran')->get();
        $firstId = null; // Inisialisasi variabel ID pertama
        $lastSupervisi = null;

        foreach ($Indikators as $indikator) {
            $CekData = SupervisiATP::where('indikator_id', $indikator->id)
                ->where('kelas_id', $request->kelas_id)
                ->where('mapel_id', $request->mapel_id)
                ->where('tapel_id', $request->tapel_id)
                ->where('semester', $request->semester)
                ->count();

            if ($CekData > 0) {
                continue;
            }

            $lastSupervisi = SupervisiATP::create([
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
            $lastSupervisi = SupervisiATP::latest('id')->first();
        }

        if (!$lastSupervisi) {
            return redirect()->back()->with('error', 'Tidak ada data yang tersimpan.');
        }

        // Debugging: Pastikan ID tidak null
        // dd($lastSupervisi);


        return redirect()->route('supervisi-atp-guru.show', [
            'supervisi_atp_guru' => $lastSupervisi->id, // Pastikan ini tidak null
            'detailguru_id' => $request->input('detailguru_id'),
            'tapel_id' => $request->tapel_id,
            'semester' => $request->semester,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'kategori' => 'pembelajaran'
        ]);
    }
    // app/Http/Controllers/IndicatorController.php
    public function update(Request $request, $id)
    {
        try {
            // Validasi request
            $validated = $request->validate([
                'nilai' => 'nullable|string',  // Bisa kosong, karena mungkin hanya update keterangan
                'keterangan' => 'nullable|string|max:255',
            ]);

            // Cari data berdasarkan ID
            $indicator = SupervisiATP::find($id);

            if (!$indicator) {
                return response()->json(['success' => false, 'message' => 'Indikator tidak ditemukan'], 404);
            }

            // Update data jika dikirim
            if ($request->has('nilai')) {
                $indicator->nilai = $validated['nilai'];
            }
            if ($request->has('keterangan')) {
                $indicator->keterangan = $validated['keterangan'];
            }

            // Simpan perubahan
            if ($indicator->save()) {
                return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui!']);
            } else {
                return response()->json(['success' => false, 'message' => 'Gagal menyimpan data']);
            }
        } catch (\Exception $e) {
            Log::error('Error updating data: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memperbarui data.'], 500);
        }
    }

    public function destroy($id)
    {
        //SupervisiATP
        // dd($id);
        // dd($request->all());
        $data = SupervisiATP::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
