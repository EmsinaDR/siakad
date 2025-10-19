<?php

namespace App\Http\Controllers\Bendahara;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Bendahara\RiwayatStudyTour;
use App\Models\Bendahara\BendaharaStudyTour;
use Symfony\Component\Routing\Matcher\RedirectableUrlMatcher;

class BendaharaStudyTourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Title to Controller
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $title = 'Dasboard Bendahara Study Tour';
        $arr_ths = [
            'NIS',
            'Kelas',
            'Nama Siswa',
            'Terbayar',
            'Sisa'
        ];
        $breadcrumb = 'Bendahara / Dasboard Bendahara Study Tour';
        $titleviewModal = 'Lihat Data Bendahara Study Tour';
        $titleeditModal = 'Edit Data Bendahara Study Tour';
        $titlecreateModal = 'Create Data Bendahara Study Tour';

        $datas = BendaharaStudyTour::wherE('tapel_id', $etapels->id)->get();
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.bendahara.studytour.home-study-tour', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $siswa = Detailsiswa::where('id', $request->detailsiswa_id)->first();
        // dd($siswa);
        $request->merge([
            'tapel_id' => $etapels->id,
            'kelas_id' => $siswa->kelas_id,
            'petugas_id' => Auth::user()->id,
            'nomor_pembayaran' => 'STDTOUR-' . date('Ymd'),
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'tapel_id' => 'required|numeric',
            'petugas_id' => 'required|numeric',
            'kelas_id' => 'required|numeric',
            'detailsiswa_id' => 'required|numeric',
            'nominal' => 'required|numeric',
            'nomor_pembayaran' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
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
        BendaharaStudyTour::create($validator->validated());
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Disimpan');
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(BendaharaStudyTour $bendaharaStudyTour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BendaharaStudyTour $bendaharaStudyTour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request, BendaharaStudyTour $bendaharaStudyTour)
    {
        //

        // Validasi data
        $validator = Validator::make($request->all(), [
            'nominal' => 'required|numeric',
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
        $varmodel = BendaharaStudyTour::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
    public function destroy(BendaharaStudyTour $bendaharaStudyTour)
    {
        //
    }
    public function InputStudyTour()
    {
        //
        //Title to Controller
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $title = 'Bendahara Study Tour';
        $arr_ths = [
            'NIS',
            'Kelas',
            'Nama Siswa',
            'Terbayar',
            'Sisa'
        ];
        $breadcrumb = 'Bendahara / Bendahara Study Tour';
        $titleviewModal = 'Lihat Data Bendahara Study Tour';
        $titleeditModal = 'Edit Data Bendahara Study Tour';
        $titlecreateModal = 'Create Data Bendahara Study Tour';

        $datas = BendaharaStudyTour::wherE('tapel_id', $etapels->id)->get();
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.bendahara.studytour.input-study-tour', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
    public function DataStudyTour()
    {
        //
        //Title to Controller
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $title = 'Data Study Tour';
        $arr_ths = [
            'NIS',
            'Kelas',
            'Nama Siswa',
            'Terbayar',
            'Sisa'
        ];
        $breadcrumb = 'Bendahara / Bendahara Study Tour';
        $titleviewModal = 'Lihat Data Bendahara Study Tour';
        $titleeditModal = 'Edit Data Bendahara Study Tour';
        $titlecreateModal = 'Create Data Bendahara Study Tour';
        $total_terbayar = BendaharaStudyTour::select('nominal')->where('tapel_id', $etapels->id)->sum('nominal');
        //Mengambil data id kelas 8 berdasarkan tapel yang digunakan untuk menghubungakn dengand ata siswa
        $ekelas = Ekelas::where('tingkat_id', 8)->where('tapel_id', $etapels->id)->pluck('id')->toArray();
        $total_siswa = Detailsiswa::whereIn('kelas_id', $ekelas)->count();
        $riwayat_study_tour = RiwayatStudyTour::where('tapel_id', $etapels->id)->first();
        $datas = Detailsiswa::whereIn('kelas_id', $ekelas)->orderBy('kelas_id')->get();
        // dd($datas);
        // dd($riwayat_study_tour->nominal);

        // dd($total_siswa);
        // dd($total_terbayar);
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.bendahara.studytour.data-study-tour', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal', 'total_siswa', 'riwayat_study_tour', 'total_terbayar'));
    }

    public function SettingStudyTour()
    {

        //dd($request->all());
        //Title to Controller
        $title = 'Pengaturan Sudy Tour';
        $arr_ths = [
            'Tahun',
            'Nama Biro',
            'Nama Kontak',
            'No HP',
            'Nominal'
        ];
        $breadcrumb = 'Bendahara / Bendahara Study Tour / Setting';
        $titleviewModal = 'Lihat Data Pengaturan Sudy Tour';
        $titleeditModal = 'Edit Data Pengaturan Sudy Tour';
        $titlecreateModal = 'Create Data Pengaturan Sudy Tour';
        $datas = RiwayatStudyTour::orderBy('tapel_id', 'ASC')->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.bendahara.studytour.pengaturan-study-tour', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
}
