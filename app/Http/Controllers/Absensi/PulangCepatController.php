<?php

namespace App\Http\Controllers\Absensi;

use App\Models\Absensi\PulangCepat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use App\Models\Absensi\Eabsen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;

class PulangCepatController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Absensi';
        $breadcrumb = 'Absensi / Pulang Cepat';
        $titleviewModal = 'Lihat Absensi';
        $titleeditModal = 'Edit Absensi';
        $titlecreateModal = 'Buat Absensi';
        $arr_ths = [
            'Fillable',

        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        // addHours addMinutes
        $PulangCepat = Cache::tags(['Chace_PulangCepat'])->remember(
            'Remember_PulangCepat',
            now()->addMinutes(30),
            fn() => PulangCepat::where('tapel_id', $etapels->id)->get()
        );


        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.absensi.pulangcepat.pulang-cepat', compact(
            'title',
            'title',
            'arr_ths',
            'PulangCepat',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Absensi';
        $breadcrumb = 'Create Absensi / Pulang Cepat';

        // Breadcrumb (jika diperlukan)

        return view('role.absensi.pulangcepat.pulang-cepat-create', compact(
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
            'fillable' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        PulangCepat::create($validator->validated());

        HapusCacheDenganTag('Chace_PulangCepat');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');
        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Absensi';
        $breadcrumb = 'Lihat Absensi / Pulang Cepat';
        $data = PulangCepat::findOrFail($id);

        return view('role.absensi.pulangcepat.pulang-cepat-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Absensi';
        $breadcrumb = 'xxxxxxxxxxxx / Absensi / Edit';
        $data = PulangCepat::findOrFail($id);


        return view('role.absensi.pulangcepat.pulang-cepat-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = PulangCepat::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'tapel_id' => 'required|numeric|min:1|max:100',
            'fillable' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data yang ditemukan berdasarkan hasil validasi
        $data->update($validator->validated());


        HapusCacheDenganTag('Chace_PulangCepat');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = PulangCepat::findOrFail($id);

        // Menghapus data
        $data->delete();

        HapusCacheDenganTag('Chace_PulangCepat');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
    public function PulangCepat()
    {
        $Tapel = Etapel::where('aktiv', 'Y')->first();
        $AbsensiHariIni = Eabsen::whereDate('created_at', Carbon::today())
            ->where('tapel_id', $Tapel->id)
            ->whereIn('absen', ['hadir', 'ijin', 'sakit'])
            ->get();
        $IdSiswa = $AbsensiHariIni->pluck('detailsiswa_id')->toArray();

        $jenisAbsen = 'pulang';
        foreach ($AbsensiHariIni as $ids) {
            $data = [
                'detailsiswa_id' => $ids->detailsiswa_id,
                'tapel_id'       => $Tapel->id,
                'semester'       => $etapels->semester ?? '',
                'kelas_id'       => $datasiswa->kelas_id ?? null,
                'absen'          => $ids->absen,
                'jenis_absen'    => 'pulang',
                'waktu_absen'    => now(),
                'telat'          => 0,
                'created_at'     => now(),
                'updated_at'     => now(),
                'keterangan'     => now(),
            ];
            Eabsen::create($data);
        }
    }
}
