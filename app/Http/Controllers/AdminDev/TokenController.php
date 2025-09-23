<?php

namespace App\Http\Controllers\AdminDev;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\AdminDev\Token;
use App\Models\Admin\Identitas;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TokenController extends Controller
{
    public function index()
    {

        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'AdminDev';
        $breadcrumb = 'AdminDev / Token App';
        $titleviewModal = 'Lihat AdminDev';
        $titleeditModal = 'Edit AdminDev';
        $titlecreateModal = 'Buat AdminDev';
        $arr_ths = [
            'xxxxxxxxxxxxxxxxxxx',
            'xxxxxxxxxxxxxxxxxxx',
            'xxxxxxxxxxxxxxxxxxx',
        ];
        // dd([
        //     'default_guard' => Auth::getDefaultDriver(),
        //     'web_guard_check' => Auth::guard('web')->check(),
        //     // 'admindev_guard_check' => Auth::guard('admindev')->check(),
        //     'user' => Auth::user(),
        // ]);

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\AdminDev\Token::where('tapel_id', $etapels->id)->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.admindev.token.token', compact(
            'title',
            'title',
            'arr_ths',
            'datas',
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
        $breadcrumb = 'xxxxxxxxxxxx / AdminDev';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.admindev.token.token-create', compact(
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
        \App\Models\AdminDev\Token::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail AdminDev';
        $breadcrumb = 'xxxxxxxxxxxx / AdminDev';
        $data = \App\Models\AdminDev\Token::findOrFail($id);

        return view('role.admindev.token.token-single', compact(
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
        $data = \App\Models\AdminDev\Token::findOrFail($id);

        return view('role.admindev.token.token-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    // public function update(Request $request, $id)
    // {
    //     // Menemukan data yang akan diupdate berdasarkan ID
    //     $data = \App\Models\AdminDev\Token::findOrFail($id);

    //     // Validasi input
    //     $validator = Validator::make($request->all(), [
    //         // Tambahkan validasi sesuai kebutuhan
    //     ]);

    //     // Jika validasi gagal, kembalikan dengan pesan error
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     // Update data yang ditemukan berdasarkan hasil validasi
    //     $data->update($validator->validated());

    //     // Menyimpan pesan sukses di session
    //     Session::flash('success', 'Data berhasil diperbarui');

    //     // Mengarahkan kembali ke halaman sebelumnya
    //     return Redirect::back();
    // }

    // public function updatex(Request $request)
    // {
    //     dd($request->all());

    //     $request->validate([
    //         'paket' => 'required',
    //     ]);

    //     $tokenBaru = Crypt::encryptString('secure-token-' . uniqid());

    //     DB::table('identitas')->update([
    //         'paket' => $request->paket, // Paket yang dipilih (Gratis, Premium, dll)
    //         'token' => $tokenBaru,
    //         'trial_ends_at' => $request->paket == 'Trial' ? now()->addDays(14) : null,
    //     ]);
    //     return redirect()->route('admin.token.index')->with('success', 'Token berhasil diperbarui!');
    // }
    public function update(Request $request)
    {
        // Debug untuk melihat data yang dikirimkan
        // dd($request->all());

        // Validasi input
        // Premium, Gratis
        // $request->merge(['paket' => 'Premium']);
        // dd($request->all());
        $request->validate([
            'paket' => 'required',
        ]);
        $identitas = Identitas::first();
        // Ambil nama sekolah (misalnya bisa dari database atau input form)
        $trial_ends_at = $request->trial_end ?? $identitas->trial_ends_at;
        // contoh penggunaan paket tetap
        if ($request->paket === 'Trail') {
            $trial_ends_at = now()->addDays(90);
        } else if ($request->paket === 'Premium') {
            $trial_ends_at = now()->addDays(365);
        }

        // Buat token dengan format khusus
        $customToken = $identitas->namasek . '|' . $request->paket . '|' . $trial_ends_at . '|admindev' . uniqid(); //Isi asli
        // Enkripsi token
        $hash = Hash::make($customToken); // Has Vendor

        $tokenBaru = Crypt::encryptString($customToken); // isi terenkripsi simpan disatu tempat yang akan dibandingkan dengan has vendor
        $tokenAsli = Crypt::decryptString($tokenBaru);
        $HasilCek = Hash::check($tokenAsli, $hash); // ✅ True
        // dd($customToken, $tokenBaru, $tokenAsli, $hash, $HasilCek);
        // Update data di tabel identitas
        // dd($trial_ends_at);
        DB::table('identitas')->update([
            'paket' => $request->paket,
            'token' => $tokenBaru,
            'trial_ends_at' => $trial_ends_at,
        ]);

        // Hapus cache terkait Identitas yang lama
        Cache::forget('identitas_data'); // Menghapus cache yang ada sebelumnya

        // Ambil data Identitas yang baru dan simpan kembali ke dalam cache
        $identitas = DB::table('identitas')->first();
        Cache::put('identitas_data', $identitas, now()->addDays(1)); // Menyimpan data yang baru dalam cache untuk 1 hari

        // Redirect ke halaman index dengan pesan sukses

        Session::flash('success', 'Token berhasil diperbaharui');
        return Redirect::back();
        return redirect()->route('admin.token.index')->with('success', 'Token berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = \App\Models\AdminDev\Token::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
