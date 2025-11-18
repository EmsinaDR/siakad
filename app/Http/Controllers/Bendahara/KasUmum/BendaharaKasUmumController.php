<?php

namespace App\Http\Controllers\Bendahara\KasUmum;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Bendahara\KasUmum\BendaharaKasUmum;
use App\Models\Bendahara\BukukasKomite;

class BendaharaKasUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Kas Umum';
        $arr_ths = [
            'Tanggal',
            'Sumber Dana',
            'Penerimaan',
            'Pengeluaran',
            'Keterangan',
        ];
        $breadcrumb = 'Bendahara Kas Umum / Data Kas Umum';
        $titleviewModal = 'Lihat Data Data Kas Umum';
        $titleeditModal = 'Edit Data Data Kas Umum';
        $titlecreateModal = 'Create Data Data Kas Umum';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = BendaharaKasUmum::where('tapel_id', $etapels->id)->orderBy('created_at', 'DESC')
            ->take(200)
            ->get();
        $rekaps = BendaharaKasUmum::where('tapel_id', $etapels->id)->groupBy('sumber_dana')->get();
        $rekaps = BendaharaKasUmum::where('tapel_id', $etapels->id)->select(
            'sumber_dana',
            DB::raw('SUM(penerimaan) as total_penerimaan'),
            DB::raw('SUM(pengeluaran) as total_pengeluaran')
        )
            ->groupBy('sumber_dana')
            ->get();
        $sumber_dana_lists = BendaharaKasUmum::where('tapel_id', $etapels->id)->orderBy('sumber_dana', 'ASC')->select('sumber_dana')->distinct()->pluck('sumber_dana');


        return view('role.bendahara.kas-umum', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'rekaps',
            'sumber_dana_lists',
        ));

        //php artisan make:view role.bendahara.kas-umum

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Kas Umum';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Bendahara Kas Umum / Data Kas Umum';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = BendaharaKasUmum::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.bendahara.kas-umum-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.bendahara.kas-umum-single
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



        BendaharaKasUmum::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, BendaharaKasUmum $bndaharaKasUmum)
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
        $varmodel = BendaharaKasUmum::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //BendaharaKasUmum
        // dd($id);
        // dd($request->all());
        $data = BendaharaKasUmum::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
    public function LaporanKasUmum(Request $request)
    {
        //dd($request->all());
        // dd($request->all());
        $title = 'Laporan Kas Umum';
        $breadcrumb = 'Bendahara Kas Umum / Data Kas Umum';
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $sumber_dana = $request->sumber_dana;
        $datas = BendaharaKasUmum::where('sumber_dana', $request->sumber_dana)
            ->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir])
            ->get();
        // dd($datas);
        return view('role.bendahara.kasumum.generate-kas-umum', compact(
            'title',
            'breadcrumb',
            'datas',
            'tanggal_awal',
            'tanggal_akhir',
            'sumber_dana',
        ));
    }
}
