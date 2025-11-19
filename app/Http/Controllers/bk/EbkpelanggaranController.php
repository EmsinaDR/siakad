<?php

namespace App\Http\Controllers\bk;

use Exception;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\bk\Ebkkreditpoint;
use App\Models\bk\Ebkpelanggaran;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Redirect;

class EbkpelanggaranController extends Controller
{
    //role.bk.e_pelanggara
    //Ebkpelanggaran
    public function index(Request $request)
    {
        $title = 'BK Pelanggaran';
        $arr_ths = [
            'Hari / Tanggal',
            'Nama',
            'Pelanggaran',
            'Point',
            'Keterangan'
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();

        $DataPelanggaran = Cache::tags(['cache_DataPelanggaran'])->remember('remember_DataPelanggaran', now()->addHours(2), function () use ($etapels) {
            return $DataPelanggaran = Ebkpelanggaran::with(['siswa' => function ($query) {
                $query->whereNotNull('kelas_id');
            }])
                ->where('tapel_id', $etapels->id)
                ->get();
        });
        $dataTotals = Cache::tags(['cache_dataTotals'])->remember('remember_dataTotals', now()->addHours(2), function () use ($etapels) {
            return $dataTotals = Ebkpelanggaran::select('pelaku_id', DB::raw('SUM(point) as total_point'))
                ->with('siswa')
                ->where('tapel_id', $etapels->id)
                ->whereHas('siswa', function ($query) {
                    $query->whereNotNull('kelas_id');
                })
                ->groupBy('pelaku_id')
                ->get();;
        });

        $ebkkreditpoints = Cache::tags(['cache_ebkkreditpoints'])->remember('remember_ebkkreditpoints', now()->addHours(2), function () {
            return Ebkkreditpoint::get();
        });

        $breadcrumb = 'Bimbingan Konseling / BK Pelanggaran';
        $titleviewModal = 'Lihat BK Pelanggaran';
        $titleeditModal = 'Edit BK Pelanggaran';
        $titlecreateModal = 'Buat BK Pelanggaran';
        return view('role.bk.e_pelanggaran', compact(
            'title',
            'arr_ths',
            'DataPelanggaran',
            'dataTotals',
            'ebkkreditpoints',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
    }


    public function store(Request $request)
    {
        try {
            // dd($request->all());
            //Proses Modal Create
            //Form Modal Create ada di index dengan Modal
            foreach ($request->kreditpoint_id as $kreditpoint_id):
                $point = Ebkkreditpoint::findOrfail($kreditpoint_id);
                $pointtoala[] = $point->point;
            endforeach;
            $request['point'] = collect($pointtoala)->sum();
            $etapels = Etapel::where('aktiv', 'Y')->first();
            $data = $request->except(['_token', '_method']);
            foreach ($request->pelaku_id as $pelaku):
                $data = new Ebkpelanggaran();
                //$data->indikator_id = implode(',', $request->indikator_id);

                $data->detailguru_id = Auth::user()->id;
                $data->tapel_id = $etapels->id;
                $data->korban_id = $request->korban_id;
                $data->pelaku_id = $pelaku;
                $data->saksi_id = json_encode($request->saksi_id);
                // $data->kategori = $request->kategori;
                $data->kreditpoint_id = json_encode($request->kreditpoint_id);
                $data->point = $request->point;
                $data->kronologi = $request->kronologi;
                $data->status_penanganan = $request->status_penanganan;
                $data->penanganan = $request->penanganan;
                $data->created_at = now();
                $data->updated_at =  now();
                $data->save();

                HapusCacheDenganTag('cache_ebkkreditpoints');
                HapusCacheDenganTag('cache_DataPelanggaran');
            endforeach;
            // dd($request->all());
            return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data disimpan dalam database');
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }
    public function update($id, Request $request)
    {
        // try {
        //Proses Modal Update
        //Form Modal Update ada di index dengan Modal
        // dd($request->all());

        $data = $request->except(['_token', '_method']);
        $data = Ebkpelanggaran::findOrFail($id);
        foreach ($request->kreditpoint_id as $kreditpoint_id):
            $point = Ebkkreditpoint::findOrfail($kreditpoint_id);
            $pointtoala[] = $point->point;
        endforeach;
        $request['point'] = collect($pointtoala)->sum();
        $data->korban_id = $request->korban_id;
        $data->pelaku_id = $request->pelaku_id;
        $data->saksi_id = $request->saksi_id;
        $data->point = $request->point;
        $data->kategori = $request->kategori;
        $data->kreditpoint_id = json_encode($request->kreditpoint_id);
        $data->kronologi = $request->kronologi;
        $data->status_penanganan = $request->status_penanganan;
        $data->penanganan = $request->penanganan;
        $data->updated_at =  now();
        $data->update();
        HapusCacheDenganTag('cache_ebkkreditpoints');
        HapusCacheDenganTag('cache_DataPelanggaran');
        return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  berhasil diperbaharui');
        // } catch (Exception $e) {
        //     return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        // }
    }


    public function destroy($id)
    {
        try {
            $data = Ebkpelanggaran::findOrFail($id);
            $data->delete();
            HapusCacheDenganTag('cache_ebkkreditpoints');
            HapusCacheDenganTag('cache_DataPelanggaran');
            return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }
    //Upload
    public function uploadkreditpoint(Request $request)
    {
        try {
            // dd($request->all());
            $etapels = Etapel::where('aktiv', 'Y')->first();
            $file = $request->file('file'); //file : name pada form upload
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('temp/'),  $fileName); //Memindahkan file ke direktori sementara untuk dibaca datanya
            $spreadsheet = IOFactory::load('' . public_path('temp/') . $file->getClientOriginalName() . '');
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            // Proses data dari excel di baca dan dimasukkan kedalam database
            foreach ($data as $index => $row) {
                if ($index == 0) continue; // Lewati baris header (judul kolom)
                // Sebelum masuk ingat query constraits yang perlu diperhatikan
                $kredit_point = new Ebkkreditpoint();
                //i : Untuk mempermudah proses kolom selanjutnya
                $i = 1;
                $kredit_point->tapel_id = $etapels->id; //Row 1 Menyatakan kolom 1 dalam excel
                $kredit_point->kategori = $row[$i++]; //Row 1 Menyatakan kolom 1 dalam excel
                $kredit_point->pelanggaran = $row[$i++]; //Row 1 Menyatakan kolom 1 dalam excel
                $kredit_point->point = $row[$i++]; //Row 1 Menyatakan kolom 1 dalam excel
                $kredit_point->created_at = now(); //Row 1 Menyatakan kolom 1 dalam excel
                $kredit_point->updated_at = now(); //Row 1 Menyatakan kolom 1 dalam excel
                $kredit_point->aktiv = $row[$i++]; //Row 1 Menyatakan kolom 1 dalam excel
                $kredit_point->keterangan = $row[$i++]; //Row 1 Menyatakan kolom 1 dalam excel

                $kredit_point->save();
                // dd($request->all());
                HapusCacheDenganTag('cache_DataPelanggaran');
                HapusCacheDenganTag('cache_dataTotals');
            }
        } catch (Exception $e) {
            // Tindakan jika terjadi exception
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data telah disimpan');
    }
}
