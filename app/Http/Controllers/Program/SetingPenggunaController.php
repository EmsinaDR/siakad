<?php

namespace App\Http\Controllers\Program;

use Exception;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Program\SetingPengguna;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SetingPenggunaController extends Controller
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




     */
    /*
    SetingPengguna
    $dtsettingpengguna
    role.program.seting.seting-pengguna
    role.program.seting.seting-pengguna
    role.program.seting.seting-pengguna.blade_show
    Index = Data Seting Pengguna
    Breadcume Index = 'Seting Pengguna Program / Data Seting Pengguna';
    Single = Data Seting Pengguna
    php artisan make:view role.program.role.program.seting.seting-pengguna
    php artisan make:view role.program.role.program.seting.seting-pengguna-single
    php artisan make:seed SetingPenggunaSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Seting Pengguna';
        $arr_ths = [
            'Nama Program',
            'Kontrol',
            'Maksimal User',
            'Nama Guru',
        ];
        $breadcrumb = 'Seting Pengguna Program / Data Seting Pengguna';
        $titleviewModal = 'Lihat Data Seting Pengguna';
        $titleeditModal = 'Edit Data Seting Pengguna';
        $titlecreateModal = 'Create Data Seting Pengguna';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // $datas = SetingPengguna::where('tapel_id', $etapels->id)->groupBy('nama_program')->get();
        if (Auth::user()->posisi === 'Admindev') {
            $datas = SetingPengguna::orderBy('nama_program')->get();
        } else {

            $datas = SetingPengguna::where('aktivasi', '!=', 0)->where('pemegang_id', Auth::user()->detailguru_id)
                ->where('nama_program', '!=', 'Admin') // <-- ini kuncinya bro
                ->orderBy('nama_program')
                ->get();
        }
        // Memisahkan 'kepala sekolah' dan 'waka' di atas
        $priority = ['Kepala Sekolah', 'Waka Kurikulum', 'Waka Kesiswaan', 'Waka Sarpras', 'Waka Humas'];

        $priorityItems = $datas->filter(function ($item) use ($priority) {
            return in_array($item->nama_program, $priority);
        });

        $otherItems = $datas->filter(function ($item) use ($priority) {
            return !in_array($item->nama_program, $priority);
        });

        // Gabungkan kembali, dengan priority items di atas
        $datas = $priorityItems->merge($otherItems);
        $DataPenggunaAdmin = Cache::tags(['cache_DataPenggunaAdmin'])->remember('remember_DataPenggunaAdmin', now()->addHours(2), function () use ($priorityItems, $otherItems) {
            return  $priorityItems->merge($otherItems);
        });

        return view('role.program.seting.seting-pengguna', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
        //php artisan make:view role.program.seting.seting-pengguna

    }


    //
    //Title to Controller
    public function show($pemegang)
    {
        $title = 'Data Seting Pengguna untuk ' . $pemegang;
        $arr_ths = [
            'Nama Program',
            'Kontrol',
            'Maksimal User',
            'Nama Guru',
        ];
        $breadcrumb = 'Seting Pengguna Program / ' . $pemegang;
        $titleviewModal = 'Lihat Data Seting Pengguna';
        $titleeditModal = 'Edit Data Seting Pengguna';
        $titlecreateModal = 'Create Data Seting Pengguna';

        $etapels = Etapel::where('aktiv', 'Y')->first();

        $datas = SetingPengguna::where('tapel_id', $etapels->id)->groupBy('nama_program')->get();
        $datas = SetingPengguna::where('tapel_id', $etapels->id)->where('pemegang', 'Admin')->orderBy('nama_program')->get();


        // Order dan Prioritas
        $datas = SetingPengguna::where('tapel_id', $etapels->id)->where('pemegang', request()->segment(3))->orderBy('nama_program')->get();

        // Memisahkan 'kepala sekolah' dan 'waka' di atas
        $priority = ['Kepala Sekolah', 'Waka Kurikulum', 'Waka Kesiswaan', 'Waka Sarpras', 'Waka Humas'];

        $priorityItems = $datas->filter(function ($item) use ($priority) {
            return in_array($item->nama_program, $priority);
        });

        $otherItems = $datas->filter(function ($item) use ($priority) {
            return !in_array($item->nama_program, $priority);
        });

        // Gabungkan kembali, dengan priority items di atas
        $datas = $priorityItems->merge($otherItems);

        $dataGuru = Detailguru::get();
        return view('role.program.seting.seting-pengguna-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'dataGuru'
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
        SetingPengguna::create($validator->validated());
        HapusCacheDenganTag('cache_DataPenggunaAdmin');
        HapusCacheDenganTag('seting_program');
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request)
    {
        if (!$request->detailguru_id) {
            return redirect()->back()
                ->with('Title', 'Gagal')
                ->with('gagal', 'Data tidak boleh kosong.');
        }
        try {
            $varmodel = SetingPengguna::findOrFail($id);

            $ValidIds = array_slice($request->detailguru_id, 0, $varmodel->jumlah_user);

            $etapels = Etapel::where('aktiv', 'Y')->first();
            $request->merge([
                'tapel_id' => $etapels->id ?? null,
                'semester' => $etapels->semester ?? null
            ]);

            $request->validate([
                'detailguru_id' => 'required|array',
            ]);

            $varmodel->update([
                'detailguru_id' => json_encode($ValidIds),
                'tapel_id' => $etapels->id ?? null,
                'semester' => $etapels->semester ?? null
            ]);

            HapusCacheDenganTag('cache_DataPenggunaAdmin');
            HapusCacheDenganTag('seting_program');
            return redirect()->back()
                ->with('Title', 'Berhasil')
                ->with('success', 'Data berhasil diperbarui.');
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        //SetingPengguna
        // dd($id);
        // dd($request->all());
        $data = SetingPengguna::findOrFail($id);
        // $data->delete();
        $varmodel = SetingPengguna::find($id);

        if ($varmodel) {
            // Simpan array sebagai JSON
            $data = $request->only(['detailguru_id']);
            $data['detailguru_id'] = Null;

            $varmodel->update($data);
            HapusCacheDenganTag('cache_DataPenggunaAdmin');
            HapusCacheDenganTag('seting_program');

            return redirect()->back()
                ->with('Title', 'Berhasil')
                ->with('success', 'Data berhasil diperbarui.');
        } else {
            return redirect()->back()
                ->with('Title', 'Gagal')
                ->with('gagal', 'Data tidak ditemukan.');
        }
    }
}
