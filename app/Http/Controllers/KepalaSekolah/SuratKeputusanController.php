<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Admin\Identitas;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use App\Models\Program\Rapat\DataRapat;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Laboratorium\Elaboratorium;
use App\Models\WakaKesiswaan\Ekstra\Ekstra;
use App\Models\KepalaSekolah\SuratKeputusan;
use App\Models\Program\Template\TemplateDokumen;

class SuratKeputusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //
        //Title to Controller
        $title = 'Surat Keputusan';
        $arr_ths = [
            'Tanggal SK',
            'Nomor SK',
            'Nama Guru',
            'Nama SK',
            'Perihal',
        ];
        $breadcrumb = 'Kepala Sekolah / Surat Keputusan';
        $titleviewModal = 'Lihat Data Surat Keputusan';
        $titleeditModal = 'Edit Data Surat Keputusanh';
        $titlecreateModal = 'Create Data Surat Keputusan';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SuratKeputusan::orderBy('tanggal_sk', 'DESC')->get();
        $idTemplates = TemplateDokumen::get();


        return view('role.kepala-sekolah.surat-keputusan', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'idTemplates',
        ));
        //php artisan make:view role.kepala-sekolah.surat-keputusan

    }
    public function create()
    {
        //dd($request->all());
        $Identitas = Identitas::first();
        $kode_sekolah =


            $title = 'Buat Surat Keputusan';
        $breadcrumb = 'Kepala Sekolah / Surat Keputusan';
        $titlecreateModal = 'Create Data Surat Keputusan';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SuratKeputusan::orderBy('tanggal_sk', 'DESC')->get();
        $JmData = str_pad($datas->count(), 3, '0', STR_PAD_LEFT);
        // dd($JmData);

        return view('role.kepala-sekolah.surat-keputusan-create', compact(
            'datas',
            'title',
            'breadcrumb',
            'titlecreateModal',
            'JmData',
            'Identitas',
        ));
    }

    public function show($id)
    {
        //
        //Title to Controller
        $title = 'Kepala Sekolah';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();

        $DataRapats = DataRapat::where('tapel_id', $etapels->id)->get();
        $Kelass = Ekelas::where('tapel_id', $etapels->id)->get();
        $DataGuru = Detailguru::get();
        // $Kodes = $DataGuru->kode_guru;
        $DataEkstras = Ekstra::get();
        $DataMapels = Emapel::get();
        $DataLabs = Elaboratorium::get();

        // dump($DataEkstras);
        $breadcrumb = 'Kepala Sekolah / Kepala Sekolah';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $data = SuratKeputusan::where('id', $id)->first();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.kepala-sekolah.surat-keputusan-single', compact(
            'data',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DataRapats',
            'DataGuru',
            'DataEkstras',
            'Kelass',
            'DataMapels',
            'DataLabs',
            // 'Kodes',
        ));
        //php artisan make:view role.kepala-sekolah.surat-keputusan-single
    }

    public function store(Request $request)
    {
        //
        $request->validate([
            'nomor_sk' => 'required|unique:sks',
            'nama_sk' => 'nullable|string',
            'tanggal_sk' => 'nullable|date',
            'pejabat_penerbit' => 'nullable|string',
            'perihal' => 'nullable|string',
            'content_system' => 'nullable|string',
            'content_sekolah' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|mimes:pdf,doc,docx|max:2048'
        ]);

        $filePath = null;
        $fileName = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('sk_files', 'public');
            $fileName = $file->getClientOriginalName();
        }

        SuratKeputusan::create(array_merge($request->all(), [
            'file_path' => $filePath,
            'file_name' => $fileName
        ]));

        return redirect()->route('sk.index')->with('success', 'SK berhasil ditambahkan.');
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, SuratKeputusan $datask)
    {
        //

        // dd($request->all());
        $request->validate([
            // 'nomor_sk' => 'required|unique:sks,surat_keputusan,' . $datask->id,
            'nama_sk' => 'nullable|string',
            'detailguru_id' => 'nullable|string',
            'tanggal_sk' => 'nullable|date',
            'pejabat_penerbit' => 'nullable|string',
            'perihal' => 'nullable|string',
            'content_system' => 'nullable|string',
            'content_sekolah' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|mimes:pdf,doc,docx|max:2048'
        ]);

        $filePath = $datask->file_path;
        $fileName = $datask->file_name;

        if ($request->hasFile('file')) {
            if ($datask->file_path) {
                Storage::disk('public')->delete($datask->file_path);
            }

            $file = $request->file('file');
            $filePath = $file->store('sk_files', 'public');
            $fileName = $file->getClientOriginalName();
        }
        $datask = SuratKeputusan::find($id);
        $datask->update(array_merge($request->all(), [
            'file_path' => $filePath,
            'file_name' => $fileName
        ]));
        // dd($request->all());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, SuratKeputusan $datask)
    {
        //SuratKeputusan
        // dd($id);
        // dd($request->all());
        if ($datask->file_path) {
            Storage::disk('public')->delete($datask->file_path);
        }
        $datask = SuratKeputusan::find($id);
        $datask->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
    public function skview($id)
    {
        //dd($request->all());
        $Identitas = Identitas::first();
        $kode_sekolah =


            $title = 'Buat Surat Keputusan';
        $breadcrumb = 'Kepala Sekolah / Surat Keputusan';
        $titlecreateModal = 'Create Data Surat Keputusan';

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SuratKeputusan::findOrFail($id);
        $Templates = TemplateDokumen::findOrFail($datas->template_id);
        // dd($JmData);

        return view('role.kepala-sekolah.surat-keputusan-view', compact(
            'datas',
            'title',
            'breadcrumb',
            'titlecreateModal',
            'Identitas',
            'Templates',
            // 'ProcessedTemplate',
        ));
    }
}
