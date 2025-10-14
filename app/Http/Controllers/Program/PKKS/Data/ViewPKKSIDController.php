<?php

namespace App\Http\Controllers\Program\PKKS\Data;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Admin\Identitas;
use App\Models\Walkes\JadwalPiket;
use App\Models\Program\SOP\DataSOP;
use App\Http\Controllers\Controller;
use App\Models\Admin\Peraturan;
use App\Models\bk\Ebkkreditpoint;
use App\Models\bk\Ebkpelanggaran;
use App\Models\User\Guru\Detailguru;
use App\Models\Program\PKKS\DataPKKS;
use App\Models\Program\Rapat\DataRapat;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Laboratorium\Laboratorium;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Tupoksi\DataTupoksi;
use App\Models\WakaKesiswaan\Ekstra\Ekstra;
use App\Models\Laboratorium\RiwayatLaboratorium;
use App\Models\Program\Dokumentasi\DataDokumentasi;
use App\Models\Program\MGMP\DataMGMP;
use App\Models\Program\Prestasi\DataPrestasi;
use App\Models\Program\StrukturSekolah\DataStrukturSekolah;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\WakaKesiswaan\Ekstra\RiwayatEkstra;
use App\Models\WakaKurikulum\JadwalPiket\DataJadwalPiket;

class ViewPKKSIDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    php artisan optimize:clear




     */
    public function index()
    {
        //dd($request->all());
        // body_method
    }
    public function show($id)
    {
        // Membuat nama metode dinamis berdasarkan nilai id
        $method = 'id_' . $id;

        // Mengecek apakah metode dengan nama tersebut ada di controller
        if (method_exists($this, $method)) {
            // Memanggil metode dinamis
            $DataPPKS = DataPKKS::findorFail($id);
            $Identitas = \App\Models\Admin\Identitas::first();
            $Tapels = \App\Models\Admin\Etapel::where('aktiv', 'Y')->first();



            // Mengambil Data Tapel 3 tapel Terakhir
            $TapelsPKKS = Etapel::orderBy('id', 'DESC')->pluck('id')->toArray();
            $indices = [0, 2, 4];
            $TapelSelecteds = array_intersect_key($TapelsPKKS, array_flip($indices));
            // Mengambil Data Tapel 3 tapel Terakhir

            return $this->$method($DataPPKS, $Identitas, $Tapels, $TapelSelecteds);
        } else {
            // Jika metode tidak ditemukan, bisa mengembalikan pesan atau halaman 404
            return abort(404, 'Metode tidak ditemukan');
        }
    }

    // Metode id_1
    public function id_1($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {

        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        $DataStrukturs = DataStrukturSekolah::with('guru')->get();
        dump($DataStrukturs);
        $dataRapats = DataRapat::where('nama_rapat', 'Rapat Pembagian Tugas')
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan waktu dibuat, terbaru di atas
            ->take(3) // Ambil 3 data terakhir
            ->get();

        return view('role.program.pkks.data.id_1', compact(
            'datas',
            'title',
            'breadcrumb',
            'DataPPKS',
            'dataRapats',
            'DataStrukturs',
        ));
    }

    // Metode id_2
    public function id_2($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        $dataRapats = DataRapat::where('nama_rapat', 'Rapat Pembagian Tugas')->get();
        $Laboratoriums = RiwayatLaboratorium::get();
        // dump($Laboratoriums);
        return view('role.program.pkks.data.id_2', compact(
            'datas',
            'title',
            'breadcrumb',
            'DataPPKS',
            'Identitas',
            'Tapels',
            'dataRapats',
            'Laboratoriums',
        ));
    }
    public function id_3($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' .
            $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        $dataRapats = DataRapat::where('nama_rapat', 'Rapat Pembagian Tugas')->get();
        return view('role.program.pkks.data.id_3', compact(
            'datas',
            'title',
            'breadcrumb',
            'DataPPKS',
            'dataRapats',
            'Identitas',
            'Tapels',
        ));
    }
    public function id_4($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        $DataEkstras = RiwayatEkstra::get();
        $DataKelass = Ekelas::get();
        $DataPikets = DataJadwalPiket::get();
        $DataPikets = DataJadwalPiket::get();
        // dump($DataPikets);
        // dump($TapelSelecteds, $DataEkstra);
        // $SKPembagianTugas = DataSK::where('nama_sk', 'SK Pembagian Tugas')->orderBy('tapel_id', 'DESC')->take(3)->get();
        return view('role.program.pkks.data.id_4', compact(
            'datas',
            'title',
            'breadcrumb',
            'breadcrumb',
            'Identitas',
            'DataPPKS',
            'Tapels',
            'DataEkstras',
            'TapelSelecteds',
            'DataKelass',
            'DataPikets',
        ));
    }

    public function id_5($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        $DataTupoksis = DataTupoksi::get();
        // dump($DataTupoksis);

        return view('role.program.pkks.data.id_5', compact(
            'datas',
            'title',
            'breadcrumb',
            'DataPPKS',
            'DataTupoksis',
            'Identitas',
            'Tapels',
        ));
    }

    public function id_6($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        $DataSOPs = DataSOP::get();
        return view('role.program.pkks.data.id_6', compact(
            'datas',
            'title',
            'breadcrumb',
            'DataPPKS',
            'Identitas',
            'Tapels',
            'DataSOPs',
        ));
    }

    public function id_7($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_7', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_8($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {

        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        $DataSOPs = DataSOP::get();
        return view('role.program.pkks.data.id_8', compact(
            'datas',
            'title',
            'breadcrumb',
            'DataPPKS',
            'Identitas',
            'Tapels',
            'DataSOPs',
            'TapelSelecteds',
        ));
    }

    public function id_9($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_9', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_10($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        $DataPrestasis = DataPrestasi::whereIn('tapel_id', $TapelSelecteds)->get();
        dump($DataPrestasis);
        return view('role.program.pkks.data.id_10', compact(
            'datas',
            'title',
            'breadcrumb',
            'DataPPKS',
            'DataPrestasis',
            'TapelSelecteds',
        ));
    }

    public function id_11($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_11', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_12($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        $DataSiswas = \App\Models\User\Siswa\Detailsiswa::whereNotNull('tahun_lulus')->get();

        // dd($DataSiswas->toArray());
        // dd($DataSiswas);
        return view('role.program.pkks.data.id_12', compact(
            'datas',
            'title',
            'breadcrumb',
            'DataPPKS',
            'DataPPKS',
            'TapelSelecteds',
            'DataSiswas',
        ));
    }

    public function id_13($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_13', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_14($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_14', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_15($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    { {
            $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
            $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
            $datas = Detailguru::get();
            $DataTupoksis = DataTupoksi::get();
            // dump($DataTupoksis);

            return view('role.program.pkks.data.id_15', compact(
                'datas',
                'title',
                'breadcrumb',
                'DataPPKS',
                'DataTupoksis',
                'Identitas',
                'Tapels',
            ));
        }
    }

    public function id_16($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = DataMGMP::get();
        return view('role.program.pkks.data.id_16', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_17($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = DataMGMP::get();

        return view('role.program.pkks.data.id_17', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_18($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_18', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_19($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_19', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_20($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_20', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_21($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_21', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_22($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_22', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_23($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        $DataBKs = Ebkkreditpoint::get();
        $DataPeraturans = Peraturan::where('kategori', 'Akademik')->get();
        // dump($DataPeraturans);
        return view('role.program.pkks.data.id_23', compact(
            'datas',
            'title',
            'breadcrumb',
            'DataPPKS',
            'DataBKs',
            'DataPeraturans',
        ));
    }

    public function id_24($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = DataPrestasi::orderBy('pelaksanaan', 'DESC')->whereIn('tapel_id', [$Tapels->id, $Tapels->id - 1])->get();
        // $datas = DataPrestasi::orderBy('pelaksanaan', 'DESC')->get();
        return view('role.program.pkks.data.id_24', compact(
            'datas',
            'title',
            'breadcrumb',
            'DataPPKS'
        ));
    }
    public function id_25($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_25', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_29($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_29', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_30($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_30', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_31($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_31', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_32($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_32', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_33($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = DataDokumentasi::get();
        return view('role.program.pkks.data.id_33', compact(
            'datas',
            'title',
            'breadcrumb',
            'DataPPKS'
        ));
    }

    public function id_34($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = DataDokumentasi::get();
        // dd($datas);
        return view('role.program.pkks.data.id_34', compact(
            'datas',
            'title',
            'breadcrumb',
            'DataPPKS'
        ));
    }

    public function id_35($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = DataDokumentasi::get();
        $Dokumentasis = DataDokumentasi::orderBy('tapel_id', 'DESC')->get();
        // dd($Dokumentasis);
        return view('role.program.pkks.data.id_35', compact(
            'datas',
            'title',
            'breadcrumb',
            'DataPPKS',
            'Dokumentasis',
        ));
    }

    public function id_36($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_36', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_37($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_37', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_38($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_38', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_39($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_39', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_40($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_40', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_41($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_41', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_42($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        $DataBKs = Ebkkreditpoint::get();
        $DataPeraturans = Peraturan::where('kategori', 'Akademik')->get();
        // dump($DataPeraturans);
        return view('role.program.pkks.data.id_23', compact(
            'datas',
            'title',
            'breadcrumb',
            'DataPPKS',
            'DataBKs',
            'DataPeraturans',
        ));
    }

    public function id_43($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_43', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_44($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_44', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    public function id_45($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_45', compact('datas', 'title', 'breadcrumb', 'DataPPKS'));
    }

    // Continue in the same pattern for the remaining functions (id_46 to id_74)



    public function id_81($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_81', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_82($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_82', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_83($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_83', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_84($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_84', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_85($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_85', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_86($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_86', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_87($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_87', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_88($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_88', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_89($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_89', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_90($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_90', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_91($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_91', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_92($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_92', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_93($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_93', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_94($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_94', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_95($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_95', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_96($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_96', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_97($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_97', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_98($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_98', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_99($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_99', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_100($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_100', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_101($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_101', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_102($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_102', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_103($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_103', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_104($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_104', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_105($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_105', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_106($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_106', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_107($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_107', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_108($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_108', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_109($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_109', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_110($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_110', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_111($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_111', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_112($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_112', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_113($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_113', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_114($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_114', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_115($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_115', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_116($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_116', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_117($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_117', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_118($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_118', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_119($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_119', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_120($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_120', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_121($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_121', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_122($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_122', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_123($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_123', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_124($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_124', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_125($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_125', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_126($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_126', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_127($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_127', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_128($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_128', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_129($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_129', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_130($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_130', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_131($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_131', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_132($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_132', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_133($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_133', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_134($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_134', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_135($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_135', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_136($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_136', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_137($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_137', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_138($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_138', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_139($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_139', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_140($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_140', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_141($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_141', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_142($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_142', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_143($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_143', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_144($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_144', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_145($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_145', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_146($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_146', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_147($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_147', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_148($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_148', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_149($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_149', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_150($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_150', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_151($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_151', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_152($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_152', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_153($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_153', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_154($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_154', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_155($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_155', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_156($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_156', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_157($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_157', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_158($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_158', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_159($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_159', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_160($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_160', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_161($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_161', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_162($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_162', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_163($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_163', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_164($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_164', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_165($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_165', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_166($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_166', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_167($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_167', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_168($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_168', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_169($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_169', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_170($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_170', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_171($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_171', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_172($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_172', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_173($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_173', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_174($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_174', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_175($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_175', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_176($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_176', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_177($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_177', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_178($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_178', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_179($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_179', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_180($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_180', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_181($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_181', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_182($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_182', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_183($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_183', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_184($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_184', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_185($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_185', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_186($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_186', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_187($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_187', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_188($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_188', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_189($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_189', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_190($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_190', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_191($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_191', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_192($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_192', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_193($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_193', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_194($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_194', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_195($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_195', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_196($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_196', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_197($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_197', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_198($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_198', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_199($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_199', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_200($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_200', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_201($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_201', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_202($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_202', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_203($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_203', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_204($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_204', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_205($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_205', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_206($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_206', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_207($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_207', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_208($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_208', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_209($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_209', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_210($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_210', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_211($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_211', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_212($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_212', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_213($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_213', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_214($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_214', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_215($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_215', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_216($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_216', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_217($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_217', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_218($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_218', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_219($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_219', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_220($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_220', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_221($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_221', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_222($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_222', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_223($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_223', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_224($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_224', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_225($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_225', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_226($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_226', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_227($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_227', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_228($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_228', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_229($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_229', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_230($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_230', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_231($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_231', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_232($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_232', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_233($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_233', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_234($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_234', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_235($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_235', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_236($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_236', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_237($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_237', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_238($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_238', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_239($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_239', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_240($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_240', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_241($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_241', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_242($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_242', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_243($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_243', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_244($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_244', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_245($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_245', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_246($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_246', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_247($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_247', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_248($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_248', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_249($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_249', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_250($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_250', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_251($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_251', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_252($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_252', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_253($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_253', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_254($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_254', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_255($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_255', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_256($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_256', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_257($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_257', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_258($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_258', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
    public function id_259($DataPPKS, $Identitas, $Tapels, $TapelSelecteds)
    {
        $title = 'Progres PKKS - Data Indikator ' . $DataPPKS->kode_dokumen;
        $breadcrumb = $DataPPKS->kategori . ' / Data Indikator ' . $DataPPKS->kode_dokumen;
        $datas = Detailguru::get();
        return view('role.program.pkks.data.id_259', compact('datas', 'title', 'breadcrumb', 'DataPPKS',));
    }
}
