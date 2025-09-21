<?php

namespace App\Http\Controllers\Tools\KirikdanSaran;

use App\Models\Tools\KirikdanSaran\KritikSaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;

class KritikSaranController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Tools KirikdanSaran';
        $breadcrumb = 'Tools KirikdanSaran / Kritik Saran';
        $titleviewModal = 'Lihat Tools KirikdanSaran';
        $titleeditModal = 'Edit Tools KirikdanSaran';
        $titlecreateModal = 'Buat Tools KirikdanSaran';
        $arr_ths = [
            'Detailsiswa Id',
            'Detailguru Id',
            'Nohp',
            'Bidang',
            'Kritik',
            'Saran',

        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        // addHours addMinutes
        $KritikSaran = Cache::tags(['Chace_KritikSaran'])->remember(
            'Remember_KritikSaran',
            now()->addMinutes(30),
            fn() => KritikSaran::where('tapel_id', $etapels->id)->get()
        );


        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.tools.kirikdansaran.kritiksaran.kritik-saran', compact(
            'title',
            'title',
            'arr_ths',
            'KritikSaran',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Tools KirikdanSaran';
        $breadcrumb = 'Create Tools KirikdanSaran / Kritik Saran';

        // Breadcrumb (jika diperlukan)

        return view('role.tools.kirikdansaran.kritiksaran.kritik-saran-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {
        // Mendapatkan data Etapel yang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge(['tapel_id' => $etapels->id]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'tapel_id' => 'required|numeric|min:1|max:100',
            'detailsiswa_id' => 'required|integer',
            'detailguru_id' => 'required|integer',
            'nohp' => 'required|string|min:3|max:255',
            'bidang' => 'required|string|min:3|max:255',
            'kritik' => 'required|string|min:3|max:255',
            'saran' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        KritikSaran::create($validator->validated());

        HapusCacheDenganTag('Chace_KritikSaran');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');
        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Tools KirikdanSaran';
        $breadcrumb = 'Lihat Tools KirikdanSaran / Kritik Saran';
        $data = KritikSaran::findOrFail($id);

        return view('role.tools.kirikdansaran.kritiksaran.kritik-saran-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Tools KirikdanSaran';
        $breadcrumb = 'xxxxxxxxxxxx / Tools KirikdanSaran / Edit';
        $data = KritikSaran::findOrFail($id);


        return view('role.tools.kirikdansaran.kritiksaran.kritik-saran-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = KritikSaran::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'tapel_id' => 'required|numeric|min:1|max:100',
            'detailsiswa_id' => 'required|integer',
            'detailguru_id' => 'required|integer',
            'nohp' => 'required|string|min:3|max:255',
            'bidang' => 'required|string|min:3|max:255',
            'kritik' => 'required|string|min:3|max:255',
            'saran' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data yang ditemukan berdasarkan hasil validasi
        $data->update($validator->validated());


        HapusCacheDenganTag('Chace_KritikSaran');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = KritikSaran::findOrFail($id);

        // Menghapus data
        $data->delete();

        HapusCacheDenganTag('Chace_KritikSaran');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
