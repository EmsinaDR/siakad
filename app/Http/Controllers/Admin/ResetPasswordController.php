<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Admin\ResetPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Admin Reset Password';
        $breadcrumb = 'Admin / Reset Password';
        $titleviewModal = 'Lihat Admin';
        $titleeditModal = 'Edit Admin';
        $titlecreateModal = 'Buat Admin';
        $arr_ths = [
            'Nama',
            'Email',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $identitas = getIdentitas();
        // Mengambil data dari model terkait dengan tapel_id
        if($identitas->paket !== 'Premium'){
            $RessetPassword = Cache::tags(['cache_RessetPassword'])->remember('remember_RessetPassword', now()->addHours(2), function () {
                return ResetPassword::WhereIn('posisi', ['Admin'])->get();
            });
        }else{
            $RessetPassword = Cache::tags(['cache_RessetPassword'])->remember('remember_RessetPassword', now()->addHours(2), function () {
                return ResetPassword::whereNot('posisi', 'Admindev')->get();
            });
        }
        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.admin.resetpassword.reset-password', compact(
            'title',
            'title',
            'arr_ths',
            'RessetPassword',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Admin';
        $breadcrumb = 'xxxxxxxxxxxx / Admin';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.admin.resetpassword.reset-password-create', compact(
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
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        \App\Models\Admin\ResetPassword::create($validator->validated());

        HapusCacheDenganTag('cache_RessetPassword');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Admin';
        $breadcrumb = 'xxxxxxxxxxxx / Admin';
        $data = \App\Models\Admin\ResetPassword::findOrFail($id);

        return view('role.admin.resetpassword.reset-password-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Admin';
        $breadcrumb = 'xxxxxxxxxxxx / Admin / Edit';
        $data = \App\Models\Admin\ResetPassword::findOrFail($id);

        return view('role.admin.resetpassword.reset-password-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Admin\ResetPassword::findOrFail($id);

        // Validasi input

        $newpassword = Hash::make($request->password);
        $request->merge(['password' => $newpassword]);
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'password' => 'string'
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data yang ditemukan berdasarkan hasil validasi
        $data->update($validator->validated());
        HapusCacheDenganTag('cache_RessetPassword');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = \App\Models\Admin\ResetPassword::findOrFail($id);

        // Menghapus data
        $data->delete();
        HapusCacheDenganTag('cache_RessetPassword');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
