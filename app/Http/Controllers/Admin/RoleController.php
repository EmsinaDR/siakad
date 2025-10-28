<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
// use App\Models\RoleUser;
use App\Models\Admin\Role;
use Illuminate\Support\Str;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Admin\RoleUser;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    //
    public function index()
    {
        //Title to Controller
        $title = 'Data Tugas Tambahan';
        $arr_ths = [
            'Nama',
            'Tugas Utama',
            'Tugas Tambahan',
            'Status'
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $user_dropdown = User::with('UsertoRole')->where('posisi', 'Guru')->orwhere('posisi', 'Karyawan')->orwhere('posisi', 'Kamad')->orderBy('name')->get();
        $datas = User::with('UsertoRole')->whereIn('posisi', ['Guru', 'Karyawan', 'Kamad'])->orderBy('detailguru_id')->get();
        $datas = Role::where('tapel_id', $etapels->id)->get();
        $arr_roles = [
            'Role',
            'Nama',
            'Keterangan',

        ];
        $dataRole = Role::get();
        $dataRole = Cache::tags(['chace_dataRole'])->remember('remember_dataRole', now()->addHours(2), function () {
            return Role::get();
        });
        $breadcrumb = 'Tugas Tambahan / Tugas Tambahan';
        $titleviewModal = 'Detail Data Tugas Tambahan';
        $titleeditModal = 'Edit Data Tugas Tambahan';
        $titlecreateModal = 'Create Data Tugas Tambahan';
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('admin.role_guru', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal', 'arr_roles', 'user_dropdown'));
    }

    public function update($role, Request $request)
    {
        // try {
        // dd($request->role_id);
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $cekroll = RoleUser::where('role_id', $request->role_id)->count();
        if ($cekroll !== Null or $cekroll === 0) {
            $data = RoleUser::where('role_id', $request->role_id)->first();
            $data->where('role_id', $request->role_id)->delete();
            foreach ($request->user_id as $rol_in):
                DB::table('role_user')->insert(
                    [
                        'tapel_id' => $etapels->id,
                        'role_id' => $request->role_id,
                        'user_id' => $rol_in
                    ]
                );
            // sleep(5);
            endforeach;
            HapusCacheDenganTag('chace_dataRole');
            return Redirect::back()->with('Title', 'Update')->with('Success', 'Data telah diperbaharui');
        } else {
            $data = RoleUser::where('role_id', $request->role_id)->first();
            $data->where('role_id', $request->role_id)->delete();
        }
        // else
        return Redirect::back()->with('Title', 'Update')->with('Success', 'Data telah diperbaharui');
        // } catch (Exception $e) {
        //     // Tindakan jika terjadi exception
        //     // return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        //     return Redirect::back();
        // }
    }

    public function store(Request $request)
    {
        // try {
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // dd($etapels->id);
        //data Waka Kesiswaan
        if ($request->kepala !== null):
            $role = ucwords(str_replace('_', ' ', 'kepala'));
            $role_id = DB::table('roles')->where('name', $role)->pluck('id')->first();
            // dd($role_id);
            $cek_jabatan = RoleUser::where('role_id', $role_id)->where($etapels->id)->count();
            // dd($cek_jabatan);
            if ($cek_jabatan !== 0):
                $hasil = 'Sudah ada';
            // dd($cek_jabatan);
            else:
                DB::table('role_user')->insert([
                    'tapel_id' => $etapels->id,
                    'role_id' => $role_id,
                    'user_id' => $request->kepala
                ]);
                $hasil = 'Cek DB';
            endif;
        else:
            $hasil = 'stop';
        endif;
        if ($request->waka_kesiswaan !== null):
            $role = ucwords(str_replace('_', ' ', 'waka_kesiswaan'));
            $role_id = DB::table('roles')->where('name', $role)->pluck('id')->first();
            // dd($role_id);
            $cek_jabatan = RoleUser::where('role_id', $role_id)->where($etapels->id)->count();
            // dd($cek_jabatan);
            if ($cek_jabatan !== 0):
                $hasil = 'Sudah ada';
            // dd($cek_jabatan);
            else:
                DB::table('role_user')->insert([
                    'tapel_id' => $etapels->id,
                    'role_id' => $role_id,
                    'user_id' => $request->waka_kesiswaan
                ]);
                $hasil = 'Cek DB';
            endif;
        else:
            $hasil = 'stop';
        endif;
        // dd($hasil);
        //data Waka Kurikulum
        if ($request->waka_kurikulum !== null):
            $role = ucwords(str_replace('_', ' ', 'waka_kurikulum'));
            $role_id = DB::table('roles')->where('name', $role)->pluck('id')->first();
            // dd($role_id);
            $cek_jabatan = RoleUser::where('role_id', $role_id)->where($etapels->id)->count();
            // dd($cek_jabatan);
            if ($cek_jabatan !== 0):
                $hasil = 'Sudah ada';
            else:
                DB::table('role_user')->insert([
                    'tapel_id' => $etapels->id,
                    'role_id' => $role_id,
                    'user_id' => $request->waka_kurikulum
                ]);
            endif;
            $hasil = 'Cek Kurikulum DB';
        else:
            $hasil = 'stop';
        endif;
        // dd($hasil);
        //data Waka Humas
        if ($request->waka_humas !== null):
            $role = ucwords(str_replace('_', ' ', 'waka_humas'));
            $role_id = DB::table('roles')->where('name', $role)->pluck('id')->first();
            // dd($role_id);
            $cek_jabatan = RoleUser::where('role_id', $role_id)->where($etapels->id)->count();
            // dd($cek_jabatan);
            if ($cek_jabatan !== 0):
                $hasil = 'Sudah ada';
            else:
                DB::table('role_user')->insert([
                    'tapel_id' => $etapels->id,
                    'role_id' => $role_id,
                    'user_id' => $request->waka_humas
                ]);
            endif;
            $hasil = 'Cek waka_humas DB';
        else:
            $hasil = 'stop';
        endif;
        //data Waka Sarpras
        if ($request->waka_sarpras !== null):
            $role = ucwords(str_replace('_', ' ', 'waka_sarpras'));
            $role_id = DB::table('roles')->where('name', $role)->pluck('id')->first();
            // dd($role_id);
            $cek_jabatan = RoleUser::where('role_id', $role_id)->where($etapels->id)->count();
            // dd($cek_jabatan);
            if ($cek_jabatan !== 0):
                $hasil = 'Sudah ada';
            else:
                DB::table('role_user')->insert([
                    'tapel_id' => $etapels->id,
                    'role_id' => $role_id,
                    'user_id' => $request->waka_sarpras
                ]);
            endif;
            $hasil = 'Cek waka_sarpras DB';
        else:
            $hasil = 'stop';
        endif;
        // dd($hasil);
        //data Pembina Osis
        if ($request->pembina_osis !== null):
            $role = ucwords(str_replace('_', ' ', 'pembina_osis'));
            $role_id = DB::table('roles')->where('name', $role)->pluck('id')->first();
            // dd($role_id);
            $cek_jabatan = RoleUser::where('role_id', $role_id)->count();
            // dd($cek_jabatan);
            if ($cek_jabatan !== 0):
                $hasil = 'Sudah ada';
            else:
                DB::table('role_user')->insert([
                    'tapel_id' => $etapels->id,
                    'role_id' => $role_id,
                    'user_id' => $request->pembina_osis
                ]);
            endif;
            $hasil = 'Cek pembina_osis DB Sudah ada';
        else:
            $hasil = 'stop';
        endif;
        // dd($hasil);
        //data Petugas Perpus
        if ($request->pembina_perpus !== null):
            $role = ucwords(str_replace('_', ' ', 'pembina_perpus'));
            $role_id = DB::table('roles')->where('name', $role)->pluck('id')->first();
            // dd($role_id);
            $cek_jabatan = RoleUser::where('role_id', $role_id)->where($etapels->id)->count();
            // dd($cek_jabatan);
            if ($cek_jabatan !== 0):
                $hasil = 'Sudah ada';
            else:
                DB::table('role_user')->insert([
                    'tapel_id' => $etapels->id,
                    'role_id' => $role_id,
                    'user_id' => $request->pembina_perpus
                ]);
            endif;
            $hasil = 'Cek pembina_perpus DB Sudah ada';
        else:
            $hasil = 'stop';
        endif;
        // dd($hasil);

        //data Bendahara BOS
        if ($request->bendahara_bos !== null):
            $role = ucwords(str_replace('_', ' ', 'bendahara_bos'));
            $role_id = DB::table('roles')->where('name', $role)->pluck('id')->first();
            // dd($role_id);
            $cek_jabatan = RoleUser::where('role_id', $role_id)->where($etapels->id)->count();
            // dd($cek_jabatan);
            if ($cek_jabatan !== 0):
                $hasil = 'Sudah ada';
            else:
                DB::table('role_user')->insert([
                    'tapel_id' => $etapels->id,
                    'role_id' => $role_id,
                    'user_id' => $request->bendahara_bos
                ]);
            endif;
            $hasil = 'Cek bendahara_bos DB Sudah ada';
        else:
            $hasil = 'stop';
        endif;

        //data Bendahara Komite
        if ($request->bendahara_komite !== null):
            $role = ucwords(str_replace('_', ' ', 'bendahara_komite'));
            $role_id = DB::table('roles')->where('name', $role)->pluck('id')->first();
            // dd($role_id);
            $cek_jabatan = RoleUser::where('role_id', $role_id)->where($etapels->id)->count();
            // dd($cek_jabatan);
            if ($cek_jabatan !== 0):
                $hasil = 'Sudah ada';
            else:
                DB::table('role_user')->insert([
                    'tapel_id' => $etapels->id,
                    'role_id' => $role_id,
                    'user_id' => $request->bendahara_komite
                ]);
            endif;
            $hasil = 'Cek bendahara_komite DB Sudah ada';
        else:
            $hasil = 'stop';
        endif;
        // dd($request->all());
        //data Bendahara Study Tour
        if ($request->bendahara_study_tour !== null):
            $role = ucwords(str_replace('_', ' ', 'bendahara_study_tour'));
            $role_id = DB::table('roles')->where('name', $role)->pluck('id')->first();
            // dd($role_id);
            $cek_jabatan = RoleUser::where('role_id', $role_id)->where($etapels->id)->count();
            // dd($cek_jabatan);
            if ($cek_jabatan !== 0):
                $hasil = 'Sudah ada';
            else:
                DB::table('role_user')->insert([
                    'tapel_id' => $etapels->id,
                    'role_id' => $role_id,
                    'user_id' => $request->bendahara_study_tour
                ]);
            endif;
            $hasil = 'Cek bendahara_study_tour DB Sudah ada';
        else:
            $hasil = 'stop';
        endif;
        HapusCacheDenganTag('chace_dataRole');
        return Redirect::back()->with('Title', 'Proses Updat')->with('Success', 'Proses update telah selesai');
    }
    public function destroy($id, Request $request)
    {
        //RoleUser
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $data = RoleUser::where('tapel_id', $etapels->id)->where('user_id', $id)->get();
        $data->delete();
        HapusCacheDenganTag('chace_dataRole');
        // dd($id);

        return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahapus Berhasil dihapus dari databse');
    }
    public function role_siswa_index(Request $request)
    {
        //Title to Controller
        $title = 'Admin Role';
        $arr_ths = [
            'Nama',
            'Aktiv',
            'Role',
            'Password',
        ];
        $breadcrumb = 'Admin Role / Siswa';
        $titleviewModal = 'Lihat Data Admin Role';
        $titleeditModal = 'Edit Data Admin Role';
        $titlecreateModal = 'Create Data Admin Role';
        $datas = User::with('UsersDetailsiswa')->where('posisi', 'Siswa')->get();
        // return 'oke';
        return view('admin.role_siswa', compact('title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal', 'datas'));
    }
    public function role_siswa_reseter(Request $request)
    {
        try {
            // dd($request->all());
            // dd($id);
            $data = User::findOrFail($request->id);
            // dd($data);
            // dd($data->aktiv);
            if ($data->aktiv !== 'Y'):
                $data->aktiv = 'Y';
                $data->update();
            else:
                $data->aktiv = 'N';
                $data->update();
            endif;
            // dd($request->all());

            return Redirect::back()->with('Title', 'Riset Password')->with('Success', 'Password telah direset ke pengaturan awal');
            // dd($request->id);
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }
    public function role_siswa_lock(Request $request)
    {
        try {
            // dd($request->all());
            // dd($id);
            $data = User::findOrFail($request->id);
            $data->password = Hash::make('password');
            return Redirect::back()->with('Title', 'Riset Password')->with('Success', 'Password telah direset ke pengaturan awal');
            // dd($request->id);
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }
    public function role_siswa_update(Request $request)
    {
        dd($request->all());
    }
}
