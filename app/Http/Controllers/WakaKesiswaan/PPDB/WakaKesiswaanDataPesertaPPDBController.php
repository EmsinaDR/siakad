<?php

namespace App\Http\Controllers\WakaKesiswaan\PPDB;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKesiswaan\PPDB\PPDBPeserta;
use App\Models\WakaKesiswaan\PPDB\WakaKesiswaanDataPesertaPPDB;

class WakaKesiswaanDataPesertaPPDBController extends Controller
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

php artisan make:view role.waka.kesiswaa.ppdb.data-peserta-ppdb
php artisan make:view role.waka.kesiswaa.ppdb.data-peserta-ppdb-single
php artisan make:model WakaKesiswaan/PPDB/KesiswaanDataPesertaPPDB
php artisan make:controller WakaKesiswaan/PPDB/KesiswaanDataPesertaPPDBController --resource



php artisan make:seeder WakaKesiswaan/PPDB/KesiswaanDataPesertaPPDBSeeder
php artisan make:migration KesiswaanDataPesertaPPDB




*/
    /*
    WakaKesiswaanDataPesertaPPDB
    $kesiswaandatappdb
    role.waka.kesiswaan.ppdb
    role.waka.kesiswaan.ppdb.data-peserta-ppdb
    role.waka.kesiswaan.ppdb.blade_show
    Index = Data Peserta PPDB
    Breadcume Index = 'Waka Kesiswaan / PPDB / Data Peserta PPDB';
    Single = titel_data_single
    php artisan make:view role.waka.kesiswaan.ppdb.data-peserta-ppdb
    php artisan make:view role.waka.kesiswaan.ppdb.data-peserta-ppdb-single
    php artisan make:seed WakaKesiswaanDataPesertaPPDBSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Peserta PPDB';
        $arr_ths = [
            'No Pendaftaran',
            'Status',
            'Nama Peserta',
            'Asal Sekolah',
        ];
        $breadcrumb = 'Waka Kesiswaan / PPDB / Data Peserta PPDB';
        $titleviewModal = 'Lihat Data Peserta PPDB';
        $titleeditModal = 'Edit Data Peserta PPDB';
        $titlecreateModal = 'Create Data Peserta PPDB';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = WakaKesiswaanDataPesertaPPDB::where('tapel_id', $etapels->id)->get();

        $datas = PPDBPeserta::orderBy('created_at', 'DESC')->where('tapel_id', $etapels->id)->get();
        $kelompok_sekolah = PPDBPeserta::where('tapel_id', $etapels->id)->select(
            'namasek_asal',
            DB::raw('COUNT(*) as total'),
            DB::raw("SUM(CASE WHEN jenis_kelamin = '1' THEN 1 ELSE 0 END) as laki_laki"),
            DB::raw("SUM(CASE WHEN jenis_kelamin = '2' THEN 1 ELSE 0 END) as perempuan")
        )
            ->groupBy('namasek_asal')
            ->orderBy('total', 'DESC')
            ->get();


        return view('role.waka.kesiswaan.ppdb.data-peserta-ppdb', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'kelompok_sekolah',
        ));
        //php artisan make:view role.waka.kesiswaan.ppdb.data-peserta-ppdb

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Peserta PPDB';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kesiswaan / PPDB / Data Peserta PPDB';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = WakaKesiswaanDataPesertaPPDB::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kesiswaan.ppdb.data-peserta-ppdb-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.kesiswaan.ppdb.data-peserta-ppdb-single
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



        WakaKesiswaanDataPesertaPPDB::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, WakaKesiswaanDataPesertaPPDB $kesiswaandatappdb)
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
        $varmodel = WakaKesiswaanDataPesertaPPDB::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //WakaKesiswaanDataPesertaPPDB
        // dd($id);
        // dd($request->all());
        $data = WakaKesiswaanDataPesertaPPDB::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
