<?php

namespace App\Http\Controllers\Program\BTQ;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\Program\BTQ\PesertaBTQ;
use App\Models\Program\BTQ\RiwayatBTQ;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class RiwayatBTQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    RiwayatBTQ
    $riwayatbtq
    role.program.btq
    role.program.btq.riwayat-btq
    role.program.btq.blade_show
    Index = Data Pembina BTQ
    Breadcume Index = 'Pembina BTQ / Data Riwayat BTQ';
    Single = Data Riwayat BTQ
    php artisan make:view role.program.btq.riwayat-btq
    php artisan make:view role.program.btq.riwayat-btq-single
    php artisan make:seed RiwayatBTQSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Pembina BTQ';
        $arr_ths = [
            'Nama Siswa',
            'Kelas',
            'Pembimbing',
            'Halaman',
        ];
        $breadcrumb = 'Pembina BTQ / Data Riwayat BTQ';
        $titleviewModal = 'Lihat Data Pembina BTQ';
        $titleeditModal = 'Edit Data Pembina BTQ';
        $titlecreateModal = 'Create Data Pembina BTQ';
        $datas = RiwayatBTQ::get();
        $datas = RiwayatBTQ::join('detailsiswas', 'detailsiswas.id', '=', 'btq_riwayat.detailsiswa_id')
            ->with('SiswaOne', 'kelas', 'Guru')
            ->where('btq_riwayat.pembimbing_id', Auth::user()->id)
            ->whereRaw('btq_riwayat.id IN (
        SELECT MAX(id) FROM btq_riwayat GROUP BY detailsiswa_id
    )')
            ->orderBy('detailsiswas.kelas_id') // Urutkan berdasarkan kelas
            ->orderBy('detailsiswas.nama_siswa') // Urutkan berdasarkan nama
            ->select('btq_riwayat.*')
            ->get();



        $DataSiswas = PesertaBTQ::where('pembimbing_id', Auth::user()->id)->get();
        $Pembimbings = Detailguru::orderBy('nama_guru')->get();




        return view('role.program.btq.riwayat-btq', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DataSiswas',
            'Pembimbings',
        ));
    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Riwayat BTQ';
        $arr_ths = [
            'Nama Siswa',
            'Kelas',
            'Pembimbing',
            'Halaman',
        ];
        $breadcrumb = 'Pembina BTQ / Data Riwayat BTQ';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = RiwayatBTQ::where('btq_riwayat.pembimbing_id', Auth::user()->id)
            ->where('detailsiswa_id', request()->segment(4))
            ->get();


        $DataSiswas = PesertaBTQ::orderBy('kelas_id')->orderBy('nama_siswa')->get();
        $Pembimbings = Detailguru::orderBy('nama_guru')->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.btq.riwayat-btq-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'DataSiswas',
            'Pembimbings',
        ));
        //php artisan make:view role.program.btq.riwayat-btq-single
    }

    public function store(Request $request)
    {
        //
        // dd($request->all());
        // Ambil data tapel yang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        if (!$etapels) {
            return redirect()->back()->with('error', 'Data tahun pelajaran tidak ditemukan.');
        }

        // Tambahkan data ke request
        $request->merge([
            'tapel_id' => $etapels->id,
            'pembimbing_id' => Auth::user()->id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'detailsiswa_id' => 'nullable|exists:detailsiswas,id',
            'pembimbing_id' => 'nullable|exists:users,id', // Perbaikan di sini
            'halaman' => 'nullable|array', // Pastikan halaman adalah array
            'halaman.*' => 'string|max:255', // Setiap elemen dalam array harus string
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan data
        $data = RiwayatBTQ::create([
            'detailsiswa_id' => $request->detailsiswa_id,
            'pembimbing_id' => $request->pembimbing_id,
            'halaman' => json_encode($request->halaman, true), // Pastikan halaman disimpan sebagai JSON
            'keterangan' => $request->keterangan,
        ]);
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, RiwayatBTQ $riwayatbtq)
    {
        //

        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        if (!$etapels) {
            return redirect()->back()->with('error', 'Data tahun pelajaran tidak ditemukan.');
        }

        // Tambahkan data ke request
        $request->merge([
            'tapel_id' => $etapels->id,
            'pembimbing_id' => Auth::user()->id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'halaman' => 'nullable|array', // Pastikan halaman adalah array
            'halaman.*' => 'string|max:255', // Setiap elemen dalam array harus string
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Cari data yang akan diupdate
        $data = RiwayatBTQ::find($id);
        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Update data
        $data->update([
            'halaman' => json_encode($request->halaman ?? []), // Pastikan selalu dalam JSON
            'keterangan' => $request->keterangan,
        ]);

        Session::flash('success', 'Data Berhasil Diperbarui');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //RiwayatBTQ
        // dd(id);
        // dd(request->all());
        $data = RiwayatBTQ::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
