<?php

namespace App\Http\Controllers\Program\PKKS;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Program\PKKS\ProgresPKKS;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProgresPKKSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
 /*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view role.program.pkks.ProgresPKKS
php artisan make:view role.program.pkks.ProgresPKKS-single
php artisan make:model Program/PKKS/ProgresPKKS
php artisan make:controller Program/PKKS/ProgresPKKSController --resource



php artisan make:seeder Program/PKKS/ProgresPKKSSeeder
php artisan make:migration Migration_ProgresPKKS




*/
    /*
    ProgresPKKS
    $progpkks
    role.program.pkks
    role.program.pkks.progres-pkks
    role.program.pkks.blade_show
    Index = Progres PKKS
    Breadcume Index = 'Data Progres / Progres PKKS';
    Single = titel_data_single
    php artisan make:view role.program.pkks.progres-pkks
    php artisan make:view role.program.pkks.progres-pkks-single
    php artisan make:seed Progres/PKKS/ProgresPKKSSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Progres PKKS';
        $arr_ths = [
            'Kode Dokuemn',
            'Nma Dokumen',
            'Penanggung Jawab',
            'Progres',
            'Up',
        ];
        $breadcrumb = 'Data Progres / Progres PKKS';
        $titleviewModal = 'Lihat Data Progres PKKS';
        $titleeditModal = 'Edit Data Progres PKKS';
        $titlecreateModal = 'Create Data Progres PKKS';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = ProgresPKKS::where('tapel_id', $etapels->id)->get();


        return view('role.program.pkks.progres-pkks', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.pkks.progres-pkks

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Progres PKKS';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Progres / Progres PKKS';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = ProgresPKKS::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.pkks.progres-pkks-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.program.pkks.progres-pkks-single
    }

    public function store(Request $request)
    {
        $request->validate([
            'upload_dokumen' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'link' => 'required|string',
        ]);

        // Simpan file ke public/file/pkks
        if ($request->hasFile('upload_dokumen')) {
            $file = $request->file('upload_dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('file/pkks'), $filename);
        }

        // Simpan ke database
        ProgresPkks::create([
            'upload_dokumen' => $filename ?? null,
            'link' => $request->link,
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Perbarui data yang sudah ada
     */
    public function update(Request $request, $id)
    {
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
        ]);

        $request->validate([
            'upload_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'link' => 'required|string',
        ]);

        $data = ProgresPkks::findOrFail($id);

        // Update file jika ada file baru yang diunggah
        if ($request->hasFile('upload_dokumen')) {
            // Hapus file lama jika ada
            if ($data->upload_dokumen && File::exists(public_path('file/pkks/' . $data->upload_dokumen))) {
                File::delete(public_path('file/pkks/' . $data->upload_dokumen));
            }

            $file = $request->file('upload_dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filename = $request->kode_dokumen . '_pkks_'  . $etapels->tapel . '_' .  $file->getClientOriginalName();
            $file->move(public_path('file/pkks'), $filename);
            $data->upload_dokumen = $filename;
        }

        // Update link
        $data->link = $request->link;
        $data->save();

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //ProgresPKKS
        // dd($id);
        // dd($request->all());
        $data = ProgresPKKS::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
