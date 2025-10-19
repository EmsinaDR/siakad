<?php

namespace App\Http\Controllers\Program\BTQ;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\Program\BTQ\PesertaBTQ;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PesertaBTQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    PesertaBTQ
    $pesertabtq
    role.program.btq
    role.program.btq.peserta-btq
    role.program.btq.blade_show
    Index = Data Peserta BTQ
    Breadcume Index = 'Pembina TQ / Data Peserta BTQ';
    Single = Data Peserta BTQ
    php artisan make:view role.program.btq.peserta-btq
    php artisan make:view role.program.btq.peserta-btq-single
    php artisan make:seed PesertaBTQSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Peserta BTQ';
        $arr_ths = [
            'Nama Siswa',
            'Kelas',
            'Pembimbing',
            'Hari Bimbingan',
        ];
        $breadcrumb = 'Pembina TQ / Data Peserta BTQ';
        $titleviewModal = 'Lihat Data Peserta BTQ';
        $titleeditModal = 'Edit Data Peserta BTQ';
        $titlecreateModal = 'Create Data Peserta BTQ';
        $datas = PesertaBTQ::with('SiswaOne', 'kelas', 'Guru')->where('pembimbing_id', Auth::user()->id)->get();
        // $datas = PesertaBTQ::get();
        // dump($datas);
        $datas = PesertaBTQ::with('SiswaOne', 'kelas', 'Guru')
            ->where('pembimbing_id', Auth::user()->id)
            ->orderBy('kelas_id') // Urutkan berdasarkan kelas_id terlebih dahulu
            ->orderByRaw('(SELECT nama_siswa FROM detailsiswas WHERE detailsiswas.id = btq_peserta.detailsiswa_id) ASC')
            ->get();

        $datas = PesertaBTQ::join('detailsiswas', 'detailsiswas.id', '=', 'btq_peserta.detailsiswa_id')
            ->with('SiswaOne', 'kelas', 'Guru')
            ->where('btq_peserta.pembimbing_id', Auth::user()->id)
            ->orderBy('detailsiswas.kelas_id') // Urutkan berdasarkan kelas_id terlebih dahulu
            ->orderBy('detailsiswas.nama_siswa') // Urutkan berdasarkan nama_siswa
            ->select('btq_peserta.*') // Pastikan hanya memilih kolom dari PesertaBTQ untuk menghindari konflik
            ->get();

        $DataSiswas = Detailsiswa::orderBy('kelas_id')->orderBy('nama_siswa')->get();
        $Pembimbings = Detailguru::orderBy('nama_guru')->get();


        return view('role.program.btq.peserta-btq', compact(
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
        //php artisan make:view role.program.btq.peserta-btq

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Peserta BTQ';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Pembina TQ / Data Peserta BTQ';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = PesertaBTQ::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.btq.peserta-btq-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.program.btq.peserta-btq-single
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

        PesertaBTQ::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, PesertaBTQ $pesertabtq)
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
        $varmodel = PesertaBTQ::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //PesertaBTQ
        // dd(id);
        // dd(request->all());
        $data = PesertaBTQ::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
