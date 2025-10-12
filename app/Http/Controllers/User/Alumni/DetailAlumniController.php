<?php

namespace App\Http\Controllers\User\Alumni;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\User\Siswa\Detailsiswa;

class DetailAlumniController extends Controller
{
    //
    public function index(User $user)
    {

        $title = 'Data Alumni';
        $arr_ths = [
            'Tahun Lulus',
            'Nama',
            'NIS',
            'Jenis Kelamin'
        ];
        $titleviewModal = 'Lihat Data Alumni';
        $titleeditModal = 'Edit Data Alumni';
        $titlecreateModal = 'Create Data Alumni';
        $alumnis = Cache::tags(['chace_alumnis'])->remember('remember_alumnis', now()->addHours(2), function () {
            return Detailsiswa::whereNotNull('tahun_lulus')->get();
        });
        $breadcrumb = "Data User / Data Alumni";

        $alumni_data = Cache::remember('alumni_data', now()->addHour(), function () {
            return User::with('UsersDetailsiswa')->where('posisi', 'Alumni')->get();
        });



        return view('admin.user.alumni', compact('title', 'alumni_data', 'breadcrumb', 'arr_ths', 'titleviewModal', 'titleeditModal', 'titlecreateModal', 'alumnis'));
    }
    public function destroy($id)
    {
        //User
        // dd(id);
        // dd($request->all());
        $VarUser = User::findOrFail($id);
        // dd($id);
        $VarUser->delete();
        HapusCacheDenganTag('alumni_data');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahapus Berhasil dihapus dari databse');
    }

    // public function indexx(User $user)
    // {

    //     $title = 'Data Alumni';
    //     $arr_ths = [
    //         'Tahun Lulus',
    //         'Nama',
    //         'NIS',
    //         'Jenis Kelamin'
    //     ];
    //     $titleviewModal = 'Lihat Data Alumni';
    //     $titleeditModal = 'Edit Data Alumni';
    //     $titlecreateModal = 'Create Data Alumni';
    //     $alumnis = Detailsiswa::whereNotNull('tahun_lulus')->get();
    //     $breadcrumb = "Data User / Data Alumni";

    //     $datas = Cache::tags(['namatag'])->remember('namacache', now()->addHour(), function () {
    //         return User::with('UsersDetailsiswa')->where('posisi', 'Alumni')->get();
    //     });


    //     return view('admin.user.alumni', compact('title', 'datas', 'breadcrumb', 'arr_ths', 'titleviewModal', 'titleeditModal', 'titlecreateModal', 'alumnis'));
    // }
}
