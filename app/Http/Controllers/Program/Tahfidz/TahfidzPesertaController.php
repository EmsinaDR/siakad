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
use App\Models\Program\Tahfidz\TahfidzPeserta;

class TahfidzPesertaController extends Controller
{
    /**
     * Display a listing of the resource.

     */
    /*
    TahfidzPeserta
    $TahfidzPeserta
    role.program.tahfidz
    role.program.tahfidz.peserta-tahfidz
    role.program.tahfidz.blade_show
    Index = Peserta Tahfidz
    Breadcume Index = 'Pembina Tahfidz / Peserta Tahfidz';
    Single = Peserta Tahfidz
    php artisan make:view role.program.tahfidz.peserta-tahfidz
    php artisan make:view role.program.tahfidz.peserta-tahfidz-single
    php artisan make:seed TahfidzPesertaSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Peserta Tahfidz';
        $arr_ths = [
            'Nama Siswa',
            'Kelas',
            'Pembimbing',
            'Hari Bimbingan',
        ];
        $breadcrumb = 'Pembina Tahfidz / Peserta Tahfidz';
        $titleviewModal = 'Lihat Data Peserta Tahfidz';
        $titleeditModal = 'Edit Data Peserta Tahfidz';
        $titlecreateModal = 'Create Data Peserta Tahfidz';
        $datas = TahfidzPeserta::with('siswa')->where('pembimbing_id', Auth::user()->id)->get();

        $DataSiswas = Detailsiswa::orderBy('kelas_id')->orderBy('nama_siswa')->get();
        $Pembimbings = Detailguru::orderBy('nama_guru')->get();


        return view('role.program.tahfidz.peserta-tahfidz', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DataSiswas',
            'Pembimbings',
        ));
        //php artisan make:view role.program.tahfidz.peserta-tahfidz

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Peserta Tahfidz';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Pembina Tahfidz / Peserta Tahfidz';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = TahfidzPeserta::with('siswa')->where('pembimbing_id', Auth::user()->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.tahfidz.peserta-tahfidz-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.tahfidz.peserta-tahfidz-single
    }

    public function store(Request $request)
    {
        //

        $etapels = Etapel::where('aktiv', 'Y')->first();

        if (!$etapels) {
            return redirect()->back()->withErrors(['tapel_id' => 'Tidak ada tahun pelajaran aktif.']);
        }

        $request->merge([
            'tapel_id' => $etapels->id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'detailsiswa_id' => 'nullable|array',
            'detailsiswa_id.*' => 'exists:detailsiswas,id',
            'pembimbing_id' => 'nullable|exists:detailgurus,id',
            'hari_bimbingan' => 'nullable|string',
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Pastikan detailsiswa_id ada sebelum foreach
        if ($request->has('detailsiswa_id') && is_array($request->detailsiswa_id)) {
            foreach ($request->detailsiswa_id as $detailsiswa_id) {
                TahfidzPeserta::create([
                    'detailsiswa_id' => $detailsiswa_id,
                    'pembimbing_id' => $request->pembimbing_id,
                    'hari_bimbingan' => $request->hari_bimbingan,
                    'tapel_id' => $etapels->id, // Simpan tapel_id juga jika dibutuhkan
                ]);
            }
        }


        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, TahfidzPeserta $TahfidzPeserta)
    {
        //

        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();

        if (!$etapels) {
            return redirect()->back()->withErrors(['tapel_id' => 'Tidak ada tahun pelajaran aktif.']);
        }

        $request->merge([
            'tapel_id' => $etapels->id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'detailsiswa_id.*' => 'exists:detailsiswas,id',
            'pembimbing_id' => 'nullable|exists:detailgurus,id',
            'hari_bimbingan' => 'nullable|string',
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $varmodel = TahfidzPeserta::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //TahfidzPeserta
        // dd(id);
        // dd(request->all());
        $data = TahfidzPeserta::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
