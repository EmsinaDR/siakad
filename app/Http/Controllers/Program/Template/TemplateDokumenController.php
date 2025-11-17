<?php

namespace App\Http\Controllers\Program\Template;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Template\TemplateDokumen;

class TemplateDokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Template Dokumen';
        $arr_ths = [
            'Kategori',
            'Nama Template Dokumen',
        ];
        $breadcrumb = 'Data Template / Data Template Dokumen';
        $titleviewModal = 'Lihat Data Template Dokumen';
        $titleeditModal = 'Edit Data Template Dokumen';
        $titlecreateModal = 'Create Data Template Dokumen';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // dd(request()->segment(3));
        // if(request()->segment(3) === 'Kurikulum'){
        //     $datas = TemplateDokumen::where('kategori', 'Program Kerja')->get();
        // }else{
        //     $datas = TemplateDokumen::orderBy('kategori')->get();
        // }
        // ->where('laboratorium_id', request()->segment())->
        $datas = TemplateDokumen::orderBy('kategori')->get();
        // dump($datas);


        return view('role.program.template.template-dokumen', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.template.template-dokumen

    }
    public function TemplateKhusus($key)
    {
        //
        //Title to Controller
        $title = 'Data Template Dokumen';
        $arr_ths = [
            'Kategori',
            'Nama Template Dokumen',
        ];
        $breadcrumb = 'Data Template / Data Template Dokumen';
        $titleviewModal = 'Lihat Data Template Dokumen';
        $titleeditModal = 'Edit Data Template Dokumen';
        $titlecreateModal = 'Create Data Template Dokumen';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // dump($key, request()->segment(4));
        if ($key === null) {
            return back()->with('error', 'Dokumen tidak ada');
        }


        // if (request()->segment(3) === 'kurikulum') {
        $datas = TemplateDokumen::where('kategori', 'Program Kerja')->where('nama_dokumen', 'like', '%' . request()->segment(4) . '%')->get();
        // } else {
        // $datas = TemplateDokumen::orderBy('kategori',)->get();
        // }
        // ->where('laboratorium_id', request()->segment())->
        // $datas = TemplateDokumen::orderBy('kategori')->get();
        // dump($datas);


        return view('role.program.template.template-dokumen', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.template.template-dokumen

    }

    public function create()
    {
        $breadcrumb = 'Data Template / Data Template Dokumen';
        $title = 'Data Template Dokumen';
        $KategoriDokumens = TemplateDokumen::orderBy('kategori', 'ASC')->distinct()->pluck('kategori')->toArray();

        return view('role.program.template.template-dokumen-create', compact(
            'title',
            'breadcrumb',
            'KategoriDokumens',
        ));
    }
    public function show($id)
    {
        //
        //Title to Controller
        $title = 'Data Template Dokumen';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Template / Data Template Dokumen';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = TemplateDokumen::where('tapel_id', $etapels->id)->get();
        $data = TemplateDokumen::find($id);
        $KategoriDokumens = TemplateDokumen::distinct()->pluck('kategori')->orderBy('kategori', 'ASC')->toArray();



        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.template.template-dokumen-single', compact(
            'data',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'KategoriDokumens',
        ));
        //php artisan make:view role.program.template.template-dokumen-single
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        // Validasi input
        // dd($request->all());
        $data = [];

        if ($request->nama_sekolah === 'on') {
            $data['nama_sekolah'] = $request->nama_sekolah;
        }

        // dd($request->all(), $data);

        $request->validate([
            'nama_dokumen' => 'required|string|max:255|unique:template_dokumen,nama_dokumen',
            'content' => 'required|string',
        ]);
        // Ambil semua input selain token, nama_dokumen, dan content
        $input = $request->except(['_token', 'nama_dokumen', 'content']);

        $field_structure = []; // inisialisasi array kosong

        foreach ($input as $key => $value) {
            if (!empty($value)) {  // skip null atau empty
                $decoded = json_decode($value, true); // decode JSON string jadi array
                if ($decoded !== null) {  // pastikan decode berhasil
                    $field_structure[] = $decoded; // masukkan ke array tanpa key
                }
            }
        }

        $name_input = json_encode($field_structure); // encode ulang jadi JSON array objek
        // Simpan data ke database
        TemplateDokumen::create([
            'kategori' => $request->input('kategori'),
            'nama_dokumen' => $request->input('nama_dokumen'),
            'content' => $request->input('content'),
            'name_input'   => $name_input,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('template-dokumen.index')->with('success', 'Template dokumen berhasil ditambahkan.');
    }
    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'content' => 'required|string',
        ]);

        // Ambil data berdasarkan ID
        $dokumen = TemplateDokumen::findOrFail($id);

        // Update konten saja (karena nama_dokumen readonly)
        $dokumen->content = $request->input('content');
        $dokumen->save();

        // Redirect kembali dengan pesan sukses
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //TemplateDokumen
        // dd($id);
        // dd($request->all());
        $data = TemplateDokumen::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
    public function TemplateCetak()
    {
        //dd($request->all());
        $breadcrumb = 'Data Template / Data Template Dokumen';
        $title = 'Data Template Dokumen';

        return view('role.program.template.template-dokumen-cetak', compact(
            'title',
            'breadcrumb',
        ));
    }
    public function getEdaranTemplates($id)
    {
        $templates = TemplateDokumen::find($id);

        return response()->json($templates);
    }
}
