<?php

namespace App\Http\Controllers\Tools\Template;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Admin\Identitas;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Tools\Template\PengaturanTemplateSertifikat;

class PengaturanTemplateSertifikatController extends Controller
{
    public function index()
    {
        $title = 'Template Sertifikat';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Tools / Template Sertifikat';
        // $datas = \App\Models\Tools\Template\PengaturanTemplateSertifikat::where('tapel_id', $etapels->id)->get();
        // E:\laragon\www\siakad\resources\views\tools\sertifikat\pengaturan-serifikat.blade.php
        return view('tools.sertifikat.pengaturan-serifikat', compact(
            'title',
            'breadcrumb',
            // 'datas'
        ));
    }
    public function cetakSertifikat(Request $request)
    {
        $Identitas = Identitas::first();
        $Siswa = Detailsiswa::whereIn('id', $request->detailsiswa_id)->get();
        // $kode_sertifikat = $request->tempat_pelaksanaan;
        $kode_sertifikat = $request->background_sertifikat;
        // "29/02/SPT/{2025}"
        $NoSurat = "/" . str_replace(" ", "", $Identitas->namasingkat)  . "/"  . date('m') . "/" . date('Y');
        $datas = [];

        $ttdKepsekPath = public_path('ttd/ttd_kepsek.png');
        $ttdKepsekDataUri = file_exists($ttdKepsekPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($ttdKepsekPath))
            : '';

        $ttdPanitiaPath = public_path('ttd/ttd_panitia.png');
        $ttdPanitiaDataUri = file_exists($ttdPanitiaPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($ttdPanitiaPath))
            : '';
        foreach ($Siswa as $index => $siswa) {
            $datas[] = [
                'judul_sertifikat' => $request->judul,
                'nama' => $siswa->nama_siswa ?? '-',
                'peran' => $request->peran ?? 'Peserta',
                'nama_kegiatana' => $request->nama_kegiatan,
                'tanggal' => Carbon::create($request->tanggal_pelaksanaan)->translatedFormat('l, d F Y'),
                'lokasi' => $request->tempat_pelaksanaan,
                'nomor' => Str::padLeft($index + 1, 3, '0') . $NoSurat,
                'qr_data' => "$request->peran {$request->nama_kegiatan}\n{$siswa->nama_siswa}\nTempat Pelaksanaan : {$request->tempat_pelaksanaan}", //'https://contoh.com/validasi/' . urlencode($siswa->id)
                'background' => public_path("img/template/sertifikat/{$kode_sertifikat}.jpg"),
                'logo_sekolah' => public_path('img/logo.png'),
                'logo_dinas' => public_path('img/logo/kemenag.png'),
                'ttd_kepsek' => $ttdKepsekDataUri,
                'ttd_panitia' => $ttdPanitiaDataUri,
                'nama_kepsek' => $Identitas->namakepala ?? 'Kepala Sekolah',
                'nama_panitia' => 'Fajar Nugraha, S.Kom',
            ];
        }
        $judul = ucwords($request->judul);
        $pdf = Pdf::loadView('Tools.sertifikat.layout-sertifikat', ['datas' => $datas])->setPaper('a4', 'landscape');
        return $pdf->download("{$judul} {$request->nama_kegiatan}.pdf"); // Download
        // return $pdf->stream("semua-sertifikat.pdf"); //Melihat

    }
    public function cetakSemuaSertifikat()
    {
        $Identitas = Identitas::first();
        $Siswa = Detailsiswa::SiswaAktif();

        $datas = [];

        foreach ($Siswa as $siswa) {
            $datas[] = [
                'judul_sertifikat' => 'SERTIFIKAT',
                'nama' => $siswa->nama,
                'peran' => 'Peserta',
                'judul' => 'Pelatihan Desain Edukasi',
                'tanggal' => 'Senin, 14 Juli 2025',
                'lokasi' => 'SMP Cipta IT Banjarharjo',
                'nomor' => '29/02/SPT/2025',
                'qr_data' => 'https://contoh.com/validasi/' . $siswa->id,
                'background' => public_path('img/sertifikat/sertifikat_1.jpg'),
                'logo' => public_path('img/logodev.jpg'),
                'ttd_kepsek' => public_path('img/logodev.jpg'),
                'ttd_panitia' => public_path('img/logodev.jpg'),
                'nama_kepsek' => $Identitas->namakepala,
                'nama_panitia' => 'Fajar Nugraha, S.Kom',
            ];
        }

        $pdf = Pdf::loadView('Tools.sertifikat.semua', compact('datas'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("semua-sertifikat.pdf");
    }

    public function store(Request $request)
    {
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge(['tapel_id' => $etapels->id]);

        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        \App\Models\Tools\Template\PengaturanTemplateSertifikat::create($validator->validated());
        Session::flash('success', 'Data berhasil disimpan');
        return Redirect::back();
    }

    public function update(Request $request, $id)
    {
        $data = \App\Models\Tools\Template\PengaturanTemplateSertifikat::findOrFail($id);

        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data->update($validator->validated());
        Session::flash('success', 'Data berhasil diperbarui');
        return Redirect::back();
    }

    public function destroy($id)
    {
        $data = \App\Models\Tools\Template\PengaturanTemplateSertifikat::findOrFail($id);
        $data->delete();

        Session::flash('success', 'Data berhasil dihapus');
        return Redirect::back();
    }
}
