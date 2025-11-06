<?php

namespace App\Http\Controllers\Program\CBT;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Ekelas;
use App\Models\Program\CBT\BankSoal;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BankSoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
*/
    /*
    BankSoal
    $banksoal
    role.program.cbt
    role.program.cbt.bank-soal
    role.program.cbt.blade_show
    Index = Soal Test
    Breadcume Index = 'Data Soal Test / Soal Test';
    Single = Soal Test
    php artisan make:view role.program.role.program.cbt.bank-soal
    php artisan make:view role.program.role.program.cbt.bank-soal-single
    php artisan make:seed BankSoalSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Soal Test';
        $arr_ths = [
            'Mapel',
            'Level',
            'Soal',
            'Plihan A',
            'Plihan B',
            'Plihan C',
            'Plihan D',
        ];
        $breadcrumb = 'Data Soal Test / Soal Test';
        $titleviewModal = 'Lihat Data Soal Test';
        $titleeditModal = 'Edit Data Soal Test';
        $titlecreateModal = 'Create Data Soal Test';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $DataBankSoal = Cache::tags(['Cache_DataBankSoal'])->remember('Remember_DataBankSoal', now()->addMinutes(10), function () {
            return BankSoal::with('mapel')->get();
        });

        return view('role.program.cbt.bank-soal', compact(
            'DataBankSoal',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.cbt.bank-soal

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Soal Test';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Soal Test / Soal Test';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = BankSoal::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.cbt.bank-soal-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.program.cbt.bank-soal-single
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



        BankSoal::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, BankSoal $banksoal)
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
        $varmodel = BankSoal::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //BankSoal
        // dd($id);
        // dd($request->all());
        $data = BankSoal::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }

    public function getSoalByMapelKelas($mapel_id, $kelas_id)
    {
        // $kelas = Ekelas::where('id', $kelas_id)->first();

        $kelas = Ekelas::find($kelas_id);
        // dd($kelas_id);
        $soals = BankSoal::where('mapel_id', $mapel_id)
            ->where('tingkat_id', $kelas->tingkat_id)
            ->get();

        return response()->json($soals);
    }
}
