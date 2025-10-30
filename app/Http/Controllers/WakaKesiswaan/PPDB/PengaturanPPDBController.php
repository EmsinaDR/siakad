<?php

namespace App\Http\Controllers\WakaKesiswaan\PPDB;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKesiswaan\PPDB\PengaturanPPDB;

class PengaturanPPDBController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    PengaturanPPDB
    $pengaturanPPDB
    role.ppdb
    role.ppdb.pengaturan-ppdb
    role.ppdb.blade_show
    Index = Pengaaturan PPDB
    Breadcume Index = 'Panitia PPDB / Pengaturan PPDB';
    Single = titel_data_single
    php artisan make:view role.ppdb.pengaturan-ppdb
    php artisan make:view role.ppdb.pengaturan-ppdb-single
    php artisan make:seed PengaturanPPDBSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Pengaaturan PPDB';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Panitia PPDB / Pengaturan PPDB';
        $titleviewModal = 'Lihat Data Pengaaturan PPDB';
        $titleeditModal = 'Edit Data Pengaaturan PPDB';
        $titlecreateModal = 'Create Data Pengaaturan PPDB';
        $datas = PengaturanPPDB::get();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        $pengaturan = PengaturanPPDB::where('tapel_id', $etapels->id)->first();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.ppdb.pengaturan-ppdb', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'pengaturan',
        ));
        //php artisan make:view role.ppdb.pengaturan-ppdb

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'titel_data_single';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Panitia / Pengaturan PPDB';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = PengaturanPPDB::get();



        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.ppdb.pengaturan-ppdb-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.ppdb.pengaturan-ppdb-single
    }

    public function store(Request $request)
    {
        //

        // dd($request->all());
        // Ambil data pertama dari Etapel yang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Jika tidak ditemukan, kembalikan error
        if (!$etapels) {
            return redirect()->back()->with('error', 'Data Etapel tidak ditemukan.');
        }

        // Buat array isi sebelum merge()
        $isi = [
            'nominal' => (int) $request->input('nominal', 0), // Pastikan integer
            'jumlah_peserta' => (int) $request->input('jumlah_peserta', 0), // Pastikan integer
        ];

        // Tambahkan tapel_id dan isi ke dalam request
        $request->merge([
            'tapel_id' => $etapels->id,
            'isi'      => $isi,
            'tentang'  => 'PPDB',
        ]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'tapel_id'        => 'required|integer|exists:etapels,id',
            'isi'             => 'nullable|array',
            'tentang'         => 'nullable|string',
            'keterangan'         => 'nullable|string',
        ]);

        // Jika validasi gagal, kembalikan dengan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ambil hasil validasi
        $validatedData = $validator->validated();

        // Simpan dalam database sebagai JSON
        PengaturanPPDB::updateOrCreate(
            ['tapel_id' => $validatedData['tapel_id']], // Kondisi pencarian
            [
                'isi'      => $isi, // Laravel otomatis menyimpan sebagai JSON
                'tentang'  => $validatedData['tentang'] ?? null,
            ]
        );
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, PengaturanPPDB $pengaturanPPDB)
    {
        //

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            //data_field_validator
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Menyimpan data menggunakan mass assignment
        // Create : Buat
        // Update : Memperbaharui
        // Menyimpan data menggunakan mass assignment
        $varmodel = PengaturanPPDB::find($id); // Pastikan $id didefinisikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($validator->validated());
            return Redirect::back()->with('Title', 'Berhasil')->with('success', 'Data Berhasil di Update');
        } else {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Data tidak ditemukan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //PengaturanPPDB
        // dd(id);
        // dd(request->all());
        $data = PengaturanPPDB::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}
