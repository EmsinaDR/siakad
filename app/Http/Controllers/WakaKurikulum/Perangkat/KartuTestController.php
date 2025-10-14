<?php

namespace App\Http\Controllers\WakaKurikulum\Perangkat;

use Carbon\Carbon;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WakaKurikulum\Perangkat\KartuTest;
use App\Models\WakaKurikulum\Perangkat\JadwalTest;
use App\Models\WakaKurikulum\Perangkat\PesertaTest;

class KartuTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Waka Kurikulum';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad'
        ];
        $breadcrumb = 'Waka / Kartu Test';
        $titleviewModal = 'Lihat Data Waka Kurikulum';
        $titleeditModal = 'Edit Data Waka Kurikulum';
        $titlecreateModal = 'Create Data Waka Kurikulum';
        $datas = PesertaTest::limit(50)->get();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $Jadwaltest = JadwalTest::where('tapel_id', $etapels->id)->get();
        // $jadwal = JadwalTest::select('tanggal_pelaksanaan', 'mapel_id')
        //     ->orderBy('tanggal_pelaksanaan', 'asc')
        //     ->get()
        //     ->unique('tanggal_pelaksanaan') // Hapus duplikasi tanggal
        //     ->map(function ($item) {
        //         return [
        //             'hari' => \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('l'),
        //             'tanggal' => \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y'),
        //             'mata_pelajaran' => optional($item->Mapel)->mapel ?? '-', // Ambil nama mapel jika ada
        //             'jam' => '08:00 - 09:30', // Bisa diubah sesuai data sebenarnya
        //         ];
        //     })->values(); // Reset indeks array

        // $jadwal = JadwalTest::with('Mapel')
        //     ->select('tanggal_pelaksanaan', 'mapel_id')
        //     ->orderBy('tanggal_pelaksanaan', 'asc')
        //     ->get()
        //     ->groupBy('tanggal_pelaksanaan') // Kelompokkan berdasarkan tanggal
        //     ->map(function ($group, $tanggal) {
        //         return [
        //             'hari' => \Carbon\Carbon::parse($tanggal)->translatedFormat('l'),
        //             'tanggal' => \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y'),
        //             'jadwal' => $group->map(function ($item) {
        //                 return [
        //                     'jam' => '08:00 - 09:30', // Sesuaikan dengan data asli
        //                     'mata_pelajaran' => optional($item->Mapel)->mapel ?? '-',
        //                 ];
        //             }),
        //         ];
        //     })
        //     ->values(); // Reset indeks array

        $jadwal = JadwalTest::with('Mapel')
            ->select('tanggal_pelaksanaan', 'mapel_id', 'jam') // Pastikan 'jam' disertakan di select()
            ->orderBy('tanggal_pelaksanaan', 'asc')
            ->get()
            ->groupBy('tanggal_pelaksanaan')
            ->map(function ($group, $tanggal) {
                return [
                    'hari' => \Carbon\Carbon::parse($tanggal)->translatedFormat('l'),
                    'tanggal' => \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y'),
                    'jadwal' => $group->map(function ($item) {
                        return [
                            'jam' => $item->jam ?? '-', // Pastikan ada data jam
                            'mata_pelajaran' => optional($item->Mapel)->mapel ?? '-',
                        ];
                    })->unique('mata_pelajaran')->values(),
                ];
            })
            ->values();


        // $datas = PesertaTest::get();

        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.kartu-test', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'jadwal',
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(KartuTest $kartuTest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KartuTest $kartuTest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KartuTest $kartuTest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KartuTest $kartuTest)
    {
        //
    }
}
