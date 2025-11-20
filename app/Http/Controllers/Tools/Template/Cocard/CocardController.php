<?php

namespace App\Http\Controllers\Tools\Template\Cocard;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use App\Models\Admin\Identitas;
use App\Models\Tools\Template\Cocard\Cocard;
use App\Models\User\Guru\Detailguru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;

class CocardController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Tools Template cocard';
        $breadcrumb = 'Tools Template cocard / Cocard';
        $titleviewModal = 'Lihat Tools Template cocard';
        $titleeditModal = 'Edit Tools Template cocard';
        $titlecreateModal = 'Buat Tools Template cocard';
        $arr_ths = [
            'Nama',
            'Kode',
            'Keterangan',

        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $Cocard = Cache::tags(['Cocard_Chace'])->remember(
            'Cocard_Remember',
            now()->addHours(2),
            fn() => Cocard::get()
        );

        $Cocard = Cocard::get();
        function generatePersonalizedSVG($data)
        {
            $templatePath = public_path('img/template/cocard/' . $data->kode . '.svg');
            $svg = file_get_contents($templatePath);

            // Ganti variabel dalam SVG
            $svg = str_replace('{nama}', 'Dany Rosepta', $svg);
            // $svg = str_replace('{kode}', $data->kode, $svg);
            // $svg = str_replace('{kelas}', $data->kelas, $svg);
            $svg = str_replace('{keterangan}', $data->keterangan, $svg);

            // Simpan hasil ke folder storage/public/tmp/
            $outputPath = storage_path('app/public/tmp/cocard-' . $data->kode . '.svg');
            file_put_contents($outputPath, $svg);

            // Kembalikan path untuk <img>
            return asset('storage/tmp/cocard-' . $data->kode . '.svg');
        }

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.tools.template.cocard.cocard.cocard', compact(
            'title',
            'title',
            'arr_ths',
            'Cocard',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
    }
    public function GenerateCocard(Request $request)
    {
        $svgUrls = [];
        $Identitas = Identitas::first();

        foreach ($request->detailguru_id as $id) {
            $guru = Detailguru::find($id);
            $namaTitla = ucwords(strtolower($guru->nama_guru));
            $nama = singkatkan_nama($namaTitla).','. $guru->gelar;
            // dd($namaTitla, $nama);

            if (!$guru) continue;
            $svg = render_svg_base64($request->kode, [
                'kode'        => $request->kode,
                'line2'        => 'Kelas',
                'posisi'       => strtoupper($request->peran) ?? 'PESERTA',
                'nama'         => $nama ?? 'Tanpa Nama',
                'nip'          => $guru->nip ?? '-',
                'namasekolah'  => strtoupper($Identitas->namasek), // Atau dari DB
                'namakegiatan' => $request->judul ?? 'KEGIATAN',
                'foto'         => 'img/template/cocard/property/blank.png',
                'logosekolah'  => 'img/logo.png',
                'logodinas'    => 'img/logo/kemenag.png',
                'tapel'        => date('Y') . '/' . (date('Y') + 1),
            ]);

            $svgUrls[] = [
                'nama' => ucwords($guru->nama_guru) ?? 'Tanpa Nama',
                'url'  => $svg,
            ];
        }
        return view('role.tools.template.cocard.cocard.cocard-preview', compact('svgUrls'));
    }




    public function GenerateCocardx(Request $request)
    {
        dd($request->all());
        foreach ($request->detailguru_id as $id) {
            $guru = Detailguru::find($id);

            if (!$guru) continue; // Skip kalau nggak ketemu

            // Siapkan data untuk helper
            $data = (object)[
                'kode'       => $guru->kode, // pastikan ada properti ini
                'nama'       => $guru->nama_guru, // ganti sesuai field model DetailGuru
                'nip' => $guru->peran ?? '-',
            ];

            generate_personalized_svg($data);
        }

        return back()->with('success', 'Cocard berhasil dibuat untuk semua panitia.');
    }
    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Tools Template cocard';
        $breadcrumb = 'Create Tools Template cocard / Cocard';

        // Breadcrumb (jika diperlukan)

        return view('role.tools.template.cocard.cocard.cocard-create', compact(
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
            'nama' => 'required|string|min:3|max:255',
            'kode' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        Cocard::create($validator->validated());

        HapusCacheDenganTag('Cocard_Chace');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');
        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Tools Template cocard';
        $breadcrumb = 'Lihat Tools Template cocard / Cocard';
        $data = Cocard::findOrFail($id);

        return view('role.tools.template.cocard.cocard.cocard-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Tools Template cocard';
        $breadcrumb = 'xxxxxxxxxxxx / Tools Template cocard / Edit';
        $data = Cocard::findOrFail($id);


        return view('role.tools.template.cocard.cocard.cocard-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = Cocard::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'tapel_id' => 'required|numeric|min:1|max:100',
            'nama' => 'required|string|min:3|max:255',
            'kode' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data yang ditemukan berdasarkan hasil validasi
        $data->update($validator->validated());


        HapusCacheDenganTag('Cocard_Chace');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = Cocard::findOrFail($id);

        // Menghapus data
        $data->delete();

        HapusCacheDenganTag('Cocard_Chace');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
