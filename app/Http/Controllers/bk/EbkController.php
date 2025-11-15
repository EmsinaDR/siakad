<?php

// namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers\bk;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\User\Siswa\Detailsiswa;

class EbkController extends Controller
{
    //
    public function index(Request $request)
    {
        //Title to Controller
        $title = 'Data Siswa';
        $arr_ths = [
            'NIS',
            'Nama',
            'Kelas',
            'Wali Kelas',
            'Alamat Siswa'
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Bimbingan Konseling / Data Siswa';
        $titleviewModal = 'Lihat Data Siswa';
        $titleeditModal = 'Edit Data Siswa';
        $titlecreateModal = 'Create Data Siswa';


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        $etapel = Etapel::where('aktiv', 'Y')->first();
        $DataSiswa = Cache::tags(['cache_DataSiswa'])->remember('remember_DataSiswa', now()->addMinute(10), function () use ($etapel){
            return Detailsiswa::with(['kelas', 'Ebkpelanggaran.Ebkkreditpoint'])->whereNotNull('kelas_id')->orderBy('kelas_id')->get();;
        });
        HapusCacheDenganTag('cache_DataSiswa');

        // dd($DataSiswa);
        return view('role.bk.data-siswa', compact('DataSiswa', 'title', 'arr_ths', 'etapels',  'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
}
