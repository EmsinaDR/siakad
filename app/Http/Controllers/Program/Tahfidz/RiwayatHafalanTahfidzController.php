<?php

namespace App\Http\Controllers\Program\Tahfidz;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Tahfidz\TahfidzSurat;
use App\Models\Program\Tahfidz\TahfidzPeserta;
use App\Models\Program\Tahfidz\RiwayatHafalanTahfidz;

class RiwayatHafalanTahfidzController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    RiwayatHafalanTahfidz
    $tahfidzrowayat
    role.program.tahfidz
    role.program.tahfidz.riwayat-hafalan
    role.program.tahfidz.blade_show
    Index = Pembina Program
    Breadcume Index = 'Pembina Program / Riwayat Hafalan';
    Single = Riwayat Hafalan
    php artisan make:view role.program.tahfidz.riwayat-hafalan
    php artisan make:view role.program.tahfidz.riwayat-hafalan-single
    php artisan make:seed RiwayatHafalanTahfidzSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Pembina Program';
        $arr_ths = [
            'Nama Peserta',
            'Hafalan Surat',
            'Ayat',
        ];
        $breadcrumb = 'Pembina Program / Riwayat Hafalan';
        $titleviewModal = 'Lihat Data Pembina Program';
        $titleeditModal = 'Edit Data Pembina Program';
        $titlecreateModal = 'Create Data Pembina Program';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $DataPesertas = TahfidzPeserta::select('tahfidz_peserta.*')->where('pembimbing_id', Auth::user()->id)
            ->join('detailsiswas', 'tahfidz_peserta.detailsiswa_id', '=', 'detailsiswas.id')
            ->orderBy('detailsiswas.kelas_id', 'asc')
            ->orderBy('detailsiswas.nama_siswa', 'asc')
            ->with('SiswaOne')
            ->get();

        $datas = RiwayatHafalanTahfidz::select('*')->where('pembimbing_id', Auth::user()->id)
            ->whereRaw('id IN (SELECT MAX(id) FROM tahfidz_riwayat GROUP BY detailsiswa_id)')
            ->get();

        // dump($datas);
        $DataSurats = TahfidzSurat::get();
        $titlecreateModal = 'Create Data Peserta Tahfidz';
        // $datas = TahfidzPeserta::with('siswa')->get();
        $DataSiswas = Detailsiswa::orderBy('kelas_id')->orderBy('nama_siswa')->get();
        $Pembimbings = Detailguru::orderBy('nama_guru')->get();



        return view('role.program.tahfidz.riwayat-hafalan', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DataSiswas',
            'Pembimbings',
            'DataPesertas',
            'DataSurats',
        ));
        //php artisan make:view role.program.tahfidz.riwayat-hafalan

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Riwayat Hafalan';
        $arr_ths = [
            'Nama Peserta',
            'Hafalan Surat',
            'Ayat',
            'Keterangan',
        ];
        $breadcrumb = 'Pembina Program / Riwayat Hafalan';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = RiwayatHafalanTahfidz::orderBy('created_at', 'DESC')->where('detailsiswa_id', request()->segment(4))->get();

        // dump($datas);
        $titlecreateModal = 'Create Data Peserta Tahfidz';
        // $datas = TahfidzPeserta::with('siswa')->get();
        $DataSiswas = Detailsiswa::orderBy('kelas_id')->orderBy('nama_siswa')->get();
        $Pembimbings = Detailguru::orderBy('nama_guru')->get();
        $DataPesertas = TahfidzPeserta::select('tahfidz_peserta.*')
            ->join('detailsiswas', 'tahfidz_peserta.detailsiswa_id', '=', 'detailsiswas.id')
            ->orderBy('detailsiswas.kelas_id', 'asc')
            ->orderBy('detailsiswas.nama_siswa', 'asc')
            ->with('SiswaOne')
            ->get();
        $Pembimbings = Detailguru::orderBy('nama_guru')->get();
        $DataSurats = TahfidzSurat::get();





        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.tahfidz.riwayat-hafalan-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DataSiswas',
            'Pembimbings',
            'DataPesertas',
            'DataSurats',
        ));
        //php artisan make:view role.program.tahfidz.riwayat-hafalan-single
    }

    public function store(Request $request)
    {
        //
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $request->merge([
            'tapel_id' => $etapels->id,
            'pembimbing_id' => Auth::user()->id,
        ]);
        $validator = Validator::make($request->all(), [
            'detailsiswa_id' => 'nullable|exists:detailsiswas,id',
            'pembimbing_id' => 'nullable|exists:detailgurus,id',
            'surat_id' => 'nullable|exists:tahfidz_surat,id',
            'ayat' => 'required|array', // ✅ Pastikan ayat adalah array
            'ayat.*' => 'integer|min:1', // ✅ Setiap elemen harus angka minimal 1
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan ke database dengan mengonversi ayat ke JSON
        RiwayatHafalanTahfidz::create([
            'detailsiswa_id' => $request->detailsiswa_id,
            'pembimbing_id' => $request->pembimbing_id,
            'surat_id' => $request->surat_id,
            'ayat' => json_encode($request->ayat), // ✅ Konversi ke JSON sebelum insert
            'keterangan' => $request->keterangan,
        ]);
        // dd($request->all());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, RiwayatHafalanTahfidz $tahfidzrowayat)
    {
        //

        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'detailsiswa_id' => 'nullable|exists:detailsiswas,id',
            'pembimbing_id' => 'nullable|exists:detailgurus,id',
            'surat_id' => 'nullable|exists:tahfidz_surat,id',
            'ayat' => 'required|array', // ✅ Pastikan ayat adalah array
            'ayat.*' => 'integer|min:1', // ✅ Setiap elemen harus angka minimal 1
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan ke database dengan mengonversi ayat ke JSON
        $dataUpdate = [
            'surat_id' => $request->surat_id,
            'ayat' => json_encode($request->ayat), // ✅ Konversi ke JSON sebelum insert
            'keterangan' => $request->keterangan,
        ];
        $varmodel = RiwayatHafalanTahfidz::find($id); // Pastikan $id didefinisikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($dataUpdate);
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
        //RiwayatHafalanTahfidz
        // dd(id);
        // dd(request->all());
        $data = RiwayatHafalanTahfidz::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
