<?php

namespace App\Http\Controllers\Walkes;

use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class JadwalPiketController extends Controller
{
    //
    public function index(Request $request)
    {
        //dd($request->all());
        //Title to Controller
        $title = 'Jadwal Piket';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad'
        ];
        $breadcrumb = 'Menu_breadcume / sub_Menu_breadcume';
        $titleviewModal = 'Lihat Data Jadwal Piket';
        $titleeditModal = 'Edit Data Jadwal Piket';
        $titlecreateModal = 'Create Data Jadwal Piket';
        $datas = Detailsiswa::where('kelas_id', $request->kelas_id)->geT();

        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.walkes.jadwal-piket', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }
    public function printDataJadwalPiket($id)
    // public function printDataJadwalPiket($id)
    {
        $data = Detailsiswa::where('kelas_id', $id)->get();
        $pdf = Pdf::loadView('role.walkes.jadwal-piket-cetak', compact('data'));

        // Bisa menggunakan stream() untuk menampilkan di browser atau download()
        // return $pdf->download("data_jadwal_piket_{$id}.pdf");
        return $pdf->download("data_jadwal_piket_{$id}.pdf");
    }
    public function show($id)
    // public function printDataJadwalPiket($id)
    {
        $data = Detailsiswa::where('kelas_id', $id)->get();
        $pdf = Pdf::loadView('role.walkes.jadwal-piket', compact('data'));

        // Bisa menggunakan stream() untuk menampilkan di browser atau download()
        return $pdf->download("data_jadwal_piket_{$id}.pdf");
        // return view('role.walkes.jadwal-piket-cetak', compact('data'));
    }

}
