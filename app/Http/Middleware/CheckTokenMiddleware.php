<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use App\Models\Admin\Identitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class CheckTokenMiddleware
{
    public function handle($request, Closure $next)
    {

        // Cek jika rute yang sedang diakses adalah login, lewati pengecekan token
        if ($request->is('login')) {
            return $next($request);
        }

        // Cek jika rute yang sedang diakses adalah 'admindev/*', lewati pengecekan token
        if ($request->is('admindev/*')) {
            return $next($request);
        }

        // Ambil identitas dari database
        $identitas = Identitas::first();

        // Cek apakah token ada
        if (!$identitas || !$identitas->token) {
            // Token tidak ada, arahkan ke halaman kunci
            return redirect()->route('lockscreen');
        }

        try {
            // 1. Coba untuk mendekripsi token yang disimpan di database.
            //    $identitas->token berisi data terenkripsi.
            //    Crypt::decryptString akan mencoba mengubahnya kembali ke bentuk aslinya.
            $token = Crypt::decryptString($identitas->token);
        } catch (\Exception $e) {
            // 2. Kalau terjadi error saat decrypt (contoh: data token rusak, key salah, dsb),
            //    maka akan langsung masuk ke blok catch ini.
            //    Karena tidak bisa mendapatkan token yang valid, user langsung diarahkan ke halaman kunci (lockscreen).
            return redirect()->route('lockscreen');
        }
        $Expired = Carbon::create($identitas->trial_ends_at)->format('Y-m-d');
        // if (!Str::contains($token, $Expired)) {
        //     dd('lanjut', $Expired);
        // }

        // // if($identitas->trial_ends_at)->translatedFormat('d F Y'));

        // dd(Carbon::create($identitas->trial_ends_at)->translatedFormat('d F Y'), Carbon::now()->translatedFormat('d F Y'));
        // 3. Kalau berhasil decrypt tanpa error, kita lanjut ke sini.
        //    Sekarang kita punya isi token dalam variabel $token, misalnya "Gratis", "Trial", dll.

        // 4. Cek apakah isi token tersebut termasuk dalam daftar token yang valid: Gratis, Basic, Trial, Premium.
        // masalh in array tanpa explode
        if (!Str::contains($token, ['Gratis', 'Kerjasama', 'Basic', 'Trial', 'Premium'])) {

            // if (!in_array($token, ['Kerjasama', 'Gratis', 'Basic', 'Trial', 'Premium'])) {
            // 5. Jika token yang didecrypt tidak termasuk dalam daftar yang valid,
            //    berarti token tersebut tidak sah (mungkin diubah-ubah atau tidak sesuai sistem).
            //    Maka user tetap diarahkan ke halaman kunci (lockscreen).
            return redirect()->route('lockscreen');
        }

        // 6. Kalau lolos dari kedua pengecekan di atas,
        //    artinya token valid dan user bisa lanjut ke proses berikutnya dalam aplikasi.


        // Lanjutkan ke request berikutnya jika sudah valid
        return $next($request);
    }
}
