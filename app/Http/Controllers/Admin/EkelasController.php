<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Cache;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class EkelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $arr_ths = [
            'Tahun Pelajaran',
            'Semester',
            'Kelas',
            'Jumlah Siswa',
            'Wali Kelas',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $DataKelas = Ekelas::with('kelastoDetailguru', 'kelastotapel')->where('aktiv', 'Y')->where('tapel_id', $etapels->id)->OrderBy('tingkat_id')->get();;

        HapusCacheDenganTag('cache_DataKelas');
        $DataKelas = Cache::tags(['cache_DataKelas'])->remember(
            'remember_DataKelas',
            now()->addMinute(10),
            function () use ($etapels) {
                return Ekelas::with('kelastoDetailguru', 'kelastotapel')
                    ->withCount([
                        'siswas',
                        'siswas as siswas_laki_count' => function ($query) {
                            $query->where('jenis_kelamin', 'Laki-laki');
                        },
                        'siswas as siswas_perempuan_count' => function ($query) {
                            $query->where('jenis_kelamin', 'Perempuan');
                        },
                    ])
                    ->where('aktiv', 'Y')
                    ->where('tapel_id', $etapels->id)
                    ->orderBy('tingkat_id')
                    ->get();
            }
        );
        // dd($DataKelas);

        // $DataKelas = Ekelas::with('kelastoDetailguru', 'kelastotapel')
        //     ->withCount([
        //         'siswas', // total semua
        //         'siswas as siswas_laki_count' => function ($query) {
        //             $query->where('jenis_kelamin', 'Laki-laki');
        //         },
        //         'siswas as siswas_perempuan_count' => function ($query) {
        //             $query->where('jenis_kelamin', 'Perempuan');
        //         },
        //     ])
        //     // ->where('aktiv', 'Y')
        //     ->where('tapel_id', $etapels->id)
        //     ->orderBy('tingkat_id')
        //     ->get();
        // $users = Detailguru::get();
        // $dataid = Ekelas::with('kelastotapel')->select('id')->where('aktiv', 'Y')->orderBy('kelas')->get();
        $titleviewModal = 'Lihat Data Kelas';
        $titleeditModal = 'Edit Data Kelas';
        $titlecreateModal = 'Create Data Kelas';
        $title = 'E Kelas';
        $breadcrumb = 'Data E Kelas / Data Kelas';
        return view('admin.Ekelas', compact(
            'title',
            'DataKelas',
            'breadcrumb',
            'arr_ths',
            // 'users',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
    }
    public function createbulk(Request $request)
    {
        //
        // Proses Pembuatan kelas secara masal dari menu Ekelas
        $tapel = Etapel::where('aktiv', 'Y')->first();
        // Pengambilan Data Kelas Masal
        $cekKelas = Ekelas::where('aktiv', 'Y')->where('tapel_id', $tapel->id)->pluck('kelas');
        $activecrud = collect($cekKelas)->contains($request->kelas_created[0]);
        foreach ($request->kelas_created as $kelas) {
            $activecrud = collect($cekKelas)->contains($kelas);
            if ($activecrud === true) {
            } else {
                Ekelas::insert([
                    'tapel_id' => $tapel->id,
                    'tingkat_id' => $request->tingkat_id,
                    'semester' => $tapel->semester,
                    'aktiv' => $tapel->aktiv,
                    'kelas' => $kelas,
                    'created_at' => now(),
                    'updated_at' => now(),

                ]);
            }
        }
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data telah seleseai diproses');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Proses melewati pengecekan keterasediaan kelas pada tahun pelajaran saat ini
        // dd($request->all());
        $tapel = Etapel::where('aktiv', 'Y')->first();
        // Pengambilan Data Kelas Masal
        $cekKelas = Ekelas::where('aktiv', 'Y')->where('tapel_id', $tapel->id)->pluck('kelas');
        $activecrud = collect($cekKelas)->contains($request->kelas_created[0]);
        foreach ($request->kelas_created as $kelas) {
            $activecrud = collect($cekKelas)->contains($kelas);
            if (!$activecrud) {
                Ekelas::insert([
                    'tapel_id' => $tapel->id,
                    'tingkat_id' => $request->tingkat_id,
                    'semester' => $tapel->semester,
                    'aktiv' => $tapel->aktiv,
                    'kelas' => $kelas,
                    'created_at' => now(),
                    'updated_at' => now(),

                ]);
            }
        }
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data telah seleseai diproses');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
        dd($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ekelas $Ekelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request, Ekelas $Ekelas)
    {
        //
        // dd($id);
        // dd($request->all());
        try {
            $Ekelas = $request->only('detailguru_id');
            $Ekelas = Ekelas::findorFail($id);
            $Ekelas->detailguru_id = $request->detailguru_id;
            $Ekelas->update();
            // dd($request->all());
            return redirect()->back()->with('Title', 'Data berhasil diperbaharui')->with('Success', 'Data  datahaps Berhasil diupdate');
        } catch (Exception $e) {
            // Tindakan jika terjadi exception
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }

    public function updatewalkes(Request $request, Ekelas $Ekelas)
    {
        //
        $Ekelas = Ekelas::where('id', $request->id)->first();
        $Ekelas->detailguru_id = $request->detailguru_id;
        $Ekelas->update();
        // $Ekelas->update();
        return with('success', 'Data kelas berhasil ditambahkan.');
        // return response()->json(['status' => 'success', 'message' => 'Data updated successfully guru kelas' + $request->data]);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        //Ekelas
        // dd(id);
        // dd(request->all());
        $VarEkelas = Ekelas::findOrFail($id);
        $VarEkelas->delete();

        return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
    }
    public function PindahKelas(Request $request)
    {
        //dd($request->all());
        $Ekelas = Ekelas::find($request->kelas_id);
        $request->merge([
            'tingkat_id' => $Ekelas->tingkat_id,
        ]);
        $SiswaPindahKelas = Detailsiswa::whereIn('id', $request->detailsiswa_id)->get();
        $request->validate([
            'detailsiswa_id' => 'array',
            'kelas_id' => 'integer',
            'tingkat_id' => 'integer',
        ]);
        foreach ($SiswaPindahKelas as $siswa) {
            $siswa->update([
                'kelas_id' => $request->kelas_id,
                'tingkat_id' => $$Ekelas->tingkat_id,
            ]);
        }


        HapusCacheDenganTag('siswas_global');


        // dd($request->all());
        Session::flash('success', 'Data berhasil disimpan');
        return Redirect::back();
    }
}
