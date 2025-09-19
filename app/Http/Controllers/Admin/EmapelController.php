<?php

namespace App\Http\Controllers\Admin;

use Pest\Support\Str;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Learning\Emengajar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class EmapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //
        $dataMapel = Cache::tags(['chace_dataMapel'])->remember('remember_dataMapel', now()->addMinutes(30), function () {
            return Emapel::Where('aktiv', 'Y')->orderBy('kategori', 'ASC')->get();
        });
        $kategoris = Cache::tags(['chace_kategoris'])->remember('remember_kategoris', now()->addHours(2), function () {
            return Emapel::select('kategori')->distinct()->get();
        });
        $kelompoks = Cache::tags(['chace_kelompoks'])->remember('remember_kelompoks', now()->addHours(2), function () {
            return Emapel::select('kelompok')->distinct()->get();
        });
        $title = 'Data E Mapel';
        $arr_ths = [
            'Nama Pelajaran',
            'Kategori',
            'Kelompok',
            'Jtm',
        ];
        $breadcrumb = 'E Mapel / Mata Pelajaran';
        $titleviewModal = "Lihat Data Mapel";
        $titleeditModal = "Edit Data Mapel";
        $titlecreateModal = "Create Data Mapel";
        return view('admin.emapel', compact(
            'dataMapel',
            'title',
            'arr_ths',
            'breadcrumb',
            // 'tapele',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'kategoris',
            'kelompoks'
        ));
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
    }

    /**
     * Display the specified resource.
     */
    public function show(emapel $emapel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(emapel $emapel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $datamapel = $request->all();
        $data = Emapel::findOrFail($id);
        // dd($datamapel);
        $data->mapel = $request->mapel;
        $data->singkatan = strtoupper($request->singkatan);
        $data->kategori = $request->kategori;
        $data->kelompok = $request->kelompok;
        $data->jtm = $request->jtm;
        $data->created_at = now();
        // $emengajar->update();

        $data->update();
        HapusCacheDenganTag('chace_dataMapel');
        Session::flash('success', 'Data Berhasil Diperbaharui');
        return Redirect::back();
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $varClassModel = Emapel::findOrFail($id);
        $varClassModel->delete();
        return redirect()->back()->with('Title', 'Data Berhasil Dihapus')->with('Success', 'Data Mata Pelajaran <b class="text-danger">' . $varClassModel->mapel . '</b> berhasil dihapus.');
        // return redirect()->route('emapel.index')->with('Success', 'Data berhasil dihapus.');
    }
    public function TambahMapel(Request $request, emapel $emapel)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $mapels = $request->all();
        $CekMapel = Emapel::where('tapel_id', $etapels->id)->where('mapel', $request->mapel)->count();
        // dd($CekMapel);
        if ($CekMapel > 0) {
        } else {
            emapel::insert([
                'tapel_id' => $etapels->id,
                'aktiv' => 'Y',
                'mapel' => $request->mapel,
                'singkatan' => strtoupper($request->singkatan),
                'kategori' => $request->kategori,
                'kelompok' => $request->kelompok,
                'jtm' => $request->jtm,
                'created_at' => now(),
                'updated_at' => now(),

            ]);
        }
        HapusCacheDenganTag('chace_dataMapel');
        return redirect()->route('emapel.index')->with('Title', 'Data Berhasil Ditambahkan')->with('Success', 'Data Mata Pelajaran ' . $request->mapel . ' berhasil Ditambahkan.');
    }
    public function mapelaktivkan(Request $request, emapel $emapel)
    {
        //Tambah mapel bulk in all kelas
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // dd();

        $jumlah_kelas = Ekelas::select('id', 'tingkat_id', 'kelas')->where('tapel_id', $etapels->id)->get();
        // dd($jumlah_kelas);

        $mapel_id = $request['mapel_id'];
        $kelas_id = $request->kelas_id;
        foreach ($jumlah_kelas as $kelas):
            foreach ($mapel_id as $mapel):
                $CekDataeMengajar = Emengajar::where('tapel_id', $etapels->id)->where('mapel_id', $mapel)->where('kelas_id', $kelas->id)->count();
                // dd($kelas->id);
                // dd($CekDataeMengajar);
                if ($CekDataeMengajar > 0) {
                } else {
                    Emengajar::insert(
                        [
                            'tapel_id' => $etapels->id,
                            'tingkat_id' => $kelas['tingkat_id'],
                            'detailguru_id' => Null,
                            'semester' => $etapels->semester,
                            'kelas_id' => $kelas['id'],
                            'mapel_id' => $mapel,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            // $jumlah_kelas = Ekelas::select('id')->where('tapel_id', $etapels->id)->get();
            // dd($hasil);

            endforeach;
        endforeach;
        // }
        HapusCacheDenganTag('chace_dataMapel');
        return redirect()->route('emapel.index');
    }

}
