<?php

namespace App\Http\Controllers\Learning;
use App\Http\Controllers\Controller;

use Exception;
use App\Models\Auth\User;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Learning\Emateri;
use Illuminate\Support\Facades\DB;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\Learning\Jurnalmengajar;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Types\Null_;

class JurnalmengajarController extends Controller
{
    //
    /*
           * Display a listing of the resource.
           Folder Name = folder
           Model = Jurnalmengajar
           Variabel Model = Jurnalmengajar
           */
    public function index(Request $request)
    {
        //Title to Controller
        $title = 'E Jurnal Mengajar Guru';
        $arr_ths = [
            'Materi',
            'Indikator',
            'Sakit',
            'Alfa'
        ];
        $breadcrumb = 'Guru / Jurnal Mengajar';
        $titleviewModal = 'Detail Data E Jurnal';
        $titleeditModal = 'Edit Data E Jurnal';
        $titlecreateModal = 'Create Data E Jurnal';
        $datas = 'Create Data E Jurnal';
        $mapel_id = $request->mapel_id;
        $kelas_id = $request->kelas_id;
        $tingkat_id = $request->tingkat_id;
        $semester = $request->semester;
        // dd($semester);
        // dd($request->kelas_id);
        // dd(Auth::user()->id);
        // dd(Auth::user()->detailguru_id);
        // variabel kebutuhan
        $kelas = Ekelas::get();
        $guru = Detailguru::get();
        // $dataid = Ekelas::select('id')->where('id', $_GET['kelas_id'])->get();
        $users = Detailsiswa::where('kelas_id', $request->kelas_id)->orderBy('id')->get();
        // $users = User::find(15)->UsersDetailsiswa->nis;
        $mater = Emateri::get();
        // dd($users);
        // dd(AuthUser::User()->id);
        $tapel = Etapel::where('aktiv', 'Y')->first();
        // dd($tapel->id);
        $kelass = Ekelas::where('Detailguru_id', Auth::User()->id)->where('tapel_id', $tapel->id)->get();
        // dd($kelass);
        // $emateris = DB::table('emateris')->select('pokok')->distinct()->get();
        //select('name')->distinct()->get();
        $emateris = Emateri::get();
        $ematerispokoks = Emateri::select('pokok')->distinct()->get();
        $ematerissubs = Emateri::select('sub_pokok')->where('mapel_id', $request->mapel_id)->where('tingkat_id', $request->tingkat_id)->distinct()->get();
        $emateriindikators = Emateri::select('indikator')->where('tingkat_id', $request->tingkat_id)->where('mapel_id', $request->mapel_id)->distinct()->get();
        // dd($ematerispokok);
        $jurnal_riwayats = Jurnalmengajar::with('EjurnalToEmateris')->where('kelas_id', $request->kelas_id)->where('detailguru_id', Auth::user()->detailguru_id)->where('tapel_id', $tapel->id)->where('semester', $tapel->semester)->orderBy('created_at', 'desc')->get();
        // $jurnal_riwayats = Jurnalmengajar::where('kelas_id', $request->kelas_id)->where('detailguru_id', Auth::user()->detailguru_id)->where('tepel_id', $tapel->id)->where('semester', $tapel->semester)->get();
        // dd($jurnal_riwayats);
        return view('role.guru.e_jurnal', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal', 'users', 'kelass', 'emateris', 'ematerispokoks', 'ematerissubs', 'emateriindikators', 'mapel_id', 'kelas_id', 'tingkat_id', 'semester', 'jurnal_riwayats'));
    }
    public function ejurnalmengajarkelas(Request $request)
    {
        //Title to Controller
        $title = 'E Jurnal Mengajar Guru';
        $arr_ths = [
            'Materi',
            'Indikator',
            'Sakit',
            'Alfa'
        ];
        $breadcrumb = 'Guru / Jurnal Mengajar';
        $titleviewModal = 'Detail Data E Jurnal';
        $titleeditModal = 'Edit Data E Jurnal';
        $titlecreateModal = 'Create Data E Jurnal';
        $datas = 'Create Data E Jurnal';
        $mapel_id = $request->mapel_id;
        $kelas_id = $request->kelas_id;
        $tingkat_id = $request->tingkat_id;
        $semester = $request->semester;
        dd($semester);
        // variabel kebutuhan
        $kelas = Ekelas::get();
        $guru = Detailguru::get();
        $users = Detailsiswa::where('kelas_id', $request->kelas_id)->orderBy('id')->get();
        $mater = Emateri::get();
        $tapel = Etapel::where('aktiv', 'Y')->first();
        $kelass = Ekelas::where('Detailguru_id', Auth::User()->id)->where('tapel_id', $tapel->id)->get();
        $emateris = Emateri::get();
        $ematerispokoks = Emateri::select('pokok')->distinct()->get();
        $ematerissubs = Emateri::select('sub_pokok')->where('mapel_id', $request->mapel_id)->where('tingkat_id', $request->tingkat_id)->distinct()->get();
        $emateriindikators = Emateri::select('indikator')->where('tingkat_id', $request->tingkat_id)->where('mapel_id', $request->mapel_id)->distinct()->get();
        $jurnal_riwayats = Jurnalmengajar::with('EjurnalToEmateris')->where('kelas_id', $request->kelas_id)->where('detailguru_id', Auth::user()->detailguru_id)->where('tapel_id', $tapel->id)->where('semester', $tapel->semester)->get();
        dd($jurnal_riwayats);
        return view('role.guru.e_jurnal', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal', 'users', 'kelass', 'emateris', 'ematerispokoks', 'ematerissubs', 'emateriindikators', 'mapel_id', 'kelas_id', 'tingkat_id', 'semester', 'jurnal_riwayats'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $etapels = Etapel::where('aktiv', 'Y')->first();
            $data = new Jurnalmengajar();
            $data->tapel_id = $etapels->id;
            $data->semester = $etapels->semester;
            $data->detailguru_id = $request->detailguru_id;
            $data->kelas_id = $request->kelas_id;
            $data->materi = $request->materi;
            $data->sub_materi = $request->sub_materi;
            $data->indikator_id = json_encode($request->indikator_id);
            $data->jam_ke = json_encode($request->jam_ke);
            $data->siswa_ijin = json_encode($request->siswa_ijin);
            $data->siswa_alfa = json_encode($request->siswa_alfa);
            $data->siswa_sakit = json_encode($request->siswa_sakit);
            $data->siswa_bolos = json_encode($request->siswa_bolos);
            $data->pertemuan_ke = $request->pertemuan_ke;
            $data->kejadian_khusus = $request->kejadian_khusus;
            $data->created_at = now();
            $data->updated_at =  now();
            $data->save();
            // dd($request->all());
            return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data disimpan dalam database');
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }

    public function update($ejurnalmengajar, $mapel_id, $semester, Request $request, Jurnalmengajar $Jurnalmengajar)
    {

            // dd($request->all());
            // dd($request->materi);
        try {

            $Jurnalmengajar = Jurnalmengajar::findOrFail($request->ejurnalmengajar);
            $Jurnalmengajar->update($request->all());

            // dd($request->all());
            return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data berhasil disimpan');
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($mapel_id, $semester, $tingkat_id, $kelas_id, $ejurnalmengajar)
    {
        //
        // dd($request->all());
        // dd($ejurnalmengajar);
        $Jurnalmengajar = Jurnalmengajar::findOrFail($ejurnalmengajar);
        $Jurnalmengajar->delete();

        // return redirect()->route('ejurnalmengajar.index')->with('Success', 'Data berhasil dihapus.');
        return redirect()->back()->with('Title', 'Berhasil DIhapus');
    }
}
