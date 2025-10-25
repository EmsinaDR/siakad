<?php

namespace App\Http\Controllers\Program\Prestasi;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Prestasi\DataPrestasi;
use App\Models\User\Siswa\Detailsiswa;
use Mpdf\Tag\Details;

class DataPrestasiController extends Controller
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

php artisan make:view role.program.prestasi.data-prestasi
php artisan make:view role.program.prestasi.data-prestasi-single
php artisan make:seeder Program/Prestasi/DataPrestasiSeeder
php artisan make:model Program/Prestasi/DataPrestasi
php artisan make:controller Program/Prestasi/DataPrestasiController --resource



php artisan make:migration Migration_DataPrestasi




*/
    /*
    DataPrestasi
    $dataprestasi
    role.program.prestasi.data-prestasi
    role.program.prestasi.data-prestasi
    role.program.prestasi.data-prestasi.blade_show
    Index = Data Prestasi
    Breadcume Index = 'Presatasi / Data Prestasi';
    Single = titel_data_single
    php artisan make:view role.program.prestasi.data-prestasi
    php artisan make:view role.program.prestasi.data-prestasi-single
    php artisan make:seed DataPrestasiSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Prestasi';
        $arr_ths = [
            'IC',
            'Juara',
            'Kategori',
            'Nama Siswa',
            'Tingkat',
            'Pelaksanaan',
            'Keterangan',
        ];
        $breadcrumb = 'Presatasi / Data Prestasi';
        $titleviewModal = 'Lihat Data Prestasi';
        $titleeditModal = 'Edit Data Prestasi';
        $titlecreateModal = 'Create Data Prestasi';
        $datas = DataPrestasi::OrderBy('pelaksanaan', 'DESC')->get();
        $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
        $listdata = \App\Models\User\Siswa\Detailsiswa::orderBy('kelas_id', 'ASC')->orderBy('nama_siswa', 'ASC')->get();
        // dd($routeName); // Output: 'absensi.data'


        return view('role.program.prestasi.data-prestasi', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'listdata',
        ));
        //php artisan make:view role.program.prestasi.data-prestasi

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'titel_data_single';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Presatasi / Data Prestasi';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = DataPrestasi::OrderBy('pelaksanaan', 'DESC')->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.prestasi.data-prestasi-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.program.prestasi.data-prestasi-single
    }

    public function store(Request $request)
    {
        //
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);
        $validator = Validator::make($request->all(), [
            'tapel_id' => 'integer',
            'juara' => 'required|string|max:50',
            'detailsiswa_id' => 'required|array|min:1',
            'detailsiswa_id.*' => 'integer|exists:detailsiswas,id', // Pastikan ID siswa valid
            'kategori' => 'required|string|max:50',
            'pelaksanaan' => 'required|date',
            'tingkat' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan data secara loop jika siswa lebih dari 1
        foreach ($request->detailsiswa_id as $siswa_id) {
            DataPrestasi::create([
                'tapel_id' => $request->tapel_id,
                'juara' => $request->juara,
                'detailsiswa_id' => $siswa_id,
                'kategori' => $request->kategori,
                'pelaksanaan' => $request->pelaksanaan,
                'tingkat' => $request->tingkat,
                'keterangan' => $request->keterangan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return redirect()->back()->with('success', 'Data prestasi berhasil disimpan.');
    }
    public function update($id, Request $request, DataPrestasi $dataprestasi)
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
        $varmodel = DataPrestasi::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //DataPrestasi
        // dd(id);
        // dd(request->all());
        $data = DataPrestasi::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
