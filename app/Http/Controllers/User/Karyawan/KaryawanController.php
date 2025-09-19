<?php

namespace App\Http\Controllers\User\Karyawan;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Cache;
use App\Models\User\Karyawan\Karyawan;
use Illuminate\Support\Facades\Redirect;

class KaryawanController extends Controller
{
    public function index(User $user)
    {

        // $datas = User::where('posisi', 'Guru')->with('Detailgurus')->get();
        $title = 'Data Karyawan';
        $arr_ths = [
            'Nama',
            'Status',
            'Pendidikan',
            'Jenis Kelamin'
        ];
        $breadcrumb = "Admin Data / Data Karyawan";
        $datar = User::find(4);
        $datas = User::with('UsersDetailgurus')->where('posisi', 'Karyawan')->get(); //Relasi di sisipi dengan where
        $userKaryawan = Cache::tags(['chace_userKaryawan'])->remember('remember_userKaryawan', now()->addHours(2), function () {
            return User::with('UsersDetailgurus')->where('posisi', 'Karyawan')->get();
        });

        return view('admin.user.karyawan', compact('title', 'userKaryawan', 'breadcrumb', 'arr_ths'));
    }
    public function update($id, Request $request)
    {
        //dd($request->all());
        $data = $request->except(['_token', '_method']);
        $data = Detailguru::findOrFail($id);
        $data->kelas_id = $request->kelas_id;
        $data->update();
        HapusCacheDenganTag('chace_userKaryawan');
        return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  berhasil diperbaharui');;
    }
    public function destroy($id)
    {
        $VarDetailguru = User::findOrFail($id);
        $VarDetailguru->delete();
        HapusCacheDenganTag('chace_userKaryawan');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
    }
}
