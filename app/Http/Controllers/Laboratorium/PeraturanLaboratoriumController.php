<?php

namespace App\Http\Controllers\Laboratorium;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Laboratorium\RiwayatLaboratorium;
use App\Models\Laboratorium\DashboardLaboratorium;
use App\Models\Laboratorium\PeraturanLaboratorium;

class PeraturanLaboratoriumController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /*
     PeraturanLaboratorium
     $peraturanlaboratorium
     role.pembina.laboratorium
     role.pembina.laboratorium.peraturan-laboratorium
     role.pembina.laboratorium.blade_show
     Index = Peraturan Laboratorium
     Breadcume Index = 'Pembina Laboratorium / Peraturan Laboratorium';
     Single = titel_data_single
     php artisan make:view role.pembina.laboratorium.peraturan-laboratorium
     php artisan make:view role.pembina.laboratorium.peraturan-laboratorium-single
     php artisan make:seed PeraturanLaboratoriumSeeder



     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Peraturan Laboratorium';
        $arr_ths = [
            'Peraturan',
            'Keterangan',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Pembina Laboratorium / Peraturan Laboratorium';
        $titleviewModal = 'Lihat Data Peraturan Laboratorium';
        $titleeditModal = 'Edit Data Peraturan Laboratorium';
        $titlecreateModal = 'Create Data Peraturan Laboratorium';
        // $datas = PeraturanLaboratorium::->where('peraturan', '')->get();
        $datas = PeraturanLaboratorium::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.pembina.laboratorium.peraturan-laboratorium', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.pembina.laboratorium.peraturan-laboratorium

    }


    public function show()
    {
        // try {
        $title = 'Peraturan Laboratorium';
        $arr_ths = ['Peraturan', 'Keterangan'];
        $breadcrumb = 'Pembina Laboratorium / Peraturan Laboratorium';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';

        // Pastikan Etapel ditemukan
        $etapels = Etapel::where('aktiv', 'Y')->first();
        if (!$etapels) {
            return redirect()->back()->with('Title', 'Gagal')->with('gagal', 'Tahun pelajaran tidak ditemukan.');
        }

        // Pastikan RiwayatLaboratorium ditemukan
        $data_laboratoriums = RiwayatLaboratorium::with('LaboratoriumOne')
            ->where('detailguru_id', Auth::user()->detailguru_id)
            ->where('tapel_id', $etapels->id)
            ->where('laboratorium_id', request()->segment(3))
            ->first();
        // dd($data_laboratoriums, $data_laboratoriums->LaboratoriumOne->nama_laboratorium);

        // Jika tidak ditemukan, redirect
        if (!$data_laboratoriums || !$data_laboratoriums->LaboratoriumOne) {
            return redirect()->back()->with('Title', 'Gagal')->with('gagal', 'Laboratorium tidak ditemukan.');
        }

        // Ambil data peraturan berdasarkan kategori laboratorium
        $datas = PeraturanLaboratorium::where('kategori', $data_laboratoriums->LaboratoriumOne->nama_laboratorium)->get();

        return view('role.pembina.laboratorium.peraturan-laboratorium-single', compact(
            'datas',
            'data_laboratoriums',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('Title', 'Gagal')->with('gagal', 'Terjadi kesalahan: ' . $e->getMessage());
        // }
    }


    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
            'kategori' => 'Lab. Komputer',
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'peraturan' => 'string',
            'keterangan' => 'string',
            'kategori' => 'string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Menyimpan data menggunakan mass assignment
        // Create : Buat
        // Update : Memperbaharui
        // Menyimpan data menggunakan mass assignment
        PeraturanLaboratorium::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, PeraturanLaboratorium $peraturanlaboratorium)
    {
        //
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
            'kategori' => 'Lab. Komputer',
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'peraturan' => 'string',
            'keterangan' => 'string',
            'kategori' => 'string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Menyimpan data menggunakan mass assignment
        // Create : Buat
        // Update : Memperbaharui
        // Menyimpan data menggunakan mass assignment
        $varmodel = PeraturanLaboratorium::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //PeraturanLaboratorium
        // dd(id);
        // dd(request->all());
        $data = PeraturanLaboratorium::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
