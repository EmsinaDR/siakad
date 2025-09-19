<?php

namespace App\Http\Controllers\Program\CBT;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Program\CBT\CBTJadwal;
use App\Models\Program\CBT\JawabanCBT;
use Illuminate\Support\Facades\Session;
use App\Models\Program\CBT\AnalisisTest;
use App\Models\Program\CBT\BankSoal;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AnalisisTestController extends Controller
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

php artisan make:view role.program.cbt.analisis-test
php artisan make:view role.program.cbt.analisis-test-single
php artisan make:model Program/CBT/AnalisisTest
php artisan make:controller Program/CBT/AnalisisTestController --resource



php artisan make:seeder Program/CBT/AnalisisTestSeeder
php artisan make:migration Migration_AnalisisTest




*/
    /*
    AnalisisTest
    $dtanalisistest
    role.program.cbt
    role.program.cbt.analisis-test
    role.program.cbt.blade_show
    Index = Data Analisis Test
    Breadcume Index = 'Data Analisis Soal / Data Analisis Test';
    Single = titel_data_single
    php artisan make:view role.program.role.program.cbt.analisis-test
    php artisan make:view role.program.role.program.cbt.analisis-test-single
    php artisan make:seed AnalisisTestSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Analisis Test';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Analisis Soal / Data Analisis Test';
        $titleviewModal = 'Lihat Data Analisis Test';
        $titleeditModal = 'Edit Data Analisis Test';
        $titlecreateModal = 'Create Data Analisis Test';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = AnalisisTest::where('tapel_id', $etapels->id)->get();
        $datas = CBTJadwal::where('tapel_id', $etapels->id)->get();


        return view('role.program.cbt.analisis-test', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.cbt.analisis-test

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Analisis Test';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Analisis Soal / Data Analisis Test';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = AnalisisTest::where('tapel_id', $etapels->id)->get();

        $datas = JawabanCBT::first();  // Semua jawaban siswa
        // Ambil semua data jawaban siswa
        $datas = JawabanCBT::where('test_id', 1)->get();  // Semua jawaban siswa
        // Ambil semua soal
        $Jadwal = CBTJadwal::where('id', 1)->first();
        // dd($Jadwal);
        $soals = BankSoal::whereIn('id', $Jadwal->soal_id)->get();    // Semua soal
        // Ambil jawaban benar per soal
        $correctAnswers = $soals->pluck('kunci', 'id')->toArray();  // Jawaban benar per soal

        // Menyiapkan array untuk jawaban siswa
        $jawaban_siswa = [];

        // Proses mengumpulkan jawaban siswa
        foreach ($datas as $jawaban) {
            $siswa_id = $jawaban->user_id;
            $soal_id = $jawaban->soal_id;
            $jawaban_siswa[$siswa_id][$soal_id] = $jawaban->jawaban;
        }
        // Proses mengumpulkan jawaban siswa beserta nama siswa
        foreach ($datas as $jawaban) {
            $siswa_id = $jawaban->user_id;  // Ambil ID siswa dari jawaban
            $soal_id = $jawaban->soal_id;  // Ambil ID soal dari jawaban

            // Ambil nama siswa dari relasi 'Siswa'
            $nama_siswa = $jawaban->Siswa->nama_siswa;  // Menggunakan relasi 'Siswa' untuk mendapatkan nama siswa

            // Menyimpan jawaban dan nama siswa ke dalam array
            $jawaban_siswa[$siswa_id]['nama_siswa'] = $nama_siswa;  // Menambahkan nama siswa
            $jawaban_siswa[$siswa_id][$soal_id] = $jawaban->jawaban;
        }

        // Menyiapkan array untuk menghitung jawaban benar dan salah per soal
        $correctAnswersCount = [];
        $wrongAnswersCount = [];

        // Hitung jawaban benar dan salah per soal
        foreach ($soals as $soal) {
            // Inisialisasi jumlah benar dan salah untuk setiap soal
            $correctAnswersCount[$soal->id] = 0;
            $wrongAnswersCount[$soal->id] = 0;

            // Periksa jawaban siswa per soal
            foreach ($jawaban_siswa as $siswa_id => $jawaban) {
                // Pastikan siswa sudah memberikan jawaban untuk soal ini
                if (isset($jawaban[$soal->id])) {
                    // Bandingkan jawaban siswa dengan jawaban yang benar
                    if ($jawaban[$soal->id] === $correctAnswers[$soal->id]) {
                        // Jika jawaban benar, tambahkan ke jumlah benar
                        $correctAnswersCount[$soal->id]++;
                    } else {
                        // Jika jawaban salah, tambahkan ke jumlah salah
                        $wrongAnswersCount[$soal->id]++;
                    }
                }
            }
        }
        // Hitung jumlah siswa
        $jml_siswa = count($jawaban_siswa);  // Menghitung jumlah siswa yang memberikan jawaban


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.cbt.analisis-test-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'jawaban_siswa',
            'soals',
            'correctAnswersCount',
            'wrongAnswersCount',
            'jml_siswa',
        ));
        //php artisan make:view role.program.cbt.analisis-test-single
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



        AnalisisTest::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, AnalisisTest $dtanalisistest)
    {
        //

        dd($request->all());
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
        $varmodel = AnalisisTest::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //AnalisisTest
        // dd($id);
        // dd($request->all());
        $data = AnalisisTest::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
