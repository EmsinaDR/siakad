<?php

namespace App\Http\Controllers\WakaKurikulum\Elearning;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Laravel\Reverb\Loggers\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\Elearning\KurikulumDataKKM;

class KurikulumDataKKMController extends Controller
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

php artisan make:view role.waka.kurikulum.elarning.data-kkm
php artisan make:view role.waka.kurikulum.elarning.data-kkm-single
php artisan make:seeder WakaKurikulum/Elearning/KurikulumDataKKMSeeder
php artisan make:model WakaKurikulum/Elearning/KurikulumDataKKM
php artisan make:controller WakaKurikulum/Elearning/KurikulumDataKKMController --resource


App\Http\Controllers\WakaKurikulum$Folder$namaController


php artisan make:migration Migration_KurikulumDataKKM




*/
    /*
    KurikulumDataKKM
    $kurikulmkkm
    role.waka.kurikulum.elarning
    role.waka.kurikulum.elarning.data-kkm
    role.waka.kurikulum.elarning.blade_show
    Index = Data KKM
    Breadcume Index = 'Waka Kurikulum / KKM Mapel';
    Single = Data KKM Mapel
    php artisan make:view role.waka.kurikulum.elarning.data-kkm
    php artisan make:view role.waka.kurikulum.elarning.data-kkm-single
    php artisan make:seed KurikulumDataKKMSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data KKM';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kurikulum / KKM Mapel';
        $titleviewModal = 'Lihat Data KKM';
        $titleeditModal = 'Edit Data KKM';
        $titlecreateModal = 'Create Data KKM';
        // Ambil data dengan relasi mapel
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $datas = KurikulumDataKKM::with('mapel')->where('tapel_id', $etapels->id)->select('mapel_id', 'tingkat_id', 'kkm')->get();

        // Ambil daftar tingkat unik, urutkan
        $tingkatIDs = KurikulumDataKKM::distinct()->pluck('tingkat_id')->sort()->toArray();

        // Format data: ['Nama Mapel' => [Tingkat => KKM]]
        $formattedData = [];
        foreach ($datas as $data) {
            if ($data->mapel) {
                $formattedData[$data->mapel->mapel][$data->tingkat_id] = $data->kkm;
            }
        }
        $datas = KurikulumDataKKM::with('mapel')->where('tapel_id', $etapels->id)
            ->select('id', 'mapel_id', 'kkm', 'tingkat_id')
            ->get();


        $rataRataKKM = [
            7 => $datas->where('tingkat_id', 7)->avg('kkm') ?? 0,
            8 => $datas->where('tingkat_id', 8)->avg('kkm') ?? 0,
            9 => $datas->where('tingkat_id', 9)->avg('kkm') ?? 0,
        ];


        // dd($datas); // Cek isi datanya di browser
        return view('role.waka.kurikulum.elarning.data-kkm', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'formattedData',
            'tingkatIDs',
            'rataRataKKM',
        ));
        //php artisan make:view role.waka.kurikulum.elarning.data-kkm

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data KKM Mapel';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kurikulum / KKM Mapel';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = KurikulumDataKKM::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.elarning.data-kkm-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.kurikulum.elarning.data-kkm-single
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



        KurikulumDataKKM::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function updatex($id, Request $request, KurikulumDataKKM $kurikulmkkm)
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
        $varmodel = KurikulumDataKKM::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //KurikulumDataKKM
        // dd(id);
        // dd(request->all());
        $data = KurikulumDataKKM::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
    //Ajax
    public function updateKkmex(Request $request)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|numeric|min:0|max:100',
            'tingkat_id' => 'required|integer',
            'mapel_id' => 'required|integer'
        ]);

        if ($request->id) {
            // Jika ID ada, update data
            $data = KurikulumDataKKM::findOrFail($request->id);
        } else {
            // Jika ID kosong, buat data baru
            $data = new KurikulumDataKKM();
            $data->mapel_id = $request->mapel_id;
            $data->tingkat_id = $request->tingkat_id;
        }

        $data->{$request->field} = $request->value;
        $data->save();

        return response()->json([
            'success' => true,
            'message' => $request->id ? 'Data berhasil diperbarui!' : 'Data baru berhasil dibuat!',
            'data' => $data
        ]);
    }

    public function updateKkm(Request $request)
    {
        // Debugging untuk memastikan data masuk
        if (!$request->tingkat_id || !$request->mapel_id) {
            return response()->json([
                'success' => false,
                'message' => 'tingkat_id atau mapel_id tidak ditemukan!',
            ], 400);
        }
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //
        //where('tapel_id', $etapels->id)->

        $request->validate([
            'field' => 'required|string',
            'value' => 'required|numeric|min:0|max:100',
            'tingkat_id' => 'required|integer',
            'mapel_id' => 'required|integer'
        ]);

        if ($request->id) {
            // Jika ID ada, update data
            $data = KurikulumDataKKM::findOrFail($request->id);
        } else {
            // Jika ID kosong, buat data baru
            $data = new KurikulumDataKKM();
            $data->mapel_id = $request->mapel_id;
            $data->tapel_id = $etapels->id;
            $data->tingkat_id = $request->tingkat_id;
        }

        $data->{$request->field} = $request->value;
        $data->save();

        return response()->json([
            'success' => true,
            'message' => $request->id ? 'Data berhasil diperbarui!' : 'Data baru berhasil dibuat!',
            'data' => $data
        ]);
    }
}
