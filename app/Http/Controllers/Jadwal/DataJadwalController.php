<?php

namespace App\Http\Controllers\Jadwal;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Jadwal\DataJadwal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DataJadwalController extends Controller
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

php artisan make:view role.jadwal.data-jadwal
php artisan make:view role.jadwal.data-jadwal-single
php artisan make:seeder Jadwal/DataJadwalSeeder
php artisan make:model Jadwal/DataJadwal
php artisan make:controller Jadwal/DataJadwalController --resource


*/
    /*
    DataJadwal
    $datajadwal
    role.jadwal
    role.jadwal.data-jadwal
    role.jadwal.blade_show
    Index = Data Jadwal
    Breadcume Index = 'Pengaturan / Jadwal';
    Single = Data Jadwal
    php artisan make:view role.jadwal.data-jadwal
    php artisan make:view role.jadwal.data-jadwal-single
    php artisan make:seed DataJadwalSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Jadwal';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Pengaturan / Jadwal';
        $titleviewModal = 'Lihat Data Jadwal';
        $titleeditModal = 'Edit Data Jadwal';
        $titlecreateModal = 'Create Data Jadwal';
        $datas = DataJadwal::get();


        return view('role.jadwal.data-jadwal', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.jadwal.data-jadwal

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Jadwal';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Pengaturan / Jadwal';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = DataJadwal::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.jadwal.data-jadwal-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.jadwal.data-jadwal-single
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



        DataJadwal::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, DataJadwal $datajadwal)
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
        $varmodel = DataJadwal::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //DataJadwal
        // dd(id);
        // dd(request->all());
        $data = DataJadwal::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
