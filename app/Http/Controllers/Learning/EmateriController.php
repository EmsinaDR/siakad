<?php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;

use Exception;
use App\Models\Admin\Etapel;
use App\Models\Learning\Emateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EmateriController extends Controller
{
    public function index(Request $request)
    {
        $mapel_id = $request->mapel_id;
        $data = 'Update Materi';
        $title = 'E Materi';
        $arr_ths = [
            'Pokok',
            'Indikator'
        ];
        $mapel_id = $request->mapel_id;
        $kelas_id = $request->kelas_id;
        $tingkat_id = $request->tingkat_id;
        $semester = $request->semester;
        $breadcrumb = 'Data Pembelajaran / Materi Pembelajaran';
        $titleviewModal = 'Detail Data E Materi';
        $titleeditModal = 'Data Materi Pelajaran ';
        $titlecreateModal = 'Create Data E Materi';
        $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
        // dd($routeName);
        $datas = Emateri::with('EmaeritoMapel')->where('mapel_id', $request->mapel_id)->where('semester', $request->semester)->where('tingkat_id', $request->tingkat_id)->orderBy('materi')->get();
        return view('role.guru.e_materi', compact(
            'title',
            'arr_ths',
            'mapel_id',
            'breadcrumb',
            'titleviewModal',
            'datas',
            'titleeditModal',
            'titlecreateModal',
            'tingkat_id',
            'kelas_id',
            'semester'
        ));
    }

    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'kkm_kompleksitas' => 'required|numeric|max:100',
                'kkm_dayadukung' => 'required|numeric|max:100',
                'kkm_dayaserap' => 'required|numeric|max:100',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $etapels = Etapel::where('aktiv', 'Y')->first();
            $data = $request->all();
            $data = new Emateri();
            $data->tapel_id = $etapels->id;
            $data->default = 'N';
            $data->aktiv = 'Y';

            $data->mapel_id = $request->mapel_id;
            $data->tingkat_id = $request->tingkat_id;
            $data->materi = $request->materi;
            $data->sub_materi = $request->sub_materi;
            $data->indikator = $request->indikator;
            $data->kkm_kompleksitas = $request->kkm_kompleksitas;
            $data->kkm_dayadukung = $request->kkm_dayadukung;
            $data->kkm_dayaserap = $request->kkm_dayaserap;
            $data->semester = $request->semester;
            $data->created_at = now();
            $data->updated_at = now();
            $data->save();
            return Redirect::back()->with('Title', 'Proses penambahan materi')->with('Success', 'Proses berhasil');
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }

    // public function show(Request $request, Emateri $emateri)
    // {
    //     //
    //     $datas = Emateri::findOrFail($request->id);
    //     $title = 'Edit Data Materi';
    //     return view('emateri.show', compact('datas'));
    // }
    // public function edit(Request $request, Emateri $emateri)
    // {
    //     //Form Edit
    //     $datas = Emateri::findOrFail($request->id);
    //     $title = 'Edit Data Materi';
    //     return view('emateri.edit', compact('datas', 'title'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $mapel_id, $semester, $tingkat_id, $kelas_id, $data_materi)
    {
        try {
            // Proses Update dari Edit
            $validator = Validator::make($request->all(), [
                'kkm_kompleksitas' => 'required|numeric|max:100',
                'kkm_dayadukung' => 'required|numeric|max:100',
                'kkm_dayaserap' => 'required|numeric|max:100',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            // dd($emateri);
            $emateri = $request->except(['_token', '_method']);
            $emateri = Emateri::findOrFail($data_materi);
            $emateri->materi = $request->materi;
            $emateri->sub_materi = $request->sub_materi;
            $emateri->indikator = $request->indikator;
            $emateri->kkm_kompleksitas = $request->kkm_kompleksitas;
            $emateri->kkm_dayadukung = $request->kkm_dayadukung;
            $emateri->kkm_dayaserap = $request->kkm_dayaserap;
            $emateri->semester = $request->semester;
            $emateri->updated_at = now();
            // dd($emateri);
            // Emateri::where('id', $request->id)->update($emateri);
            $emateri->update();
            // dd($request->all());
            return Redirect::back()->with('Title', 'Data berhasil.')->with('Success', 'Data berhasil materi perbaharui.');
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }
    public function destroy($mapel_id, $semester, $tingkat_id, $kelas_id, $data_materi)
    {
        try {
            //
            // dd($data_materi);
            $varEmateri = Emateri::findOrFail($data_materi);
            $varEmateri->delete();

            return Redirect::back()->with('Title', 'Data berhasil.')->with('Success', 'Data berhasil materi dihapus.');
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }
    //APi Materi Ajax
    public function ematerimateritosub(Request $request)
    {
        $mapel_id = $request->mapel_id;
        $materi = $request->materi;
        $etapel = etapel::where('aktiv', 'Y')->first();
        $materi = Emateri::select('sub_materi')->where('mapel_id', $mapel_id)->where('semester', $etapel->semester)->where('materi', $materi)->select('sub_materi')->distinct()->get();

        // dd($materi_materi);
        return $materi;
    }
    public function ematerisubtoindikator(Request $request)
    {
        // dd($request->sub_materi);
        $materi = $request->materi;
        $sub_materi = $request->sub_materi;
        $etapel = etapel::where('aktiv', 'Y')->first();
        // $materi = Emateri::where('materi', $materi)->get();
        $materi = Emateri::where('materi', $materi)->where('semester', $etapel->semester)->where('sub_materi', $sub_materi)->get();
        // dd($materi);
        return $materi;
    }
}
