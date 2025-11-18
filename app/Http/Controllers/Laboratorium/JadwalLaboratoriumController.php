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
use App\Models\Laboratorium\JadwalLaboratorium;
use App\Models\Laboratorium\RiwayatLaboratorium;
use App\Models\User\Guru\Detailguru;

class JadwalLaboratoriumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    JadwalLaboratorium
    $jadwal
    role.pembina.laboratorium
    role.pembina.laboratorium.jadwal-laboratorium
    role.pembina.laboratorium.blade_show
    Index = Jadwal Laboratorium
    Breadcume Index = 'Pembina Laboratorium / Jadwal Penggunaan';
    Single = Jadwal Laboratorium
    php artisan make:view role.pembina.laboratorium.jadwal-laboratorium
    php artisan make:view role.pembina.laboratorium.jadwal-laboratorium-single
    php artisan make:seed JadwalLaboratoriumSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Jadwal Laboratorium';
        $arr_ths = [
            'Nama Guru',
            'Tanggal Penggunaan',
            'Tujuan Penggunaan',
        ];
        $breadcrumb = 'Pembina Laboratorium / Jadwal Penggunaan';
        $titleviewModal = 'Lihat Data Jadwal Laboratorium';
        $titleeditModal = 'Edit Data Jadwal Laboratorium';
        $titlecreateModal = 'Create Data Jadwal Laboratorium';
        $datas = JadwalLaboratorium::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.pembina.laboratorium.jadwal-laboratorium', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.pembina.laboratorium.jadwal-laboratorium

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Jadwal Laboratorium';
        $arr_ths = [
            'Nama Guru',
            'Tanggal Penggunaan',
            'Tujuan Penggunaan',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //
        $breadcrumb = 'Pembina Laboratorium / Jadwal Penggunaan';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = JadwalLaboratorium::where('tapel_id', $etapels->id)->get();
        $DataLab = RiwayatLaboratorium::with('LaboratoriumOne')->where('tapel_id', $etapels->id)->where('detailguru_id', Auth::user()->detailguru_id)->where('laboratorium_id', request()->segment(3))->first();
        $DataGurus = Detailguru::orderBy('nama_guru')->get();
        // dump($DataLab);
        // dd($DataLab);


        return view('role.pembina.laboratorium.jadwal-laboratorium-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DataLab',
            'DataGurus',
        ));
    }

    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $kelas = Ekelas::where('kelas', $request->kelas)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->first();
        // dd(request()->segment(3));
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
            // 'laboran_id' => Auth::user()->id,
            // 'kelas_id' => $kelas->id,
            // 'tingkat_id' => $kelas->tingkat_id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            //data_field_validator
            'detailguru_id' => 'required|integer',
            'tapel_id' => 'required|integer',
            'laboratorium_id' => 'required|integer|exists:laboratorium,id',
            'tanggal_penggunaan' => 'required|date',
            'tujuan' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        JadwalLaboratorium::create($validator->validated());
        // dd($request->all());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, JadwalLaboratorium $jadwal)
    {
        //

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            //data_field_validator
            'detailguru_id' => 'required|integer',
            'tanggal_penggunaan' => 'required|date',
            'tujuan' => 'required|string|min:10',
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
        $varmodel = JadwalLaboratorium::find($id); // Pastikan $id didefinisikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($validator->validated());
            dd($request->all());
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
        //JadwalLaboratorium
        // dd(id);
        // dd(request->all());
        $data = JadwalLaboratorium::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
