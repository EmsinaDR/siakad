<?php

namespace App\Http\Controllers\WakaKesiswaan\PPDB;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKesiswaan\PPDB\PengumumanPPDB;
use Exception;

class PengumumanPPDBController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Title to Controller
        $title = 'Pengumuman PPDB';
        $arr_ths = [
            'Jalur',
            'Nomor Peserta',
            'NIS',
            'Status Penerimaan',
            'Nama Peserta',
        ];
        $breadcrumb = 'Pantinia PPDB / Pengumuman PPDB';
        $titleviewModal = 'Lihat Data Pengumuman Peserta';
        $titleeditModal = 'Edit Data Pengumuman Peserta';
        $titlecreateModal = 'Create Data Pengumuman Peserta';
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Meng-cache hasil query selama 10 menit
        $dataPendaftaran = Cache::tags(['cache_dataPendaftaran'])->remember(
            'remember_dataPendaftaran',
            now()->addMinutes(10),
            function () use ($etapels) {
                return PengumumanPPDB::with('tapel')->where('tapel_id', $etapels->id)->get();
            }
        );

        // Mengelompokkan data berdasarkan tapel_id dan menghitung jumlah siswa per gender
        $chartData = $dataPendaftaran->groupBy('tapel_id')->map(function ($data, $tapel_id) {
            return [
                'tapel' => Etapel::find($tapel_id)->tapel ?? 'Unknown',
                'Laki-laki' => $data->where('jenis_kelamin', 1)->count(),
                'Perempuan' => $data->where('jenis_kelamin', 2)->count(),
            ];
        })->values(); // 🔥 Ubah jadi array numerik agar JS lebih mudah mengolah
        $status = ['Diterima', 'Ditolak', 'Menunggu'];
        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.ppdb.pengumuman-ppdb', compact(
            'dataPendaftaran',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'chartData',
            'status',
        ));
    }
    public function show()
    {
        //
        //Title to Controller
        $title = 'Pengumuman PPDB';
        $arr_ths = [
            'Jalur',
            'Nomo Peserta',
            'Status Penerimaan',
            'Nama Peserta',
        ];
        $breadcrumb = 'Pantinia PPDB / Pengumuman PPDB';
        $titleviewModal = 'Lihat Data Pengumuman Peserta';
        $titleeditModal = 'Edit Data Pengumuman Peserta';
        $titlecreateModal = 'Create Data Pengumuman Peserta';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        dd(request()->segment(3));
        $datas = PengumumanPPDB::where('tapel_id', request()->segment(3))->get();

        $chartData = $datas->groupBy('tapel_id')->map(function ($data, $tapel_id) {
            return [
                'tapel' => Etapel::find($tapel_id)->tapel ?? 'Unknown',
                'Laki-laki' => $data->where('jenis_kelamin', 1)->count(),
                'Perempuan' => $data->where('jenis_kelamin', 2)->count(),
            ];
        })->values(); // 🔥 Mengubah menjadi array numerik agar bisa digunakan di JavaScript


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.ppdb.pengumuman-ppdb-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'chartData',
        ));
        //php artisan make:view role.ppdb.pengumuman-ppdb-single
    }

    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $kelas = Ekelas::where('kelas', $request->kelas)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
            'kelas_id' => $kelas->id,
            'tingkat_id' => $kelas->tingkat_id,
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
        // Menyimpan data menggunakan mass assignment
        // Create : Buat
        // Update : Memperbaharui
        // Menyimpan data menggunakan mass assignment
        PengumumanPPDB::create($validator->validated());
        HapusCacheDenganTag('dataPendaftaran');

        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, PengumumanPPDB $pengumumanPPDB)
    {
        //

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
        // Menyimpan data menggunakan mass assignment
        // Create : Buat
        // Update : Memperbaharui
        // Menyimpan data menggunakan mass assignment
        $varmodel = PengumumanPPDB::find($id); // Pastikan $id didefinisikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($validator->validated());
            HapusCacheDenganTag('dataPendaftaran');

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
        //PengumumanPPDB
        // dd(id);
        // dd(request->all());
        $data = PengumumanPPDB::findOrFail($id);
        $data->delete();
        HapusCacheDenganTag('dataPendaftaran');

        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
    public function PengumumanPPDBBulk(Request $request)
    {
        // dd($request->all());
        // kelas id jika disediakan
        try {
            $kelas_id = $request->kelas_id;
            if (!$kelas_id) {
                PengumumanPPDB::whereIn('id', $request->id)->update([
                    'status_penerimaan' => $request->status_penerimaan
                ]);
            } else {
                PengumumanPPDB::whereIn('id', $request->id)->update([
                    'status_penerimaan' => $request->status_penerimaan,
                    'kelas_id' => $request->kelas_id
                ]);
            }
            Session::flash('success', 'Data Status berhasil dirubah ' . $request->status_penerimaan);
            return Redirect::back();
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }
}
