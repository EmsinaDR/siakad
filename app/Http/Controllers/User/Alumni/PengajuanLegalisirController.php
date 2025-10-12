<?php

namespace App\Http\Controllers\User\Alumni;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\User\Alumni\PengajuanLegalisir;

class PengajuanLegalisirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    PengajuanLegalisir
    $dtpengajuanlegalisir
    role.program.legalisir
    role.program.legalisir.data-pengajuan
    role.program.legalisir.blade_show
    Index = Legalisir Ijazah
    Breadcume Index = 'Data Pengajuan Legalisir / Legalisir Ijazah';
    Single = Legalisir Ijazah
    php artisan make:view role.program.legalisir.data-pengajuan
    php artisan make:view role.program.legalisir.data-pengajuan-single
    php artisan make:seed Program/Legalisir/PengajuanLegalisirSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Legalisir Ijazah';
        $arr_ths = [
            'Nama Alumni',
            'Tahun Lulus',
            'Jumlah',
            'Keperluan',
            'Status',
        ];
        $breadcrumb = 'Data Pengajuan Legalisir / Legalisir Ijazah';
        $titleviewModal = 'Lihat Data Legalisir Ijazah';
        $titleeditModal = 'Edit Data Legalisir Ijazah';
        $titlecreateModal = 'Create Data Legalisir Ijazah';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = PengajuanLegalisir::where('tapel_id', $etapels->id)->get();
        $datas = PengajuanLegalisir::orderBy('created_at', 'DESC')->get();


        return view('role.program.legalisir.data-pengajuan', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.legalisir.data-pengajuan

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Legalisir Ijazah';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Pengajuan Legalisir / Legalisir Ijazah';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = PengajuanLegalisir::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.legalisir.data-pengajuan-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.program.legalisir.data-pengajuan-single
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



        PengajuanLegalisir::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, PengajuanLegalisir $dtpengajuanlegalisir)
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
            'status' => 'string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $varmodel = PengajuanLegalisir::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //PengajuanLegalisir
        // dd($id);
        // dd($request->all());
        $data = PengajuanLegalisir::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
