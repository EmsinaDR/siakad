<?php

namespace App\Http\Controllers\Perpustakaan;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Perpustakaan\Ebook;
use App\Http\Controllers\Controller;
use App\Models\Perpustakaan\PerpustakaanKategoriBuku;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dd($request->all());
        //Title to Controller
        $title = 'Katalog E Book Perpustakaan';
        $arr_ths = [
            'Image',
            'Judul Ebook',
            'Kategori',
            'ISBN',
            'Penulis'
        ];
        $breadcrumb = 'Perpustakaan / Katalog Buku';
        $titleviewModal = 'Lihat Data Katalog Buku';
        $titleeditModal = 'Edit Data Katalog Buku';
        $titlecreateModal = 'Create Data Katalog Buku';
        $datas = Ebook::with('EbookToKategori')->get();
        $kategoriBuku = PerpustakaanKategoriBuku::get();
        // dd($datas->first()->toArray());
        $data_user_sekolah = User::whereIn('posisi', ['Guru', 'Karyawan', 'Kepamad', 'Kepala', 'Siswa'])->count();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.Perpustakaan.katalog-ebook', compact(
            'data_user_sekolah',
            'datas',
            'title',
            'arr_ths',
            'kategoriBuku',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
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
        // Validasi data
        $validator = Validator::make($request->all(), [
            'judul_ebook'   => 'nullable|string|max:255',
            'kode_buku'     => 'nullable|string|max:255',
            'isbn'          => 'required|string|unique:ebooks,isbn|max:255',
            'kategori_id'   => 'nullable|string|max:255',
            'judul_buku'    => 'nullable|string|max:255',
            'penulis'       => 'nullable|string|max:255',
            'penerbit'      => 'nullable|string|max:255',
            'tahun_terbit'  => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'tahun_masuk'   => 'nullable|string',
            'link_ebook'    => 'nullable|url',
            'abstraksi'     => 'nullable|string',
        ]);


        $ebook = Ebook::create($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Menyimpan data menggunakan mass assignment
        // Create : Buat
        // Update : Memperbaharui
        // Menyimpan data menggunakan mass assignment
        Ebook::create($validator->validated());
        Session::flash(
            'success',
            'Data Berhasil Dihapus'
        );
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Ebook $ebook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ebook $ebook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)

    {

        // dd($id);
        // Validasi data
        $validator = Validator::make($request->all(), [
            'judul_ebook'   => 'nullable|string|max:255',
            'kode_buku'     => 'nullable|string|max:255',
            'isbn' => 'required|string',
            'kategori_id'   => 'nullable|string|max:255',
            'judul_buku'    => 'nullable|string|max:255',
            'penulis'       => 'nullable|string|max:255',
            'penerbit'      => 'nullable|string|max:255',
            'tahun_terbit'  => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'tahun_masuk'   => 'nullable|string',
            'link_ebook'    => 'nullable|url',
            'abstraksi'     => 'nullable|string',
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
        $varmodel = Ebook::where('id', $id)->first(); // Pastikan $id didefinisikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($validator->validated());
            return Redirect::back()->with('Title', 'Berhasil')->with('success', 'Data Berhasil di Update');
        } else {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Data tidak ditemukan');
        }
        Session::flash('success', 'Data Berhasil Dihapus');
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //Ebook
        // dd(id);
        // dd(request->all());
        $VarEbook = Ebook::findOrFail($id);
        $VarEbook->delete();
        // Simpan pesan dalam session
        Session::flash('success', 'Data Berhasil Dihapus');
        return Redirect::back();
    }
}
