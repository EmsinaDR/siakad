<?php

namespace App\Http\Controllers\WakaKurikulum\Perangkat;

use Illuminate\Support\Facades\Log;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\Perangkat\PesertaTest;

class PesertaTestController extends Controller
{
    //
    public function index()
    {
        //dd($request->all());


        //Title to Controller
        $title = 'Peserta Test';
        $arr_ths = [
            'NIS',
            'Nama',
            'Kelas',
            'Nomor Test',
            'Ruang Ujian'
        ];
        $breadcrumb = 'Waka Kurikulum / Perangkat Test / Peserta';
        $titleviewModal = 'Lihat Data Peserta Test';
        $titleeditModal = 'Edit Data Peserta Test';
        $titlecreateModal = 'Create Data Peserta Test';

        $datas = PesertaTest::orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_vii = PesertaTest::where('tingkat_id', 7)->orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_viii = PesertaTest::where('tingkat_id', 8)->orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_ix = PesertaTest::where('tingkat_id', 9)->orderBy('kelas_id', 'ASC')->get();
        // dd($datas_kelas_vii);
        $group_by_ruang = PesertaTest::orderBy('nomor_ruangan', 'ASC')
            ->get()
            ->groupBy('nomor_ruangan');
        //Pasangan Tempat Duduk
        $group_by_ruang = PesertaTest::orderBy('nomor_ruangan', 'ASC')->get()->groupBy('nomor_ruangan');

        $paired_data = [];

        foreach ($group_by_ruang as $ruang => $pesertas) {
            $count = count($pesertas);
            $mid = ceil($count / 2);

            $first_half = $pesertas->slice(0, $mid)->values();
            $second_half = $pesertas->slice($mid)->values();

            for ($i = 0; $i < count($second_half); $i++) {
                $paired_data[$ruang][] = [
                    'first' => $first_half[$i],
                    'second' => $second_half[$i]
                ];
            }

            // Jika ada sisa di first_half (karena jumlah ganjil), tambahkan ke pasangan sendiri
            if (count($first_half) > count($second_half)) {
                $paired_data[$ruang][] = [
                    'first' => $first_half[count($second_half)],
                    'second' => null
                ];
            }
        }

        //Pasangan Tempat Duduk

        $datas_kartu_test = PesertaTest::limit(50)->get();
        // dd($datas_kartu_test);



        // Tentukan jumlah maksimum baris agar sejajar
        $max_rows = max($datas_kelas_vii->count(), $datas_kelas_viii->count(), $datas_kelas_ix->count());
        // dd($max_rows);
        return view('role.waka.kurikulum.peserta-test', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'datas_kelas_vii',
            'datas_kelas_viii',
            'datas_kelas_ix',
            'max_rows',
            'group_by_ruang',
            'datas_kartu_test',
            'paired_data',
        ));
    }
    public function update()
    {
        //dd($request->all());
        // body_method
    }
    public function destroy($id)
    {
        //PesertaTest
        // dd(id);
        // dd(request->all());
        $VarPesertaTest = PesertaTest::findOrFail($id);
        $VarPesertaTest->delete();

        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
    public function PesertaTest()
    {
        //Generate or copy siswa
        //dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // $detasiswa = Detailsiswa::where('id', $detailsiswa_id)->first();
        // Ambil semua data Detailsiswa yang memenuhi kondisi kelas_id tidak null
        $detasiswas = Detailsiswa::whereNotNull('kelas_id')->orderBy('kelas_id', 'ASC')->orderBy('nama_siswa', 'ASC')->get();

        // Loop setiap data Detailsiswa
        foreach ($detasiswas as $detasiswa) {
            // Data input dari request (bisa dari $request jika menggunakan Laravel Controller)
            $kelas = Ekelas::where('id', $detasiswa->kelas_id)->first();
            static $no_urut = 1; // Nomor urut awal
            // dd($detasiswa->id);
            // dd($kelas->tingkat_id);
            $input = [
                // 'nomor_ruangan' => $request->nomor_ruangan ?? '01',
                'tapel_id' => $etapels->id,
                'semester' => $etapels->semester,
                'test' => $request->test ?? 'Ujian Tengah Semester',
                'nama_siswa' => $detasiswa->nama_siswa,
                'kelas_id' => $detasiswa->kelas_id,
                'detailsiswa_id' => $detasiswa->id,
                'tingkat_id' => $kelas->tingkat_id,
                'nomor_urut' => sprintf('%03d', $no_urut++),
            ];

            // Aturan validasi
            $rules = [
                // 'nomor_ruangan' => 'required|string',
                'tapel_id' => 'required|numeric',
                'detailsiswa_id' => 'required|numeric',
                'semester' => 'required|string|max:255',
                'test' => 'required|string',
                'nama_siswa' => 'required|string',
                'kelas_id' => 'required|integer',

                'tingkat_id' => 'required|integer',
                'nomor_urut' => 'required|string',
            ];

            // Buat Validator
            $validator = Validator::make($input, $rules);

            // Periksa apakah validasi gagal
            if ($validator->fails()) {
                // Jika gagal, tampilkan error (atau bisa simpan log / abaikan data)
                continue; // Lewati data yang tidak valid
            }

            // Ambil data yang telah divalidasi
            $validatedData = $validator->validated();

            // Tambahkan nomor test yang diformat


            // $validatedData['nomor_test'] = sprintf('%03d', $no_urut++) . ' / R' . $validatedData['nomor_ruangan'] . ' / ' . $validatedData['test'] . ' / ' . $detasiswa->kelas_id . ' / ' . date('Y');

            // Simpan data ke PesertaTest
            PesertaTest::create($validatedData);
        }

        // Kirim response JSON dengan flash message
        Session::flash('Title', 'Berhasil!');
        Session::flash('Success', 'Data siswa siap digunakan');
        return redirect()->back()->with([
            'flashMessage' => json_encode([
                'title' => 'Sukses',
                'message' => 'Data Berhasil Disimpan',
                'icon' => 'success'
            ])
        ]);
    }


    // public function updateRuangTest(Request $request)
    // {
    //     try {
    //         // Validate incoming data
    //         $request->validate([
    //             'siswa_ids' => 'required|array',
    //             'siswa_ids.*' => 'integer|exists:test_peserta,id',
    //             'nomor_ruangan' => 'required|string',
    //         ]);

    //         // If validation fails, return error
    //         if ($validator->fails()) {
    //             return response()->json(['error' => 'Validation failed.'], 422);
    //         }

    //         // Proceed with the update logic
    //         foreach ($request->siswa_ids as $siswa_id) {
    //             DB::table('test_peserta')
    //                 ->where('id', $siswa_id)
    //                 ->update(['nomor_ruangan' => $request->nomor_ruangan]);
    //         }

    //         // Return success response
    //         return response()->json([
    //             'flash' => [
    //                 'title' => 'Berhasil!',
    //                 'success' => 'Ruang test berhasil diperbarui.',
    //             ],
    //         ]);
    //     } catch (\Exception $e) {
    //         // Log the error and return a response
    //         \Log::error('Error updating ruang test:', ['error' => $e->getMessage()]);
    //         return response()->json(['error' => 'Gagal memperbarui ruang test!'], 500);
    //     }
    // }
    public function updateRuangTest(Request $request)
    {
        // dd($request->all());
        try {
            // Log data yang diterima untuk memeriksa apakah data sampai dengan benar
            Log::info('Data diterima:', $request->all());

            // Proses update data ke database
            foreach ($request->siswa_ids as $siswa_id) {
                PesertaTest::where('id', $siswa_id)
                    ->update(['nomor_ruangan' => $request->nomor_ruangan]);
            }

            // Kembalikan respons sukses
            return response()->json([
                'flash' => [
                    'title' => 'Berhasil!',
                    'success' => 'Ruang test berhasil diperbarui.',
                ],
            ]);
        } catch (\Exception $e) {
            // Log error jika terjadi kesalahan
            Log::error('Gagal update:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Gagal memperbarui ruang test!'], 500);
        }
    }

    public function RuangTest(Request $request)
    {
        $siswa_ids = $request->siswa_ids; // Ambil array ID siswa
        $etapels = Etapel::where('aktiv', 'Y')->first();

        if ($siswa_ids && count($siswa_ids) > 0) {
            $nomor_ruangan = $request->nomor_ruangan;

            foreach ($siswa_ids as $index => $siswa_id) {
                // Ambil data siswa untuk mendapatkan kelasnya
                $siswa = PesertaTest::with('PesertaTestToKelas')->find($siswa_id);
                if (!$siswa) continue; // Jika siswa tidak ditemukan, lewati

                $kelas = $siswa->PesertaTestToKelas->kelas ?? 'Tidak Diketahui'; // Hindari error jika kelas null

                // Cek jika nomor urut belum ada, berikan nilai default
                $nomor_urut = $siswa->nomor_urut ?? $index + 1;

                // Format nomor test
                $nomor_test = $nomor_urut . ' / ' . $etapels->semester . ' / ' . $nomor_ruangan . ' / ' . $kelas . ' / ' . date('Y');

                // Update siswa dengan nomor ruangan dan nomor test

                $siswa->update([
                    'nomor_ruangan' => $nomor_ruangan,
                    'nomor_test' => $nomor_test,
                ]);
            }
            // return Redirect::back()->with('Title', 'pesan_title')->with('Success', 'pesan_success');
            // return response()->back()->with('Title', 'pesan_title')->with('Success', 'pesan_success');
            // Kirim response JSON dengan flash message
            Session::flash('Title', 'Berhasil!');
            Session::flash('Success', 'Ruang test dan nomor test berhasil diperbarui!');

            return response()->json([
                // 'message' => 'Ruang test dan nomor test berhasil diperbarui!',
                'flash' => [
                    'title' => session('Title'),
                    'success' => session('Success')
                ]
            ]);
            // return response()->json(['message' => 'Ruang test dan nomor test berhasil diperbarui!']);
        }

        return response()->json(['message' => 'Siswa tidak ditemukan!'], 404);
    }
    // Jadwal Test
    public function RuangTestview()
    {
        //dd($request->all());
        $title = 'Peserta Test';
        $arr_ths = [
            'NIS',
            'Nama',
            'Kelas',
            'Nomor Test',
            'Ruang Ujian'
        ];
        $breadcrumb = 'Waka Kurikulum / Perangkat Test / Peserta';
        $titleviewModal = 'Lihat Data Peserta Test';
        $titleeditModal = 'Edit Data Peserta Test';
        $titlecreateModal = 'Create Data Peserta Test';

        $datas = PesertaTest::orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_vii = PesertaTest::where('tingkat_id', 7)->orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_viii = PesertaTest::where('tingkat_id', 8)->orderBy('kelas_id', 'ASC')->get();
        $datas_kelas_ix = PesertaTest::where('tingkat_id', 9)->orderBy('kelas_id', 'ASC')->get();
        $group_by_ruang = PesertaTest::orderBy('nomor_ruangan', 'ASC')
            ->get()
            ->groupBy('nomor_ruangan');
        dd($group_by_ruang);
        // dd($group_by_ruang);
        //Pasangan Tempat Duduk
        $group_by_ruang = PesertaTest::orderBy('nomor_ruangan', 'ASC')->get()->groupBy('nomor_ruangan');

        $paired_data = [];

        foreach ($group_by_ruang as $ruang => $pesertas) {
            $count = count($pesertas);
            $mid = ceil($count / 2);

            $first_half = $pesertas->slice(0, $mid)->values();
            $second_half = $pesertas->slice($mid)->values();

            for ($i = 0; $i < count($second_half); $i++) {
                $paired_data[$ruang][] = [
                    'first' => $first_half[$i],
                    'second' => $second_half[$i]
                ];
            }

            // Jika ada sisa di first_half (karena jumlah ganjil), tambahkan ke pasangan sendiri
            if (count($first_half) > count($second_half)) {
                $paired_data[$ruang][] = [
                    'first' => $first_half[count($second_half)],
                    'second' => null
                ];
            }
        }

        //Pasangan Tempat Duduk

        $datas_kartu_test = PesertaTest::limit(50)->get();
        // dd($datas_kartu_test);



        // Tentukan jumlah maksimum baris agar sejajar
        $max_rows = max($datas_kelas_vii->count(), $datas_kelas_viii->count(), $datas_kelas_ix->count());
        return view(
            'role.waka.kurikulum.perangkattest.ruang-test',
            compact(
                'datas',
                'title',
                'arr_ths',
                'breadcrumb',
                'titleviewModal',
                'titleeditModal',
                'titlecreateModal',
                'datas_kelas_vii',
                'datas_kelas_viii',
                'datas_kelas_ix',
                'max_rows',
                'group_by_ruang',
                'datas_kartu_test',
                'paired_data',
            )
        );
        /*

    role.waka.kurikulum.peserta-test
php artisan make:view role.waka.kurikulum.perangkattest.ruang-test
    */
    }

    public function getSiswaByTingkat(Request $request)
    {
        $tingkat_id = $request->tingkat_id;

        // Ambil siswa berdasarkan tingkat_id
        $siswa = PesertaTest::orderBy('kelas_id', 'ASC')->orderBy('nama_siswa', 'ASC')->whereHas('Kelas', function ($query) use ($tingkat_id) {
            $query->where('tingkat_id', $tingkat_id);
        })->with('Kelas', 'Siswa')->get(); // Pastikan relasi ke `Siswa` ada

        // Format data untuk Select2
        $data = $siswa->map(function ($item) {
            return [
                'id' => $item->id,
                'nama_siswa' => $item->Siswa->nama_siswa, // Pastikan ada relasi `Siswa`
                'kelas' => $item->Kelas->kelas
            ];
        });

        return response()->json($data);
    }

}
