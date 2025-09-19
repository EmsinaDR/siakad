<?php

namespace App\Http\Controllers\WakaKurikulum\Perangkat;

use App\Models\PesertaTest;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\Perangkat\PerangkatTest;

class PerangkatTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Perangkat Test';
        $arr_ths = [
            'Nama Dokumen',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad'
        ];
        $breadcrumb = 'Waka Kurikulum / Perangkat Test';
        $titleviewModal = 'Lihat Data Perangkat Test';
        $titleeditModal = 'Edit Data Perangkat Test';
        $titlecreateModal = 'Create Data Perangkat Test';


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.index', compact('title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
    // public function PesertaTest(Request $request)
    // {
    //     if ($request->isMethod('get')) {

    //     } elseif ($request->isMethod('post')) {


    //         $etapels = Etapel::where('aktiv', 'Y')->first();
    //         // $detasiswa = Detailsiswa::where('id', $detailsiswa_id)->first();
    //         // Ambil semua data Detailsiswa yang memenuhi kondisi kelas_id tidak null
    //         $detasiswas = Detailsiswa::whereNotNull('kelas_id')->get();

    //         // Loop setiap data Detailsiswa
    //         foreach ($detasiswas as $detasiswa) {
    //             // Data input dari request (bisa dari $request jika menggunakan Laravel Controller)
    //             $kelas = Ekelas::where('id', $detasiswa->kelas_id)->first();
    //             static $no_urut = 1; // Nomor urut awal
    //             // dd($detasiswa->id);
    //             // dd($kelas->tingkat_id);
    //             $input = [
    //                 // 'nomor_ruangan' => $request->nomor_ruangan ?? '01',
    //                 'tapel_id' => $etapels->id,
    //                 'semester' => $etapels->semester,
    //                 'test' => $request->test ?? 'Ujian Tengah Semester',
    //                 'nama_siswa' => $detasiswa->nama_siswa,
    //                 'kelas_id' => $detasiswa->kelas_id,
    //                 'detailsiswa_id' => $detasiswa->id,
    //                 'tingkat_id' => $kelas->tingkat_id,
    //                 'nomor_urut' => sprintf('%03d', $no_urut++),
    //             ];

    //             // Aturan validasi
    //             $rules = [
    //                 // 'nomor_ruangan' => 'required|string',
    //                 'tapel_id' => 'required|numeric',
    //                 'detailsiswa_id' => 'required|numeric',
    //                 'semester' => 'required|string|max:255',
    //                 'test' => 'required|string',
    //                 'nama_siswa' => 'required|string',
    //                 'kelas_id' => 'required|integer',

    //                 'tingkat_id' => 'required|integer',
    //                 'nomor_urut' => 'required|string',
    //             ];

    //             // Buat Validator
    //             $validator = Validator::make($input, $rules);

    //             // Periksa apakah validasi gagal
    //             if ($validator->fails()) {
    //                 // Jika gagal, tampilkan error (atau bisa simpan log / abaikan data)
    //                 continue; // Lewati data yang tidak valid
    //             }

    //             // Ambil data yang telah divalidasi
    //             $validatedData = $validator->validated();

    //             // Tambahkan nomor test yang diformat


    //             // $validatedData['nomor_test'] = sprintf('%03d', $no_urut++) . ' / R' . $validatedData['nomor_ruangan'] . ' / ' . $validatedData['test'] . ' / ' . $detasiswa->kelas_id . ' / ' . date('Y');

    //             // Simpan data ke PesertaTest
    //             PesertaTest::create($validatedData);
    //         }

    //         // Kembalikan respons atau redirect
    //         // return redirect()->route('pesertatest.index')->with('success', 'Data peserta test berhasil ditambahkan');




    //         // dd($request->all());
    //         // $numbers = range(1, 50);
    //         // foreach ($request->detailsiswa_id as $detailsiswa_id) {
    //         //     # code...
    //         //     $etapels = Etapel::where('aktiv', 'Y')->first();
    //         //     $detasiswa = Detailsiswa::where('id', $detailsiswa_id)->first();
    //         //     // dd($detasiswa->kelas_id);
    //         //     $no_urut = 1; // Pastikan ada angka awal yang ditentukan

    //         //     $request->merge([
    //         //         'tapel_id' => $etapels->id,
    //         //         'semester' => $etapels->semester,
    //         //         'kelas_id' => $detasiswa->kelas_id,
    //         //         'tingkat_id' => $detasiswa->Detailsiswatokelas->tingkat_id,
    //         //         'detailsiswa_id' => $detailsiswa_id,
    //         //         'nomor_test' => sprintf('%03d', $no_urut++) . ' / R' . $request->nomor_ruangan . ' / ' . $request->test . ' / ' . $detasiswa->Detailsiswatokelas->kelas . ' / ' . date('Y'),
    //         //     ]);

    //         //     // Validasi data
    //         //     $validator = Validator::make($request->all(), [
    //         //         'test' => 'required|string|max:255',
    //         //         'nomor_ruangan' => 'required|numeric|min:0|max:100',
    //         //         'detailsiswa_id' => 'required|numeric',
    //         //         'tapel_id' => 'required|numeric',
    //         //         'semester' => 'required|string|max:255',
    //         //         'kelas_id' => 'required|numeric',
    //         //         'tingkat_id' => 'required|numeric',
    //         //         'nomor_test' => 'required|string|max:255',
    //         //     ]);

    //         //     if ($validator->fails()) {
    //         //         return redirect()->back()
    //         //             ->withErrors($validator)
    //         //             ->withInput();
    //         //     }
    //         //     PesertaTest::create($validator->validated());

    //         dd($request->all());
    //         // }
    //         return "Ini adalah POST request";
    //     } elseif ($request->isMethod('destroy')) {
    //     }
    // }
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
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(PerangkatTest $perangkatTest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerangkatTest $perangkatTest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerangkatTest $perangkatTest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerangkatTest $perangkatTest)
    {
        //
    }
}
