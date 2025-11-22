<?php

namespace App\Http\Controllers\Bendahara;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bendahara\BukukasKomite;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Bendahara\BendaharaKomite;
use Illuminate\Support\Facades\Validator;

class BukukasKomiteController extends Controller
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

php artisan make:view role.bendahara.komite.buku-kas
php artisan make:view role.bendahara.komite.buku-kas-single
php artisan make:model Bendahara/BukukasKomite
php artisan make:controller Bendahara/BukukasKomiteController --resource



php artisan make:seeder Bendahara/BukukasKomiteSeeder
php artisan make:migration Migration_BukukasKomite




*/
    /*
    BukukasKomite
    $dtbkkaskomite
    role.bendahara.komite
    role.bendahara.komite.buku-kas
    role.bendahara.komite.blade_show
    Index = Data Buku Kas Komite
    Breadcume Index = 'Bendahara Komite / Data Buku Kas Komite';
    Single = Data Buku Kas Komite
    php artisan make:view role.program.role.bendahara.komite.buku-kas
    php artisan make:view role.program.role.bendahara.komite.buku-kas-single
    php artisan make:seed BukukasKomiteSeeder



    */
    public function index()
    {
        $title = 'Data Buku Kas Komite';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Bendahara Komite / Data Buku Kas Komite';
        $titleviewModal = 'Lihat Data Data Buku Kas Komite';
        $titleeditModal = 'Edit Data Data Buku Kas Komite';
        $titlecreateModal = 'Create Data Data Buku Kas Komite';

        // Ambil tapel aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Ambil semua data kas komite berdasarkan tapel
        $datas = BukukasKomite::where('tapel_id', $etapels->id)->orderBy('created_at', 'DESC')->get();
        // Hitung total pemasukan dan pengeluaran
        $total_penerimaan = $datas->sum('penerimaan');
        $total_pengeluaran = $datas->sum('pengeluaran');
        $saldo_akhir = $total_penerimaan - $total_pengeluaran;
        $rekaps = BukukasKomite::where('tapel_id', $etapels->id)->orderBy('created_at', 'DESC')->groupBy('program')->get();
        $datapemasukkan_kelas = BendaharaKomite::where('tapel_id', $etapels->id)->orderBy('kelas_d', 'asc')->groupBy('kelas_id')->get();

        $rekaps = BukukasKomite::where('tapel_id', $etapels->id)
            ->where('program', 'Pembayaran Komite')
            ->selectRaw('program, SUM(penerimaan) as total_penerimaan, SUM(pengeluaran) as total_pengeluaran')
            ->groupBy('program')
            ->orderBy('program')
            ->get();
        $rekapsPengeluaran = \App\Models\Bendahara\BukukasKomite::where('tapel_id', $etapels->id)
            ->whereNotNull('pengeluaran_id')
            ->selectRaw('program, SUM(pengeluaran) as total_pengeluaran')
            ->groupBy('program')
            ->orderBy('program')
            ->get();
        $rekapsPengeluaranx = \App\Models\Bendahara\BukukasKomite::where('tapel_id', $etapels->id)
            ->whereNotNull('pengeluaran_id')
            ->pluck('pengeluaran')
            // ->get()
            ->toArray();
        // dump($rekapsPengeluaranx);
        
        // dd($rekaps);
        return view('role.bendahara.komite.buku-kas', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'total_penerimaan',
            'total_pengeluaran',
            'saldo_akhir',
            'rekaps',
            'rekapsPengeluaran',
        ));
    }



    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Buku Kas Komite';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Bendahara Komite / Data Buku Kas Komite';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = BukukasKomite::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.bendahara.komite.buku-kas-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.bendahara.komite.buku-kas-single
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



        BukukasKomite::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, BukukasKomite $dtbkkaskomite)
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
        $varmodel = BukukasKomite::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //BukukasKomite
        // dd($id);
        // dd($request->all());
        $data = BukukasKomite::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
/*



php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
cls



php artisan migrate:fresh --seed


composer dump-autoload

*/