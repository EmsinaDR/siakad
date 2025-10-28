<?php

namespace App\Http\Controllers\Registrasi;

use App\Models\User;
use Pest\Support\Str;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Registrasi\RegistrasiSekolah;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Artisan;

class RegistrasiSekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view registrasi.registrasi-sekolah
php artisan make:view registrasi.registrasi-sekolah-single
php artisan make:model Registrasi/RegistrasiSekolah
php artisan make:controller Registrasi/RegistrasiSekolahController --resource



php artisan make:seeder Registrasi/RegistrasiSekolahSeeder
php artisan make:migration Migration_RegistrasiSekolah




*/
    /*
    RegistrasiSekolah
    $dtRegistrasiSekolah
    registrasi
    registrasi.registrasi-sekolah
    registrasi.blade_show
    Index = Data Registrasi Sekolah
    Breadcume Index = 'Data Registrasi / Data Registrasi Sekolah';
    Single = Data Registrasi Sekolah
    php artisan make:view role.program.registrasi.registrasi-sekolah
    php artisan make:view role.program.registrasi.registrasi-sekolah-single
    php artisan make:seed RegistrasiSekolahSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Registrasi Sekolah';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
        // dd($routeName); // Output: 'absensi.data'
        $breadcrumb = 'Data Registrasi / Data Registrasi Sekolah';
        $titleviewModal = 'Lihat Data Registrasi Sekolah';
        $titleeditModal = 'Edit Data Registrasi Sekolah';
        $titlecreateModal = 'Create Data Registrasi Sekolah';
        // $etapels = Etapel::where('aktiv', 'Y')->first();
        // $datas = RegistrasiSekolah::where('tapel_id', $etapels->id)->get();


        return view('registrasi.registrasi-sekolah', compact(
            // 'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view registrasi.registrasi-sekolah

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Registrasi Sekolah';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Registrasi / Data Registrasi Sekolah';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = RegistrasiSekolah::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('registrasi.registrasi-sekolah-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view registrasi.registrasi-sekolah-single
    }

    public function store(Request $request)
    {
        //
        // $request->merge([
        //     'password' => Hash::make($request->password),
        // ]);
        //
        $validated = $request->validate([
            'regis' => 'nullable|string|max:255',
            'paket' => 'nullable|string|max:255',
            'jenjang' => 'required|string|max:255',
            'nomor' => 'nullable|string|max:255',
            'kode_sekolahan' => 'nullable|string|max:255',
            'kode_kabupaten' => 'nullable|string|max:255',
            'kode_provinsi' => 'nullable|string|max:255',
            'namasingkat' => 'nullable|string|max:255',
            'namasek' => 'nullable|string|max:255',
            'nsm' => 'nullable|string|max:255',
            'npsn' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'akreditasi' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'logo' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'desa' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:255',
            'namakepala' => 'nullable|string|max:255',
            'visi' => 'nullable|string|max:255',
            'misi' => 'nullable|string|max:255',
            'tujuan' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'facebook_fanspage' => 'nullable|string|max:255',
            'facebook_group' => 'nullable|string|max:255',
            'twiter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'whatsap_group' => 'nullable|string|max:255',
            'internet' => 'nullable|string|max:255',
            'speed' => 'nullable|string|max:255',
        ]);

        // Simpan data ke database
        $identitas = RegistrasiSekolah::create($validated);
        // Pembuatan User Admin
        $user = new User();
        $user->posisi = 'Admin';
        $user->aktiv = 'Y';
        $user->detailguru_id = Null;
        $user->name = 'Admin Sekolah';
        $user->email = $validated['email'];
        $user->password = Hash::make($request->password);
        $user->email_verified_at = now(); // Atur waktu verifikasi email
        $user->remember_token = Str::random(60);
        $user->save();

        //
        $tahun = date('Y');
        $tapel = range($tahun - 3, $tahun);
        for ($i = 0; $i < 4; $i++) {
            $etapels = [
                [
                    'tapel' => $tapel[$i],
                    'semester' => 'I',
                    'aktiv' => '0',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'tapel' => $tapel[$i],
                    'semester' => 'II',
                    'aktiv' => '0',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];
            // DB::table('etapels')->where('aktiv', 'Y')->first();
            DB::table('etapels')->insert($etapels);
            DB::table('etapels')->where('tapel', 2025)->where('semester', 'II')->update([
                'aktiv' => 'Y'
            ]);
        }

        // Data Guru
        $DataIds = User::select('id')->pluck('id')->max();
        // dd($DataIds);
        DB::table('detailgurus')->insert([
            'user_id' => $DataIds,
            'kode_guru' => 'ASD',
            'nama_guru' => 'Admin Sekolah',
            'nip' => fake()->numerify('############'),
            'nik' => fake()->numerify('############'),
        ]);
        $DataUserIds = Detailguru::select('id')->pluck('id')->max();
        DB::table('users')->where('id', $DataIds)->update([
            'detailguru_id' => $DataUserIds
        ]);


        // Proses Seeder Data" yang perlu
        // Menjalankan seeder tertentu
        // Artisan::call('db:seed', [
        //     '--class' => 'Aplikasi\\Fitur\\FiturAplikasiSeeder', // Ganti dengan nama seeder yang sesuai untuk Gratis, Trial, Basi, Premium
        // ]);


        // RegistrasiSekolah::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return redirect('/login');
    }
    public function update($id, Request $request, RegistrasiSekolah $dtRegistrasiSekolah)
    {
        //

        dd($request->all());
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
        $varmodel = RegistrasiSekolah::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //RegistrasiSekolah
        // dd($id);
        // dd($request->all());
        $data = RegistrasiSekolah::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
