<?php

namespace App\Http\Controllers\Program\CBT;

use App\Http\Controllers\Controller;
use App\Models\Admin\Etapel;
use App\Models\Program\CBT\CBTJadwal;
use App\Models\Program\CBT\JawabanCBT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class JawabanCBTController extends Controller
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

php artisan make:view role.program.cbt.cbt-jawaban
php artisan make:view role.program.cbt.cbt-jawaban-single
php artisan make:model Program/CBT/JawabanCBT
php artisan make:controller Program/CBT/JawabanCBTController --resource



php artisan make:seeder Program/CBT/JawabanCBTSeeder
php artisan make:migration Migration_JawabanCBT




*/
    /*
    JawabanCBT
    $dtjawabncbt
    role.program.cbt
    role.program.cbt.cbt-jawaban
    role.program.cbt.blade_show
    Index = Data Jawaban CBT
    Breadcume Index = 'Data CBT / Data Jawaban CBT';
    Single = Data Jawaban CBT
    php artisan make:view role.program.role.program.cbt.cbt-jawaban
    php artisan make:view role.program.role.program.cbt.cbt-jawaban-single
    php artisan make:seed JawabanCBTSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Jawaban CBT';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data CBT / Data Jawaban CBT';
        $titleviewModal = 'Lihat Data Jawaban CBT';
        $titleeditModal = 'Edit Data Jawaban CBT';
        $titlecreateModal = 'Create Data Jawaban CBT';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = JawabanCBT::where('tapel_id', $etapels->id)->get();


        return view('role.program.cbt.cbt-jawaban', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.cbt.cbt-jawaban

    }


    public function show($id)
    {
        //
        //Title to Controller
        $title = 'Data Jawaban CBT';
        $arr_ths = [
            'Nama Test',
            'Detail Siswa ID',
            'Jumlah Jawaban',
            'Benar',
            'Skor',
        ];
        $breadcrumb = 'Data CBT / Data Jawaban CBT';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $TestId = CBTJadwal::get();
        $datas = JawabanCBT::selectRaw('test_id, user_id, COUNT(*) as total_jawaban, SUM(benar) as total_benar')
        ->where('test_id', request()->segment(3))
            ->groupBy('test_id', 'user_id')
            ->get();




        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.cbt.cbt-jawaban-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.program.cbt.cbt-jawaban-single
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



        JawabanCBT::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, JawabanCBT $dtjawabncbt)
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
        $varmodel = JawabanCBT::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
    // public function destroy($id)
    // {
    //     //JawabanCBT
    //     // dd($id);
    //     // dd($request->all());
    //     $data = JawabanCBT::findOrFail($id);
    //     $data->delete();
    //     return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    // }
    public function destroy($hasil_test)
    {
        // Ambil data berdasarkan hasil_test yang diteruskan
        $hasilTest = JawabanCBT::findOrFail($hasil_test);

        // Lakukan penghapusan
        $hasilTest->delete();

        return redirect()->route('hasil-test.index')->with('success', 'Data berhasil dihapus');
    }
}
