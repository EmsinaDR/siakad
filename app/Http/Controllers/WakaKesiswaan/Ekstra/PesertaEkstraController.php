<?php

namespace App\Http\Controllers\WakaKesiswaan\Ekstra;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKesiswaan\Ekstra\Ekstra;
use App\Models\WakaKesiswaan\Ekstra\PesertaEkstra;
use App\Models\WakaKesiswaan\Ekstra\RiwayatEkstra;

class PesertaEkstraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Pembina Ekstra';
        $arr_ths = [
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Ekstra'
        ];
        $arr_thsX = [
            'Nama Ekstra',
            'Pemibna',
            'Pelatiha',
            'Jadwal',
            'Jml Anggota',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Pembina Ekstra / Data Peserta Ekstra';
        $titleviewModal = 'Lihat Data Pembina Ekstra';
        $titleeditModal = 'Edit Data Pembina Ekstra';
        $titlecreateModal = 'Create Data Pembina Ekstra';
        $my_ekstra = RiwayatEkstra::where('tapel_id', $etapels->id)->where('detailguru_id', Auth::user()->id)->pluck('id')->toArray();
        // $my_ekstra = Ekstra::get();
        // dd($my_ekstra);
        $datas = \App\Models\WakaKesiswaan\Ekstra\PesertaEkstra::with('EkstraOne', 'Siswa')->get();
        $jumlahSiswa = Detailsiswa::orderBy('kelas_id', 'ASC')->orderBy('nama_siswa', 'ASC')->get();
        // dd($datas);

        // Siswa TIdak Ekstra
        $dataInEkstra = PesertaEkstra::pluck('detailsiswa_id')->toArray();
        $siswaTidakEkstra = Detailsiswa::whereNotIn('id', $dataInEkstra)->whereNotNull('kelas_id')
            ->orderby('kelas_id', 'ASC')
            ->get();

        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        $datasEkstra = RiwayatEkstra::where('tapel_id', $etapels->id)->get();
        return view('role.pembina.ekstra.peserta-ekstra', compact(
            'datas',
            'title',
            'arr_ths',
            'arr_thsX',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'jumlahSiswa',
            'siswaTidakEkstra',
            'datasEkstra',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    // 'detailguru_id' => 'nullable|integer',
    // 'peserta_id' => 'nullable|integer',
    // 'tapel_id' => 'nullable|integer',
    // 'ekstra_id' => 'nullable|integer',
    // 'nilai' => 'nullable|integer|min:0|max:100',
    // 'jabatan' => 'nullable|integer',
    // 'predikat' => 'nullable|string|max:5',
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
        $detailguru_id = Auth::user()->detailguru_id;
        $request->merge([
            'tapel_id' => $etapels->id,
            'detailguru_id' => $detailguru_id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'detailguru_id' => 'nullable|integer',
            'detailsiswa_id' => 'required|array', // Mengubah menjadi array
            'detailsiswa_id.*' => 'integer', // Setiap elemen harus berupa integer dan ada di tabel siswa
            'tapel_id' => 'nullable|integer',
            'ekstra_id' => 'nullable|integer',
            'nilai' => 'nullable|integer|min:0|max:100',
            'jabatan' => 'nullable|integer',
            'tingkat_id' => 'nullable|integer',
            'predikat' => 'nullable|string|max:5',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan data menggunakan looping untuk setiap siswa dalam array
        foreach ($request->detailsiswa_id as $siswa_id) {
            $tingkat = Detailsiswa::with('Detailsiswatokelas')->find($siswa_id);
            PesertaEkstra::create([
                'detailguru_id' => $request->detailguru_id,
                'detailsiswa_id' => $siswa_id, // Menyimpan ID siswa ke dalam peserta_ekstras
                'tapel_id' => $request->tapel_id,
                'ekstra_id' => $request->ekstra_id,
                'nilai' => $request->nilai,
                'jabatan' => $request->jabatan,
                'tingkat_id' => $tingkat->Detailsiswatokelas->tingkat_id,
                'kelas_id' => $tingkat->kelas_id,
                'predikat' => $request->predikat,
            ]);
        }
        Session::flash('success', 'Data Berhasil Ditambahkan');
        return Redirect::back();
    }

    public function update($id, Request $request, PesertaEkstra $pesertaEkstra)
    {
        //

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'detailguru_id' => 'nullable|integer',
            'peserta_id' => 'nullable|integer',
            'tapel_id' => 'nullable|integer',
            'ekstra_id' => 'nullable|integer',
            'nilai' => 'nullable|integer|min:0|max:100',
            'jabatan' => 'nullable|integer',
            'tingkat_id' => 'nullable|integer',
            'predikat' => 'nullable|string|max:5',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            // Menyimpan data menggunakan mass assignment
            // Create : Buat
            // Update : Memperbaharui
            // Menyimpan data menggunakan mass assignment
            $varmodel = PesertaEkstra::find($id); // Pastikan $id didefinisikan atau diterima dari request
            if ($varmodel) {
                $varmodel->update($validator->validated());
                return Redirect::back()->with('Title', 'Berhasil')->with('success', 'Data Berhasil di Update');
            } else {
                return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Data tidak ditemukan');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //PesertaEkstra
        // dd(id);
        // dd(request->all());
        $VarPesertaEkstra = PesertaEkstra::findOrFail($id);
        $VarPesertaEkstra->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
    public function show($id, Request $request)
    {
        //dd($request->all());
        $title = 'Pembina Ekstra';
        $arr_ths = [
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Ekstra'
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Pembina Ekstra / Data Peserta Ekstra';
        $titleviewModal = 'Lihat Data Pembina Ekstra';
        $titleeditModal = 'Edit Data Pembina Ekstra';
        $titlecreateModal = 'Create Data Pembina Ekstra';
        $datas = PesertaEkstra::with('Ekstra', 'Siswa')
            ->where('ekstra_id', $id)
            ->join('detailsiswas', 'detailsiswas.id', '=', 'ekstra_peserta.detailsiswa_id') // Join ke tabel siswa
            ->orderBy('detailsiswas.kelas_id', 'ASC') // Order berdasarkan kelas_id di tabel siswa
            ->select('ekstra_peserta.*') // Pastikan hanya mengambil data peserta_ekstras
            ->get();

            //$etapels->id
            //where('tapel_id', $etapels->id)->
        $dataEkstra = \App\Models\WakaKesiswaan\Ekstra\RiwayatEkstra::with('Ekstra')->where('tapel_id', $etapels->id)->where('id', request()->segment(3))->first();
        // dd($dataEkstra);
        // Jika data tidak ditemukan
        if (!$dataEkstra) {
            Session::flash('error', 'Data tidak ditemukan');
            return Redirect::back();
        }
        // dd($datas);
        if (is_null($datas)) {
            Session::flash('success', 'Data tidak ditemukan');
            return Redirect::back();
        }
        // dd($datas->count());
        // $datasiswa
        // dd($datas);
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'

        // Data Siswa Tidak Ikut Ekstra
        $dataInEkstra = PesertaEkstra::pluck('detailsiswa_id')->toArray();
        $siswaTidakEkstra = Detailsiswa::whereNotIn('id', $dataInEkstra)->whereNotNull('kelas_id')
            ->orderby('kelas_id', 'ASC')
            ->get();
        // dd($siswasx);
        return view('role.pembina.ekstra.peserta-ekstra-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'dataEkstra',
            'siswaTidakEkstra',
        ));
    }
    public function TambahPeserta()
    {
        //dd($request->all());
        // body_method
    }
}
