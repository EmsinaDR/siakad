<?php

namespace App\Http\Controllers\Absensi;

use App\Models\Absensi\EabsenGuru;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;

class EabsenGuruController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Absensi';
        $breadcrumb = 'Absensi / Eabsen Guru';
        $titleviewModal = 'Lihat Absensi';
        $titleeditModal = 'Edit Absensi';
        $titlecreateModal = 'Buat Absensi';
        $arr_ths = [
            'Tapel Id',
            'Ijin Id',
            'Detailguru Id',
            'Waktu Absen',
            'Whatsapp Respon',
            'Jenis Absen',
            'Telat',
            'Semester',
            'Absen',
            'Keterangan',

        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $EabsenGuru = Cache::tags(['EabsenGuru_Chace'])->remember(
            'EabsenGuru_Remember',
            now()->addHours(2),
            fn() => EabsenGuru::where('tapel_id', $etapels->id)->get()
        );


        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.absensi.eabsenguru.eabsen-guru', compact(
            'title',
            'title',
            'arr_ths',
            'EabsenGuru',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
    }
    public function IndexGuruAjax()
    {

        $absensiGuru = Cache::tags(['cache_absensi_guru'])->remember('remember_absensi_guru', now()->addHours(2), function () {
            return EabsenGuru::orderByDesc('created_at')->get();
        });
        $absensiGuru = EabsenGuru::orderByDesc('created_at')->get();
        HapusCacheDenganTag('cache_absensi');
        return view('role.absensi.absensi-guru-ajax', compact('absensiGuru'));
    }
    public function storeGuruAjax(Request $request)
    {
        $request->validate(['kode_guru' => 'required']);
        $guru = Detailguru::where('kode_guru', $request->kode_guru)->first();

        if (!$guru) {
            return response()->json([
                'success' => false,
                'message' => '❌ Kode Guru tidak ditemukan',
            ]);
        }

        $jamSekarang     = now();
        $jamBatasMasuk   = '07:05';
        $jamBatasPulang  = '13:00'; // bisa juga ambil dari setting database
        $jenisAbsen      = $jamSekarang->format('H:i') <= $jamBatasMasuk ? 'masuk' : 'pulang';

        $sudahAbsen = EabsenGuru::whereDate('created_at', today())
            ->where('detailguru_id', $guru->id)
            ->where('jenis_absen', $jenisAbsen)
            ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'error' => false,
                'message' => "⚠️ Sudah absen $jenisAbsen hari ini!",
            ]);
        }

        $telatMenit = 0;
        $pulangCepat = 0;
        $pulangTelat = 0;

        if ($jenisAbsen === 'masuk') {
            $jamBatas = Carbon::createFromTimeString($jamBatasMasuk);
            if ($jamSekarang->greaterThan($jamBatas)) {
                $telatMenit = $jamBatas->diffInMinutes($jamSekarang);
            }
        } else {
            $jamBatas = Carbon::createFromTimeString($jamBatasPulang);
            if ($jamSekarang->lessThan($jamBatas)) {
                $pulangCepat = $jamSekarang->diffInMinutes($jamBatas);
            } elseif ($jamSekarang->greaterThan($jamBatas)) {
                $pulangTelat = $jamBatas->diffInMinutes($jamSekarang);
            }
        }

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $data = [
            'telat' => $telatMenit ?? '0',
            'waktu' => $jenisAbsen === 'masuk' ? 'Pagi' : 'Siang',
        ];
        $absen = EabsenGuru::create([
            'detailguru_id' => $guru->id,
            'tapel_id'       => $etapels->id ?? null,
            'semester'       => $etapels->semester ?? null,
            'absen'          => 'hadir',
            'jenis_absen'    => $jenisAbsen,
            'waktu_absen'    => $jamSekarang,
            'telat'          => $telatMenit,
            // 'pulang_cepat'   => $pulangCepat,
            // 'pulang_telat'   => $pulangTelat,
        ]);
        // kirimPesanAbsensi($guru->id, $data);
        HapusCacheDenganTag('chace_AbsensiHaraIni');
        HapusCacheDenganTag('chacprosesabsen');
        return response()->json([
            'success' => true,
            'message' => "✅ Absen $jenisAbsen berhasil!",
            'data' => [
                'kode_guru' => $guru->kode_guru,
                'nama_guru' => $guru->nama_guru,
                'waktu' => $absen->waktu_absen->format('H:i:s'),
                'jenis' => $jenisAbsen,
                'telat' => $telatMenit ? "$telatMenit menit" : 'Tepat waktu',
                'pulang_cepat' => $pulangCepat ? "$pulangCepat menit" : null,
                'pulang_telat' => $pulangTelat ? "$pulangTelat menit" : null,
            ],
        ]);
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Absensi';
        $breadcrumb = 'Create Absensi / Eabsen Guru';

        // Breadcrumb (jika diperlukan)

        return view('role.absensi.eabsenguru.eabsen-guru-create', compact(
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
            'tapel_id' => 'required|string|min:3|max:255',
            'ijin_id' => 'required|string|min:3|max:255',
            'detailguru_id' => 'required|string|min:3|max:255',
            'waktu_absen' => 'required|string|min:3|max:255',
            'whatsapp_respon' => 'required|string|min:3|max:255',
            'jenis_absen' => 'required|string|min:3|max:255',
            'telat' => 'required|string|min:3|max:255',
            'semester' => 'required|string|min:3|max:255',
            'absen' => 'required|string|min:3|max:255',
            'keterangan' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        EabsenGuru::create($validator->validated());

        HapusCacheDenganTag('EabsenGuru_Chace');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');
        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Absensi';
        $breadcrumb = 'Lihat Absensi / Eabsen Guru';
        $data = EabsenGuru::findOrFail($id);

        return view('role.absensi.eabsenguru.eabsen-guru-single', compact(
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
        $data = EabsenGuru::findOrFail($id);


        return view('role.absensi.eabsenguru.eabsen-guru-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = EabsenGuru::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'tapel_id' => 'required|numeric|min:1|max:100',
            'tapel_id' => 'required|string|min:3|max:255',
            'ijin_id' => 'required|string|min:3|max:255',
            'detailguru_id' => 'required|string|min:3|max:255',
            'waktu_absen' => 'required|string|min:3|max:255',
            'whatsapp_respon' => 'required|string|min:3|max:255',
            'jenis_absen' => 'required|string|min:3|max:255',
            'telat' => 'required|string|min:3|max:255',
            'semester' => 'required|string|min:3|max:255',
            'absen' => 'required|string|min:3|max:255',
            'keterangan' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data yang ditemukan berdasarkan hasil validasi
        $data->update($validator->validated());


        HapusCacheDenganTag('EabsenGuru_Chace');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = EabsenGuru::findOrFail($id);

        // Menghapus data
        $data->delete();

        HapusCacheDenganTag('EabsenGuru_Chace');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
