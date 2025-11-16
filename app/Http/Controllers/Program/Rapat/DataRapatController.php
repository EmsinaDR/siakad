<?php

namespace App\Http\Controllers\Program\Rapat;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\Program\Rapat\DataRapat;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Laboratorium\Elaboratorium;
use App\Models\WakaKesiswaan\Ekstra\Ekstra;
use App\Models\Program\Rapat\BeritaAcaraRapat;
use App\Models\Program\Rapat\DaftarHadirRapat;
use App\Models\Program\Surat\SuratKlasifikasi;

class DataRapatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Rapat';
        $arr_ths = [
            'Rapat',
            'Hari dan Tanggal',
            'Perihal',
            'Jam',
            'Tempat',
            'Tembusan',
        ];
        $breadcrumb = 'Menu_breadcume / Data Rapat';
        $titleviewModal = 'Lihat Data Rapat';
        $titleeditModal = 'Edit Data Rapat';
        $titlecreateModal = 'Create Data Rapat';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = DataRapat::where('tapel_id', $etapels->id)->orderBy('created_at', 'DESC')->get();
        $KlasifikasiSurats = SuratKlasifikasi::get();
        return view('role.program.rapat.data-rapat', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'KlasifikasiSurats',
        ));
        //php artisan make:view role.program.rapat.data-rapat
        //php artisan make:view role.program.rapat.data-rapat-edit

    }
    public function edit($id)
    {
        $title = 'Edit Data Rapat';
        $breadcrumb = 'Edit Data Rapat / Data Rapat';
        $etapels = Etapel::where('aktiv', 'Y')->first();

        $data = DataRapat::findOrFail($id);


        // $datas = DataRapat::where('tapel_id', $etapels->id)->get();
        // dd($datas);
        return view('role.program.rapat.data-rapat-edit', compact(
            // 'datas',
            'title',
            'breadcrumb',
            'data',
        ));
    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Rapat';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Menu_breadcume / Data Rapat';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = DataRapat::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.rapat.data-rapat-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.rapat.data-rapat-single
    }

    public function store(Request $request)
    {

        //
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'detailguru_id' => Auth::user()->id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'tapel_id' => 'nullable|integer',
            'nomor_surat' => 'nullable|string|max:255',
            'nama_rapat' => 'nullable|string|max:255',
            'detailguru_id' => 'nullable|integer',
            'tanggal_pelaksanaan' => 'nullable|date',
            'perihal' => 'nullable|string',
            // 'vote_id' => 'nullable|array',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',
            'tempat' => 'nullable|string|max:255',
            'tembusan' => 'nullable|string|max:255',
            'notulen' => 'nullable|string',
            'keternagan' => 'nullable|string',
        ]);

        // if ($validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }



        DataRapat::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, DataRapat $datarapat)
    {
        //

        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'detailguru_id' => Auth::user()->id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'tapel_id' => 'nullable|integer',
            'nomor_surat' => 'nullable|string|max:255',
            'nama_rapat' => 'nullable|string|max:255',
            'detailguru_id' => 'nullable|integer',
            'tanggal_pelaksanaan' => 'nullable|date',
            'perihal' => 'nullable|string',
            // 'vote_id' => 'nullable|array',
            'jam_mulai' => 'nullable|date_format:h:i',
            'jam_selesai' => 'required|date_format:h:i',
            'tempat' => 'nullable|string|max:255',
            'tembusan' => 'nullable|string|max:255',
            'notulen' => 'nullable|string',
            'keternagan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $varmodel = DataRapat::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //DataRapat
        // dd($id);
        // dd($request->all());
        $data = DataRapat::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
    public function UpdateVote()
    {
        //dd($request->all());
        // body_method
    }
    public function CetakDataRapat($id)
    {
        //dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $datas = DaftarHadirRapat::where('tapel_id', $etapels->id)->get();
        $datas = DataRapat::findOrFail($id);
        // dump($datas, $datas->notulen);
        // $datas = BeritaAcaraRapat::where('tapel_id', $etapels->id)->get();
        return view('role.program.rapat.data-rapat-cetak', compact(
            'datas',
        ));
    }
}
/*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
composer dump-autoload

*/