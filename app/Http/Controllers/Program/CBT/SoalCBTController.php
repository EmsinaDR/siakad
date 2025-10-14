<?php

namespace App\Http\Controllers\Program\CBT;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Admin\Identitas;
use Illuminate\Support\Facades\DB;
use App\Models\Program\CBT\SoalCBT;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Program\CBT\BankSoal;
use Illuminate\Support\Facades\Auth;
use App\Models\Program\CBT\CBTJadwal;
use App\Models\Program\CBT\JawabanCBT;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SoalCBTController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Soal CBT';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Soal CBT Test / Soal CBT';
        $titleviewModal = 'Lihat Data Soal CBT';
        $titleeditModal = 'Edit Data Soal CBT';
        $titlecreateModal = 'Create Data Soal CBT';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = '';
        $Jadwal = CBTJadwal::first();
        $Identitas = Identitas::first();
        $soals = BankSoal::whereIn('id', $Jadwal->soal_id)->get();

        // 🔥 Ambil jawaban user yang sudah tersimpan$user_id = Auth::id();
        $user_id = Auth::id();
        // array dari jawaban sebelumnya: soal_id => jawaban
        $jawaban_terisi = JawabanCBT::where('user_id', $user_id)
            ->where('test_id', $Jadwal->id)
            ->pluck('jawaban', 'soal_id')
            ->toArray();

        $jawaban_terisi = null;
        return view('role.program.cbt.cbt-soal', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'soals',
            'Jadwal',
            'Identitas',
            'jawaban_terisi' // <== dikirim ke view
        ));
    }
    public function selesai()
    {
        $Identitas = Identitas::first();
        return view(
            'role.program.cbt.cbt-selesai',
            compact(
                'Identitas',
            )
        );
    }

    public function submit(Request $request)
    {
        // dd($request->all());
        // Ambil data dari request
        $jawabanUser = $request->input('jawaban');
        $userId = $request->input('user_id');
        $mapelId = $request->input('mapel_id');
        $detailguruId = $request->input('detailguru_id');
        $testId = $request->input('test_id'); // Pastikan test_id ada

        // Validasi test_id
        if (!$testId) {
            return redirect()->back()->withErrors('Test ID tidak valid.');
        }

        $skor = 0;
        $totalSoal = count($jawabanUser);

        foreach ($jawabanUser as $soalId => $jawaban) {
            // Temukan soal berdasarkan soal_id
            $soal = BankSoal::find($soalId);
            if (!$soal) continue;

            // Cek apakah jawaban benar atau tidak
            $isBenar = strtoupper($jawaban) === strtoupper($soal->kunci_jawaban);
            if ($isBenar) {
                $skor++;
            }

            // Simpan jawaban ke dalam database
            JawabanCBT::create([
                'user_id' => $userId,
                'soal_id' => $soalId,
                'mapel_id' => $mapelId,
                'detailguru_id' => $detailguruId,
                'test_id' => $testId, // Pastikan test_id disertakan
                'jawaban' => strtoupper($jawaban),
                'benar' => $isBenar,
            ]);
        }

        // Hitung skor akhir
        $skorAkhir = ($totalSoal > 0) ? round(($skor / $totalSoal) * 100, 2) : 0;
        // Redirect ke halaman selesai dengan pesan sukses
        return redirect()->route('cbt.selesai')->with('success', "Ujian selesai! Nilai Anda: $skorAkhir");
    }
    public function autosave(Request $request)
    {

        try {
            $soal = BankSoal::find($request->soal_id);

            if (!$soal) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Soal tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $userJawaban = strtoupper($request->jawaban);
            $kunciJawaban = strtoupper($soal->kunci);
            $Siswa = Detailsiswa::where('user_id', $request->user_id)->first();
            $isCorrect = $userJawaban === $kunciJawaban;

            // Simpan jawaban
            $jawaban = JawabanCBT::updateOrCreate(
                [
                    'user_id' => $Siswa->id,
                    'soal_id' => $request->user_id,
                    'test_id' => $request->test_id,
                ],
                [
                    'jawaban' => $userJawaban,
                    'benar' => $isCorrect,
                    'mapel_id' => $request->mapel_id,
                    'detailguru_id' => $request->detailguru_id,
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Jawaban berhasil disimpan',
                'data' => [
                    'soal_id' => $soal->id,
                    'jawaban_user' => $userJawaban,
                    'kunci_soal' => $kunciJawaban,
                    'benar' => $isCorrect,
                    'jawaban_terakhir' => $jawaban
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }




    public function show($id)
    {
        // Cek apakah timer sudah habis
        if (session()->has('cbt_timer_expired_' . $id)) {
            // Redirect jika waktu habis dan status timer expired ada di session
            return redirect()->route('cbt.waktu-habis'); // Ganti dengan route halaman waktu habis
        }

        // Ambil data untuk judul dan variabel lainnya
        $title = 'Soal CBT';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Soal CBT Test / Soal CBT';
        $titleviewModal = 'Lihat Data Soal CBT';
        $titleeditModal = 'Edit Data Soal CBT';
        $titlecreateModal = 'Create Data Soal CBT';
        $routeName = \Illuminate\Support\Facades\Route::currentRouteName();

        // Ambil jadwal berdasarkan ID
        $Jadwal = CBTJadwal::find($id);
        // dd($Jadwal);
        // Cek apakah jadwal ada
        if (!$Jadwal) {
            abort(404); // Mengembalikan 404 jika jadwal tidak ditemukan
        }

        // Ambil identitas dan soal
        $Identitas = Identitas::first();
        $soals = BankSoal::whereIn('id', $Jadwal->soal_id)->get();

        // Ambil jawaban yang sudah ada dari user
        $user_id = Auth::id();
        $jawaban_terisi = JawabanCBT::where('user_id', $user_id)
            ->where('test_id', $Jadwal->id)
            ->pluck('jawaban', 'soal_id')
            ->toArray();

        // Kirim data ke view
        return view('role.program.cbt.cbt-soal', compact(
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'soals',
            'Jadwal',
            'Identitas',
            'jawaban_terisi'
        ));
    }


    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            //data_field_validator
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }



        SoalCBT::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, SoalCBT $datasoalcbt)
    {
        //

        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            //data_field_validator
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $varmodel = SoalCBT::find($id); // Pastikan $id didefinisikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($validator->validated());
            return Redirect::back()->with('Title', 'Berhasil')->with('success', 'Data Berhasil di Update');
        } else {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Data tidak ditemukan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //SoalCBT
        // dd($id);
        // dd($request->all());
        $data = SoalCBT::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
    public function submitTestCbt(Request $request)
    {
        $id = $request->id;

        // Simpan ID ke session untuk melacak jika form sudah disubmit
        session()->put('test_id', $id);

        // Redirect setelah form disubmit agar tidak bisa submit lagi jika refresh halaman
        return redirect()->route('role.program.cbt.cbt-soal', ['id' => $id])->with('status', 'Test sudah diproses');
    }
    public function showSoalCbt($id)
    {
        // Mengambil data yang diperlukan berdasarkan ID
        $Jadwal = CBTJadwal::find($id);
        $Identitas = Identitas::first();
        $soals = BankSoal::whereIn('id', $Jadwal->soal_id)->get();
        // Mengambil jawaban yang sudah ada dari user
        $user_id = Auth::id();
        $jawaban_terisi = JawabanCBT::where('user_id', $user_id)
            ->where('test_id', $Jadwal->id)
            ->pluck('jawaban', 'soal_id')
            ->toArray();

        return view('role.program.cbt.cbt-soal', compact(
            'Jadwal',
            'Identitas',
            'soals',
            'jawaban_terisi'
        ));
    }


    public function submitTestCbtx(Request $request)
    {


        $title = 'Soal CBT';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Soal CBT Test / Soal CBT';
        $titleviewModal = 'Lihat Data Soal CBT';
        $titleeditModal = 'Edit Data Soal CBT';
        $titlecreateModal = 'Create Data Soal CBT';
        $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
        // dd($routeName); // Output: 'absensi.data'
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = '';
        // dd($request->id);
        $id = $request->id;
        $Jadwal = CBTJadwal::find($id);
        $Identitas = Identitas::first();
        $soals = BankSoal::whereIn('id', $Jadwal->soal_id)->get();

        // 🔥 Ambil jawaban user yang sudah tersimpan$user_id = Auth::id();
        $user_id = Auth::id();
        // array dari jawaban sebelumnya: soal_id => jawaban
        $jawaban_terisi = JawabanCBT::where('user_id', $user_id)
            ->where('test_id', $Jadwal->id)
            ->pluck('jawaban', 'soal_id')
            ->toArray();


        return view('role.program.cbt.cbt-soal', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'soals',
            'Jadwal',
            'Identitas',
            'jawaban_terisi' // <== dikirim ke view
        ));
    }
}
