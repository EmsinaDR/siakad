<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //
    //createuserguru
    public function createuser(Request $request)
    {
        $IdDetailguruAkhir = User::select('detailguru_id')->get()->max();
        $IdDetailguruAkhir = (int)$IdDetailguruAkhir->detailguru_id + 1;
        // dd($IdDetailguruAkhir);
        // dd($IdUserAkhir->detailguru_id);
        // dd($IdUserAkhir->id);
        // dd($request->all());
        $VarUser = User::insert([
            'posisi' => 'Guru',
            'aktive' => '1',
            'detailguru_id' => null,
            'detailsiswa_id' => null,
            'name' => $request->namaguru,
            'email' => $request->email,
            'password' => Hash::make('password'),
        ]);
        $IdUserAkhir = User::select('id')->get()->max();
        $VarDetailguru = Detailguru::insert([
            'id' => $IdDetailguruAkhir,
            'user_id' => $IdUserAkhir->id,
            'nip' => $IdDetailguruAkhir + 1,
            'namaguru' => $request->namaguru,
        ]);
        $VarUser = User::where('id', $IdUserAkhir->id)->update([
            'detailguru_id' => $IdDetailguruAkhir,
        ]);

        // $VarUpdate = request()->validate([
        //     'title' => 'required',
        // ]);
        // $request->create($VarUpdate);
        return redirect()->route('UserGuru');
    }
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'posisi' => 'nullable|string|max:255',
            'aktiv' => 'nullable|string|max:255',
            'detailguru_id' => 'nullable|exists:detailgurus,id',
            'detailsiswa_id' => 'nullable|exists:detailsiswas,id',
            'tingkat_id' => 'nullable|exists:tingkats,id',
            'kelas_id' => 'nullable|exists:ekelas,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Simpan data ke database
        $user = new User();
        $user->posisi = $validated['posisi'];
        $user->aktiv = $validated['aktiv'];
        $user->detailguru_id = $validated['detailguru_id'];
        $user->detailsiswa_id = $validated['detailsiswa_id'];
        $user->tingkat_id = $validated['tingkat_id'];
        $user->kelas_id = $validated['kelas_id'];
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->email_verified_at = now(); // Atur waktu verifikasi email
        $user->remember_token = Str::random(60);

        $user->save();

        // Redirect atau response setelah berhasil menyimpan
        return redirect()->route('user.index')->with('success', 'User berhasil disimpan!');
    }
}
