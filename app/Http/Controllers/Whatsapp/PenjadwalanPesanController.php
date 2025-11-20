<?php

namespace App\Http\Controllers\Whatsapp;

use Exception;
use Carbon\Carbon;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Whatsapp\PenjadwalanPesan;
use App\Models\Whatsapp\WhatsAppSession;
use Illuminate\Support\Facades\Validator;

class PenjadwalanPesanController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Whatsapp Penjadwalan Pesan';
        $breadcrumb = 'Whatsapp / Penjadwalan Pesan';
        $titleviewModal = 'Lihat Whatsapp';
        $titleeditModal = 'Edit Whatsapp';
        $titlecreateModal = 'Buat Whatsapp';
        $arr_ths = [
            'Judul',
            'Tipe Tujuan',
            'Jadwal',
            'Status',

        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $PenjadwalanPesan = Cache::tags(['Cache_PenjadlwalanPesan'])->remember('Remember_PenjadlwalanPesan', now()->addMinutes(10), function () {
            return PenjadwalanPesan::where('status', 'pending')->orderBy('scheduled_at', 'ASC')->get();
        });
        // $PenjadwalanPesan = PenjadwalanPesan::where('status', 'pending')->orderBy('scheduled_at', 'ASC')->get();

        $host = config('app.whatsapp_host', '127.0.0.1');
        $url = "http://{$host}:3000";
        $host = config('app.whatsapp_host', '127.0.0.1');
        $url = "http://{$host}:3000";

        $groups = getGroups(config('whatsappSession.IdWaUtama'));
        $members = [];

        if ($groups['status'] === true) {
            foreach ($groups['groups'] as $group) {
                $groupId = $group['id'];
                $groupName = $group['name'] ?? $group['subject'] ?? 'Nama grup tidak tersedia';

                $members[$groupId] = [
                    'name' => $groupName,
                    'members' => []
                ];

                $response = Http::get("{$url}/group-members/{$groupId}", [
                    'id' => config('whatsappSession.IdWaUtama')
                ]);

                if ($response->successful()) {
                    $members[$groupId]['members'] = $response->json() ?? [];
                }
            }
        } else {
            // echo "Gagal mendapatkan data grup.";
        }

        $whatsappId = WhatsAppSession::get();

        // Kalau mau cek hasilnya:

        // dd($members);

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.whatsapp.penjadwalanpesan.penjadwalan-pesan', compact(
            'title',
            'arr_ths',
            'PenjadwalanPesan',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'groups',
            'members',
            'whatsappId',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Whatsapp';
        $breadcrumb = 'Create Whatsapp / Penjadwalan Pesan';

        // Breadcrumb (jika diperlukan)

        return view('role.whatsapp.penjadwalanpesan.penjadwalan-pesan-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // 1. Ambil Etapel aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge(['tapel_id' => $etapels->id]);
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $gambar = $request->file('gambar');

            $path = base_path('whatsapp/uploads');
            if (!file_exists($path)) {
                mkdir($path, 0775, true); // Buat folder kalau belum ada
            }

            $namaFile = time() . '-' . $gambar->getClientOriginalName();
            $gambar->move($path, $namaFile);

            // Kalau mau nyimpan pathnya ke database:
            // $simpan->gambar_path = 'whatsapp/uploads/' . $namaFile;
        } else {
            // Handle kalau tidak ada file
            // return redirect()->back()->with('error', 'Tidak ada file yang diupload');
        }

        if ($request->tipe_tujuan === 'nomor') {
            $request->merge(
                [
                    'tujuan_nomor' => $request->tujuan,
                    'tujuan' => null,
                ]
            );
        } elseif ($request->tipe_tujuan === 'guru') {
            $nomors = Detailguru::pluck('no_hp')->filter()->toArray();
            $request->merge(
                [
                    'tujuan_nomor' => null,
                    'tujuan' => json_encode($nomors)
                ]
            );
        } elseif ($request->tipe_tujuan === 'kelas') {
            $request->merge(
                [
                    'tujuan_nomor' => null,
                    'tujuan' => json_encode($request->tujuan_kelas)
                ]
            );
        } elseif ($request->tipe_tujuan === 'tingkat') {
            $request->merge(
                [
                    'tujuan_nomor' => null,
                    'tujuan' => json_encode($request->tujuan_tingkat)
                ]
            );
        } elseif ($request->tipe_tujuan === 'seluruh siswa') {
            $request->merge(
                [
                    'tujuan_nomor' => null,
                    'tujuan' => null
                ]
            );
        } elseif ($request->tipe_tujuan === 'siswa') {
            $request->merge(
                [
                    'tujuan_nomor' => null,
                    'tujuan' => json_encode($request->tujuan_siswa)
                ]
            );
        } else {
            $request->merge(['tujuan' => json_encode($request->siswa)]);
        }
        // dd($request->all(), $request->tipe_tujuan);

        // 2. Gabungkan tanggal dan jam jadi scheduled_at (Y-m-d H:i:s)
        $tanggal = $request->input('tanggal');
        $jam = $request->input('jam');
        try {
            $scheduled_at = Carbon::createFromFormat('Y-m-d H:i', "$tanggal $jam");
            $request->merge(['scheduled_at' => $scheduled_at->format('Y-m-d H:i:s')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['scheduled_at' => 'Format tanggal/jam tidak valid'])->withInput();
        }
        $pesan = $request->pesan;
        $pesan = preg_replace('/>\s+</', '><', $request->pesan);

        // dd($request->all(), $request->tujuan);
        $dataInsert = [
            // 'tapel_id' => $request->tapel_id,
            'judul' => $request->judul,
            'tipe_tujuan' => $request->tipe_tujuan,
            'tujuan' => $request->tujuan,
            'tujuan_nomor' => $request->tujuan_nomor,
            'pesan' => $pesan,
            'gambar' => $namaFile,
            'scheduled_at' => $request->scheduled_at,
            'status' => 'pending',
        ];

        // dd($rules,  $dataInsert, $request->tujuan_nomor, $request->tipe_tujuan);
        // 6. Simpan data jadwal hanya sekali!
        PenjadwalanPesan::create($dataInsert);

        // 7. Hapus cache & redirect
        HapusCacheDenganTag('PenjadlwalanPesan');
        Session::flash('success', 'Jadwal berhasil disimpan');
        return redirect()->back();
    }



    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Whatsapp';
        $breadcrumb = 'Lihat Whatsapp / Penjadwalan Pesan';
        $data = PenjadwalanPesan::findOrFail($id);

        return view('role.whatsapp.penjadwalanpesan.penjadwalan-pesan-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Whatsapp';
        $breadcrumb = 'xxxxxxxxxxxx / Whatsapp / Edit';
        $data = PenjadwalanPesan::findOrFail($id);


        return view('role.whatsapp.penjadwalanpesan.penjadwalan-pesan-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = PenjadwalanPesan::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'tapel_id' => 'required|numeric|min:1|max:100',
            'jam' => 'required|string|min:3|max:255',
            'tanggal' => 'required|string|min:3|max:255',
            'no_hp' => 'required|string|min:3|max:255',
            'scheduled_at' => 'required|string|min:3|max:255',
            'response' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data yang ditemukan berdasarkan hasil validasi
        $data->update($validator->validated());


        HapusCacheDenganTag('PenjadlwalanPesan');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = PenjadwalanPesan::findOrFail($id);

        // Menghapus data
        $data->delete();

        HapusCacheDenganTag('PenjadlwalanPesan');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
