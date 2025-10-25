<?php

namespace App\Http\Controllers\Learning;

use Exception;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Learning\Emengajar;
use App\Http\Controllers\Controller;
use App\Models\Learning\EnilaiUlangan;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Redirect;

class EnilaiUlanganController extends Controller
{
    //
    public function index(Request $request)
    {
        $title = 'E Nilai Tugas';
        $arr_ths = [
            'Nama',
            'NIS'
        ];

        // // dd($request->kelas_id);
        // $kelas = $request->kelas_id;
        // $mapel_id = $request->mapel_id;
        // $tingkat_id = $request->tingkat_id;
        // $semester = $request->semester;
        // // dd($request->kelas_id);
        // // dd($tingkat_id);
        // $etapels = Etapel::where('aktiv', 'Y')->first();
        // $datas = EnilaiTugas::with('EnilaiTugastoDetailSiswas')
        // ->where('kelas_id', $request->kelas_id)
        //     ->where('mapel_id', $request->mapel_id)
        //     ->where('tingkat_id', $request->tingkat_id)
        //     ->get(); //Relasi di sisipi dengan where
        // // dd($datas);
        // $breadcrumb = 'Guru / E Nilai Tugas';
        // $titleviewModal = 'Lihat E Nilai Tugas';
        // $titleeditModal = 'Edit E Nilai Tugas';
        // $titlecreateModal = 'Buat E Nilai Tugas';


        $title = 'E Nilai Ulangan';
        $arr_ths = [
            'Nama',
            'NIS',
        ];
        // dd('aaa');
        // dd($request->kelas_id);
        $kelas = $request->kelas_id;
        $mapel_id = $request->mapel_id;
        $tingkat_id = $request->tingkat_id;
        $semester = $request->semester;
        // dd($request->kelas_id);
        // dd($tingkat_id);
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // $datas = EnilaiUlangan::with('EnilaiUlangantoDetailSiswas')->where('kelas_id', $request->kelas_id)->where('mapel_id', $request->mapel_id)->where('kelas_id', $request->kelas_id)->where('tingkat_id', $request->tingkat_id)->get(); //Relasi di sisipi dengan where
        $datas = EnilaiUlangan::with('EnilaiUlangantoDetailSiswas')
            ->where('kelas_id', $request->kelas_id)
            ->where('mapel_id', $request->mapel_id)
            ->where('tingkat_id', $request->tingkat_id)
            ->get(); //Relasi di sisipi dengan where
       
        $breadcrumb = 'Guru / E Nilai Ulangan';
        $titleviewModal = 'Lihat E Nilai Ulangan';
        $titleeditModal = 'Edit E Nilai Ulangan';
        $titlecreateModal = 'Buat E Nilai Ulangan';
        return view('role.guru.e_nilai_ulangan', compact('title', 'arr_ths', 'datas', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        // return 'oke';
    }


    public function store(Request $request)
    {
        //Proses Modal Create
        //Form Modal Create ada di index dengan Modal

        $etapels = Etapel::where('aktiv', 'Y')->first();
        // dd($request->all());
        $data = $request->except(['_token', '_method']);
        $data = new EnilaiUlangan();
        //$data->indikator_id = implode(',', $request->indikator_id);
        $data->kelas_id = $request->kelas_id;
        $data->created_at = now();
        $data->updated_at =  now();

        $data->save();
        return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data disimpan dalam database');
    }
    public function update($id, Request $request)
    {
        //Proses Modal Update
        //Form Modal Update ada di index dengan Modal
        $data = $request->except(['_token', '_method']);
        // dd($request->nilai_tuga);
        // dd($request->nilai_ulangan);
        // dd($request->all());

        $data = EnilaiUlangan::findOrFail($request->nilai_ulangan);
        $data->ulangana = $request->ulangana;
        $data->ulanganb = $request->ulanganb;
        $data->ulanganc = $request->ulanganc;
        $data->ulangand = $request->ulangand;
        $data->ulangane = $request->ulangane;
        $data->updated_at =  now();
        $data->update();
        // dd($request->all());
        return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  berhasil diperbaharui');
    }



    public function destroy($id, Request $request)
    {
        //Proses Modal Delete
        //Form Modal Delete ada di index
        // dd($request->nilai_tuga);
        // dd($request->all());
        $data = EnilaiUlangan::findOrFail($request->nilai_tuga);
        $data->delete();

        return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
    }
    public function upadaAllIn($id, Request $request)
    {
        // dd($request->all());
        // dd($request->id_data[1]);
        $siswas = Detailsiswa::select('id')->where('kelas_id', $request->kelas_id)->get();
        //Mengambil data tahun Pelajaran
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //Mengambil data mengajar
        $gurumengajar_id = Emengajar::select('detailguru_id')->where('kelas_id', $request->kelas_id)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->where('mapel_id', $request->mapel_id)->first();
        for ($i = 0; $i < count($request->id_data); $i++):
            $data = EnilaiUlangan::findOrFail($request->id_data[$i]);
            $data->ulangana = $request->ulangana[$i];
            $data->ulanganb = $request->ulanganb[$i];
            $data->ulanganc = $request->ulanganc[$i];
            $data->ulangand = $request->ulangand[$i];
            $data->ulangane = $request->ulangane[$i];

            $data->updated_at = now();
            $data->update();
        endfor;
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data siswa telah di simpan');
        dd($request->all());
    }
    public function DS_generatsiswa($id, Request $request)
    {
        //Proses pengambilan data siswa agar masuk ke dalam e nilai tugas
        try {
            // dd($request->all());
            $etapels = Etapel::where('aktiv', 'Y')->first();
            $cekKelas = Ekelas::select('kelas')->where('kelas', $request->kelas_id)->get()->count();
            // dd($cekKelas);
            //Mengambil Data Siswa Sesuai Kelas
            $siswas = Detailsiswa::select('id')->where('kelas_id', $request->kelas_id)->get();
            //Mengambil data mengajar
            $gurumengajar_id = Emengajar::select('detailguru_id')->where('kelas_id', $request->kelas_id)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->where('mapel_id', $request->mapel_id)->first();
            foreach ($siswas as $siswa):
                // //Lanjutkan proses untuk e nilai tugas
                $data = new EnilaiUlangan();
                $data->tapel_id = $etapels->id;
                $data->semester = $etapels->semester;
                $data->detailguru_id = $gurumengajar_id->detailguru_id;
                $data->kelas_id = $request->kelas_id;
                $data->mapel_id = $request->mapel_id;
                $data->tingkat_id = $request->tingkat_id;
                $data->detailsiswa_id = $siswa->id;
                $data->created_at = now();
                $data->updated_at =  now();
                $ceksiswa = EnilaiUlangan::where('kelas_id', $request->kelas_id)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->where('mapel_id', $request->mapel_id)->where('detailsiswa_id', $siswa->id)->count();
                // dd($ceksiswa);
                if ($ceksiswa === 0):
                    $data->save();
                endif;
            endforeach;
            //Lanjutkan proses untuk e nilai ulangan
            //Lanjutkan proses untuk e nilai pts dan pas
            return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data siswa telah di import');
            dd($siswas);
        } catch (Exception $e) {
            // Tindakan jika terjadi exception
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }
}
