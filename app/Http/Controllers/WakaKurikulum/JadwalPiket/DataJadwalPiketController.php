<?php

namespace App\Http\Controllers\WakaKurikulum\JadwalPiket;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\JadwalPiket\DataJadwalPiket;

class DataJadwalPiketController extends Controller
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

php artisan make:view role.waka.kurikulum.jadwalpiket.data-jadwal-piket
php artisan make:view role.waka.kurikulum.jadwalpiket.data-jadwal-piket-single
php artisan make:seeder WakaKurikulum/JadwalPiket/DataJadwalPiketSeeder
php artisan make:model WakaKurikulum/JadwalPiket/DataJadwalPiket
php artisan make:controller WakaKurikulum/JadwalPiket/DataJadwalPiketController --resource



php artisan make:migration Migration_DataJadwalPiket




*/
    /*
    DataJadwalPiket
    $jadwalpiket
    role.waka.kurikulum.jadwalpiket.data
    role.waka.kurikulum.jadwalpiket.data-jadwal-piket
    role.waka.kurikulum.jadwalpiket.data.blade_show
    Index = Data Jadwal Piket
    Breadcume Index = 'Data Piket / Jadwal Piket';
    Single = Data Jadwal PIket
    php artisan make:view role.waka.kurikulum.jadwalpiket.data-jadwal-piket
    php artisan make:view role.waka.kurikulum.jadwalpiket.data-jadwal-piket-single
    php artisan make:seed DataJadwalPiketSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Jadwal Piket';
        $arr_ths = [
            'Nama Guru',
            'Hari',
        ];
        $breadcrumb = 'Data Piket / Jadwal Piket';
        $titleviewModal = 'Lihat Data Jadwal Piket';
        $titleeditModal = 'Edit Data Jadwal Piket';
        $titlecreateModal = 'Create Data Jadwal Piket';
        $datas = DataJadwalPiket::get();
        $DataGuru = Detailguru::orderBy('nama_guru', 'ASC')->get();





        // Ambil semua data dengan relasi 'guru'
        $datas = DataJadwalPiket::with('guru')->orderBy('created_at', 'DESC')->get();

        // Urutan hari yang benar (Senin sampai Sabtu)
        $hari_order = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];

        // Grouping setelah sorting agar relasi tidak hilang
        $datase = $datas->sortBy(function ($item) use ($hari_order) {
            return array_search($item->hari, $hari_order) !== false ? array_search($item->hari, $hari_order) : 999;
        })->groupBy('hari');



        // $datas = DataJadwalPiket::with('Guru')->get()->groupBy('hari'); // Ambil data dan kelompokkan

        // // Urutan hari yang benar (Senin sampai Sabtu)
        // $hari_order = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];

        // // Sorting hasil berdasarkan urutan dalam array $hari_order
        // $datas = $datas->sortBy(function ($value, $key) use ($hari_order) {
        //     return array_search($key, $hari_order);
        // });

        // Menampilkan hasil
        // foreach ($datas as $hari => $jadwal) {
        //     echo "Hari: $hari\n";
        //     print_r($jadwal);
        // }
        // dd($datas);



        return view('role.waka.kurikulum.jadwalpiket.data-jadwal-piket', compact(
            'datas',
            'datase',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'hari_order',
            'DataGuru',
        ));
        //php artisan make:view role.waka.kurikulum.jadwalpiket.data-jadwal-piket

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Jadwal PIket';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Piket / Jadwal Piket';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = DataJadwalPiket::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.jadwalpiket.data-jadwal-piket-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.kurikulum.jadwalpiket.data-jadwal-piket-single
    }

    public function store(Request $request)
    {
        // Ambil tahun ajaran aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        if (!$etapels) {
            return redirect()->back()->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        // Tambahkan tapel_id ke request
        $request->merge([
            'tapel_id' => $etapels->id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'tapel_id' => 'required|numeric',
            'detailguru_id' => 'nullable|array', // Pastikan 'detailguru_id' adalah array
            'detailguru_id.*' => 'numeric', // Setiap elemen dalam array harus numeric
            'hari' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Loop untuk menyimpan setiap data guru
        if ($request->has('detailguru_id')) {
            foreach ($request->detailguru_id as $detailguru_id) {
                DataJadwalPiket::create([
                    'tapel_id' => $request->tapel_id,
                    'detailguru_id' => $detailguru_id,
                    'hari' => $request->hari,
                ]);
            }
        }

        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, DataJadwalPiket $jadwalpiket)
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
            'detailguru_id' => 'nullable|numeric',
            'hari' => 'nullable|string',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $varmodel = DataJadwalPiket::find($id); // Pastikan $id didefinisikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($validator->validated());
            // dd($request->all());
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
        //DataJadwalPiket
        // dd(id);
        // dd(request->all());
        $data = DataJadwalPiket::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
