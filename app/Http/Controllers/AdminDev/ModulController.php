<?php

namespace App\Http\Controllers\AdminDev;

use Exception;
use Carbon\Carbon;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\AdminDev\Modul;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ModulController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'AdminDev';
        $breadcrumb = 'AdminDev / Modul';
        $titleviewModal = 'Lihat AdminDev';
        $titleeditModal = 'Edit Modul AdminDev';
        $titlecreateModal = 'Buat Modul AdminDev';
        $arr_ths = [
            'Modul',
            'Class Provider',
            'Slug',
            'Is Aktiv',

        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        HapusCacheDenganTag('Modul');
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        // addHours addMinutes
        // $Moduls = Cache::tags(['Cache_Modular'])->remember('Remember_Modular', now()->addMinutes(10), function () {
        //     return Modul::orderBy('modul', 'ASC')->get();
        // });
        $authUser = Auth::check(); // ambil di luar cache
        $Moduls = Modul::orderBy('modul', 'ASC')->get();
        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.admindev.modul.modul', compact(
            'title',
            'title',
            'arr_ths',
            'Moduls',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data AdminDev';
        $breadcrumb = 'Create AdminDev / Modul';

        // Breadcrumb (jika diperlukan)

        return view('role.admindev.modul.modul-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {
        // Mendapatkan data Etapel yang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge(['tapel_id' => $etapels->id]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            // 'tapel_id' => 'required|numeric|min:1|max:100',
            'modul' => 'required|string|min:3|max:255',
            'is_active' => 'integer',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        Modul::create($validator->validated());

        HapusCacheDenganTag('modul');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');
        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail AdminDev';
        $breadcrumb = 'Lihat AdminDev / Modul';
        $data = Modul::findOrFail($id);

        return view('role.admindev.modul.modul-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit AdminDev';
        $breadcrumb = 'xxxxxxxxxxxx / AdminDev / Edit';
        $data = Modul::findOrFail($id);


        return view('role.admindev.modul.modul-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = Modul::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'modul' => 'required|string|min:3|max:255',
            'is_active' => 'integer',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data yang ditemukan berdasarkan hasil validasi
        $data->update($validator->validated());


        HapusCacheDenganTag('modul');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = Modul::findOrFail($id);

        // Menghapus data
        $data->delete();

        HapusCacheDenganTag('modul');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
    public function ModulUbahMasal(Request $request)
    {
        //dd($request->all());
        $dataModul = $request->modul;
        // dd($dataModul);
        // dd($request->all());
        $modul = Modul::whereIn('id', $dataModul)->update([
            'is_active' => $request->aktivasi === 'Aktiv' ? 1 : 0,
        ]);
        HapusCacheDenganTag('modul');
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Sukses diubah');
    }
}
/*



php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
cls



php artisan migrate:fresh --seed


composer dump-autoload

*/