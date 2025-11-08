<?php

namespace App\Http\Controllers\Program\CBT;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Program\CBT\CBTJadwal;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CBTJadwalController extends Controller
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

php artisan make:view role.program.cbt.cbt-jadwal
php artisan make:view role.program.cbt.cbt-jadwal-single
php artisan make:model Program/CBT/CBTJadwal
php artisan make:controller Program/CBT/CBTJadwalController --resource



php artisan make:seeder Program/CBT/CBTJadwalSeeder
php artisan make:migration Migration_CBTJadwal




*/
    /*
    CBTJadwal
    $dtcbtjadwal
    role.program.cbt
    role.program.cbt.cbt-jadwal
    role.program.cbt.blade_show
    Index = Jadwal CBT Test
    Breadcume Index = 'Data Jadwal Test CBT / Jadwal CBT Test';
    Single = Jadwal CBT Test
    php artisan make:view role.program.role.program.cbt.cbt-jadwal
    php artisan make:view role.program.role.program.cbt.cbt-jadwal-single
    php artisan make:seed CBTJadwalSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Jadwal CBT Test';
        $arr_ths = [
            'Nama Test',
            'Kelas',
            'Guru',
            'Mapel',
        ];
        $breadcrumb = 'Data Jadwal Test CBT / Jadwal CBT Test';
        $titleviewModal = 'Lihat Data Jadwal CBT Test';
        $titleeditModal = 'Edit Data Jadwal CBT Test';
        $titlecreateModal = 'Create Data Jadwal CBT Test';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = CBTJadwal::where('tapel_id', $etapels->id)->where('detailguru_id', Auth::id())->get();
        $datas = CBTJadwal::get();


        return view('role.program.cbt.cbt-jadwal', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.cbt.cbt-jadwal

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Jadwal CBT Test';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Jadwal Test CBT / Jadwal CBT Test';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = CBTJadwal::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.cbt.cbt-jadwal-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.program.cbt.cbt-jadwal-single
    }

    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
        ]);

        // dd($request->all());
        // Validasi data
        // Validasi data
        $validator = Validator::make($request->all(), [
            'nama_test'            => 'required|string|max:255',
            'tapel_id'             => 'required|integer|exists:etapels,id',
            'detailguru_id'        => 'required|integer|exists:detailgurus,id',
            'kelas_id'             => 'required|integer|exists:ekelas,id',
            'soal_id'              => 'required|json',
            'mapel_id'             => 'required|integer|exists:emapels,id',
            'waktu'                => 'required|string|max:255',
            'tanggal_pelaksanaan'  => 'required|date',
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }



        CBTJadwal::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, CBTJadwal $dtcbtjadwal)
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
        $varmodel = CBTJadwal::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //CBTJadwal
        // dd($id);
        // dd($request->all());
        $data = CBTJadwal::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
