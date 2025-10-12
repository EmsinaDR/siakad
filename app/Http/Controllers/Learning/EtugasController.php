<?php

namespace App\Http\Controllers\Learning;

use Exception;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
// use App\Models\Learning\Etugas;
use App\Models\Learning\Etugas;
use App\Models\Learning\Emengajar;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class EtugasController extends Controller
{
    //
    public function index(Request $request)
    {
        //Title to Controller
        $title = 'E Tugas';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad'
        ];

        $breadcrumb = 'Guru / E Tugas Siswa';
        $titleviewModal = 'Lihat Data E Tugas';
        $titleeditModal = 'Edit Data E Tugas';
        $titlecreateModal = 'Create Data E Tugas';
        $mapel_id = $request->mapel_id;
        $tingkat_id = $request->tingkat_id;
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Guru / E Tugas Siswa';
        $titleviewModal = 'Lihat Data E Tugas';
        $titleeditModal = 'Edit Data E Tugas';
        $titlecreateModal = 'Create Data E Tugas';
        $mapel_id = $request->mapel_id;
        $tingkat_id = $request->tingkat_id;
        $kelas_id = $request->kelas_id;
        $etugas = Etugas::with(['etugastomateri', 'etugastodetailguru', 'etugastokelas'])->where('detailguru_id', Auth::User()->id)->where('tingkat_id', $tingkat_id)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->orderBy('created_at')->get();
        $etugas = Etugas::where('detailguru_id', Auth::User()->id)->where('tingkat_id', $tingkat_id)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->orderBy('created_at')->get();


        $kelas_mengajar = Emengajar::where('tapel_id', $etapels->id)->where('tingkat_id', $tingkat_id)->where('mapel_id', $mapel_id)->where('semester', $etapels->semester)->where('detailguru_id', Auth::user()->id)->orderBy('kelas_id')->get();
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.guru.e_tugas', compact('title', 'breadcrumb', 'arr_ths', 'titleviewModal', 'titleeditModal', 'titlecreateModal', 'mapel_id', 'tingkat_id', 'kelas_id', 'kelas_mengajar', 'etugas'));
    }
    // public function etugassiswa(Request $request)
    // {
    //     //Title to Controller
    //     $title = 'E Tugas';
    //     $arr_ths = [
    //         'title_tabela',
    //         'title_tabelab',
    //         'title_tabelac',
    //         'title_tabelad'
    //     ];
    //     $etapels = Etapel::where('aktiv', 'Y')->first();
    //     $breadcrumb = 'Guru / E Tugas Siswa';
    //     $titleviewModal = 'Lihat Data E Tugas';
    //     $titleeditModal = 'Edit Data E Tugas';
    //     $titlecreateModal = 'Create Data E Tugas';
    //     $mapel_id = $request->mapel_id;
    //     $tingkat_id = $request->tingkat_id;
    //     // dd($mapel_id);
    //     $kelas_id = $request->kelas_id;
    //     $cek = $tingkat_id . " " . $mapel_id . " " . $kelas_id;
    //     // dd(Auth::user()->id);
    //     $kelas_mengajar = Emengajar::where('tapel_id', $etapels->id)->where('tingkat_id', $tingkat_id)->where('mapel_id', $mapel_id)->where('semester', $etapels->semester)->where('detailguru_id', Auth::user()->id)->orderBy('kelas_id')->get();
    //     // dd($kelas_mengajar);
    //     // return $cek;
    //     $etugas = Etugas::with(['etugastomateri', 'etugastodetailguru', 'etugastokelas'])->where('detailguru_id', Auth::User()->id)->where('tingkat_id', $tingkat_id)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->orderBy('created_at')->get();
    //     $etugas = Etugas::where('detailguru_id', Auth::User()->id)->where('tingkat_id', $tingkat_id)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->orderBy('created_at')->get();
    //     //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
    //     return view('role.guru.e_tugas', compact('title', 'breadcrumb', 'arr_ths', 'titleviewModal', 'titleeditModal', 'titlecreateModal', 'mapel_id', 'tingkat_id', 'kelas_id', 'kelas_mengajar', 'etugas'));
    // }
    public function store(Request $request)
    {
        try {
            //Title to Controller
            $etapels = Etapel::where('aktiv', 'Y')->first();
            $data = $request->except(['_token']);
            $data['indikator_id'] = implode(',', $request->indikator_id);
            foreach ($request->kelas_id as $kelas) {
                $data['created_at'] = now();
                $data['updated_at'] = now();
                $data['kelas_id'] = $kelas;
                $data['detailguru_id'] = Auth::User()->id;
                $data['mapel_id'] = $request->mapel_id;
                $data['deadline'] = $request->deadline;
                $data['tapel_id'] = $etapels->id;
                $data['semester'] = $etapels->semester;
                Etugas::insert($data);
            }
            return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data Tugas Berhasil Disimpan pada databse E Tugas');
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }

    // public function etugasupdate($id, Request $request)
    // {
    //     $data = $request->except(['_token', '_method']);
    //     $data = Etugas::findOrFail($id);
    //     // dd($data);
    //     $data->kelas_id = $request->kelas_id;
    //     $data->link = strtoupper($request->link);
    //     $data->deadline = $request->deadline;
    //     $data->keterangan = $request->keterangan;
    //     $data->updated_at = now();
    //     $data->update();
    //     // dd($data);
    //     return Redirect::back()->with('Title', 'Update Data.')->with('Success', 'Data berhasil di update.');
    // }
    public function destroy($mapel_id, $tingkat_id, $kelas_id, $data_tuga, $id, Request $request)
    {
        try {
            //
            // dd($id);
            // dd($request->all());
            $VarEtugas = Etugas::findOrFail($id);
            $VarEtugas->delete();

            return Redirect::back()->with('Title', 'Hapus Data.')->with('Success', 'Data berhasil dihapus.');
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }
    public function update($mapel_id, $tingkat_id, $kelas_id, $data_tuga, $id, Request $request)
    {
        //
        try {
            // dd($id);
            // dd($request->all());
            $data = Etugas::findOrFail($id);
            $data->kelas_id = $request->kelas_id;
            $data->deadline = $request->deadline;
            $data->link = $request->link;
            $data->keterangan = $request->keterangan;
            $data->update();
            $data = Etugas::findOrFail($id);
            // dd($data);
            // dd($request->all());

            return Redirect::back()->with('Title', 'Hapus Data.')->with('Success', 'Data berhasil dihapus.');
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }
}
