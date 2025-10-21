<?php

namespace App\Http\Controllers\WakaSarpras\Inventaris;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaSarpras\Inventaris\KIBB;
use App\Models\WakaSarpras\Inventaris\KIBC;
use App\Models\WakaSarpras\Inventaris\Inventaris;
use App\Models\WakaSarpras\Inventaris\InventarisInRuangan;

class InventarisInRuanganController extends Controller
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

php artisan make:view role.waka.sarpras.inventaris.inventaris-in-ruang
php artisan make:view role.waka.sarpras.inventaris.inventaris-in-ruang-single
php artisan make:model WakaSarpras/Inventaris/InventarisInRuanganan
php artisan make:controller WakaSarpras/Inventaris/InventarisInRuangananController --resource



php artisan make:seeder WakaSarpras/Inventaris/InventarisInRuangananSeeder
php artisan make:migration Migration_InventarisInRuanganan




*/
    /*
    InventarisInRuangan
    $invinruang
    role.waka.sarpras.inventaris
    role.waka.sarpras.inventaris.inventaris-in-ruang
    role.waka.sarpras.inventaris.blade_show
    Index = Data Inventaris
    Breadcume Index = 'Waka Sarpras / Data Inventaris';
    Single = Data Inventaris
    php artisan make:view role.waka.sarpras.inventaris.inventaris-in-ruang
    php artisan make:view role.waka.sarpras.inventaris.inventaris-in-ruang-single
    php artisan make:seed InventarisInRuanganSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Inventaris';
        $arr_ths = [
            'Kode Ruangan',
            'Nama Ruangan',
            'Nama Barang',
            'Jumlah',
            'Kondisi',
        ];
        $breadcrumb = 'Waka Sarpras / Data Inventaris';
        $titleviewModal = 'Lihat Data Inventaris';
        $titleeditModal = 'Edit Data Inventaris';
        $titlecreateModal = 'Create Data Inventaris';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = InventarisInRuangan::get();
        $dataRuangans = KIBC::orderBy('nama_barang')->get();
        $DataBarangs = KIBB::orderBy('nama_barang')->get();
        // dump($datas, $dataRuangans, $DataBarangs);

        return view('role.waka.sarpras.inventaris.inventaris-in-ruang', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'dataRuangans',
            'DataBarangs',
        ));
        //php artisan make:view role.waka.sarpras.inventaris.inventaris-in-ruang

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Inventaris';
        $arr_ths = [
            'Kode Ruangan',
            'Nama Ruangan',
            'Nama Barang',
            'Jumlah',
            'Kondisi',
        ];
        $breadcrumb = 'Waka Sarpras / Data Inventaris';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = InventarisInRuangan::where('tapel_id', $etapels->id)->get();
        $dataRuangan = KIBC::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.inventaris-in-ruang-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.sarpras.inventaris.inventaris-in-ruang-single
    }

    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // $KI
        $request->merge([
            'tapel_id' => $etapels->id,
            'jumlah' => $request->baik + $request->rusak,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'kibb_id' => 'nullable|integer|min:0',
            'kibc_id' => 'nullable|integer|min:0',
            'baik' => 'nullable|integer|min:0',
            'rusak' => 'nullable|integer|min:0',
            'jumlah' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        InventarisInRuangan::create($validator->validated());
        // dd($request->all());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, InventarisInRuangan $invinruang)
    {
        //

        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'jumlah' => $request->baik + $request->rusak,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'kibb_id' => 'nullable|integer|min:0',
            'kibc_id' => 'nullable|integer|min:0',
            'baik' => 'nullable|integer|min:0',
            'rusak' => 'nullable|integer|min:0',
            'jumlah' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $varmodel = InventarisInRuangan::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //InventarisInRuangan
        // dd($id);
        // dd($request->all());
        $data = InventarisInRuangan::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
