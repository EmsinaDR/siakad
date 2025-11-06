<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;

use App\Models\Admin\Etapel;
use App\Models\Ekeuangan;
use App\Models\Detailguru;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Container\Attributes\Auth;

class EkeuanganController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(ekeuangan $ekeuangan)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(ekeuangan $ekeuangan)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, ekeuangan $ekeuangan)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(ekeuangan $ekeuangan)
    // {
    //     //
    // }

    // public function index(Ekeuangan $Ekeuangan)
    // {
    //     $title = 'Title_Post';
    //     $arr_ths = [
    //         'Item',
    //         'Nominal',
    //         'Catatan',
    //         'Pendidikan',
    //         'Jenis'
    //     ];
    //     $datas = Ekeuangan::with('xxxxxxxxxxxxxxxxx')->where('xxxxxxxxxxxxx', 'xxxxxxxxxxx')->get(); //Relasi di sisipi dengan where
    //     $breadcrumb = 'Data / Title_Post';
    //     $titleviewModal = 'Lihat Title_Post';
    //     $titleeditModal = 'Edit Title_Post';
    //     $titlecreateModal = 'Buat Title_Post';
    //     return view('blade', compact('title', 'arr_ths', 'datas', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    // }
    // public function create(Request $request)
    // {
    //     //Proses Create
    //     //Form Create ada di index dengan Modal
    //     // $data = $request->all();
    //     $etapels = Etapel::where('aktiv', 'Y')->first();
    //     // dd(request->all());
    //     $data = $request->except(['_token', '_method']);

    //     $data = new Ekeuangan();
    //     //$data->indikator_id = implode(',', $request->indikator_id);
    //     $data->kelas_id = $request->kelas_id;
    //     $data->created_at = now();
    //     $data->updated_at = now();

    //     $data->save();
    //     return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data disimpan dalam database');
    // }
    // public function update($id, Request $request)
    // {
    //     //Proses Update
    //     //Form Update ada di index dengan Modal
    //     //dd($request->all());
    //     $data = $request->except(['_token', '_method']);
    //     $data = Ekeuangan::findOrFail($id);
    //     $data->kelas_id = $request->kelas_id;
    //     $data->updated_at = now();
    //     $data->update();
    //     return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  berhasil diperbaharui');
    // }
    // public function destroy($id)
    // {
    //     //Proses Delete
    //     //Form Delete ada di index dengan Modal
    //     //Detailguru
    //     // dd(id);
    //     // dd(request->all());
    //     $data = Ekeuangan::findOrFail($id);
    //     $data->delete();
    //     return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
    // }
    public function index(Ekeuangan $ekeuangan)
    {
        $title = 'Data Keunagan';
        $arr_ths = [
            'Foto',
            'Jenis'
        ];

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = Ekeuangan::with('eloquent')->where('posisi', 'Guru')->get(); //Relasi di sisipi dengan where
        $breadcrumb = 'Data / Data Keunagan';
        $titleviewModal = 'Lihat Data Keunagan';
        $titleeditModal = 'Edit Data Keunagan';
        $titlecreateModal = 'Buat Data Keunagan';
        return view('blade', compact('title', 'arr_ths', 'datas', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }


    public function store(Request $request)
    {
        //Proses Modal Create
        //Form Modal Create ada di index dengan Modal

        $etapels = Etapel::where('aktiv', 'Y')->first();
        // dd(request->all());
        $data = $request->except(['_token', '_method']);
        $data = new Ekeuangan();
        //$data->indikator_id = implode(',', $request->indikator_id);
        $data->kelas_id = $request->kelas_id;
        $data->created_at = now();
        $data->update_at =  now();

        $data->save();
        return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data disimpan dalam database');
    }
    public function update($id, Request $request)
    {
        //Proses Modal Update
        //Form Modal Update ada di index dengan Modal
        //dd($request->all());
        $data = $request->except(['_token', '_method']);
        $data = Ekeuangan::findOrFail($id);
        $data->kelas_id = $request->kelas_id;
        $data->update_at =  now();
        $data->update();
        return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  berhasil diperbaharui');
    }


    public function destroy($id)
    {
        //Proses Modal Delete
        //Form Modal Delete ada di index
        //Detailguru
        // dd(id);
        // dd(request->all());
        $data = Ekeuangan::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
    }
}
