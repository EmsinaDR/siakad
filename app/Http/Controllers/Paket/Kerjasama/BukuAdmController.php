<?php

namespace App\Http\Controllers\Paket\Kerjasama;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use App\Models\Admin\Identitas;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
// single word
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
// bulk word
use App\Models\User\Siswa\Detailsiswa;
use App\Models\Paket\Kerjasama\BukuAdm;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Validator;

class BukuAdmController extends Controller

/*
Blade
php artisan make:view role.paket.kerjasama.bukuadm.Mou


*/
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Administrasi';
        $breadcrumb = 'Paket Kerjasama / Administrasi';
        $titleviewModal = 'Lihat Paket Kerjasama';
        $titleeditModal = 'Edit Paket Kerjasama';
        $titlecreateModal = 'Buat Paket Kerjasama';
        $arr_ths = [
            'Nama Buku',
            'Link',
            'xxxxxxxxxxxxxxxxxxx',
        ];
        $DataBukus = [
            [
                'nama_dokumen' => 'Dokumen Lomba',
                'keterangan' => 'Dokumen administrasi persiapan lomba seperti surat aktif, karpel',
            ],
            [
                'nama_dokumen' => 'Buku Jurnal Mengajar',
                'keterangan' => 'Dokumen administrasi perangkat guru seperti daftar absensi, daftar nilai, jurnal mengajar',
            ],
            [
                'nama_dokumen' => 'Buku Jurnal Mengajar',
                'keterangan' => 'Dokumen administrasi perangkat guru seperti daftar absensi, daftar nilai, jurnal mengajar',
            ],
            [
                'nama_dokumen' => 'Dokumen Rapat',
                'keterangan' => 'Dokumen administrasi persiapan rapat sebagai dokumen pendukung kemudahan menjalankan rapat',
            ],
        ];
        // dd($DataBuku);

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        // $AdmBuku = Cache::tags(['cache_AdmBuku'])->remember('remember_AdmBuku', now()->addHours(2), function () use($etapels) {
        //     return BukuAdm::where('tapel_id', $etapels->id)->get();
        // });
        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.paket.kerjasama.bukuadm.buku-adm', compact(
            'title',
            'title',
            'arr_ths',
            'DataBukus',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
    }
    public function BukuWaliKelasCetak(Request $request)
    {
        // dd($request->all());
        $title = 'Buku Wali Kelas';
        $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama';

        $Guru = Detailguru::find(Auth::user()->detailguru_id);
        $etapels = Etapel::where('aktiv', 'Y')->first();

        $DataKelas = Ekelas::where('detailguru_id', $request->kelas_id)
            ->where('tapel_id', $etapels->id)
            ->first();
        // dd($Guru);
        $Siswa = Detailsiswa::where('kelas_id', $request->kelas_id)->get();

        $DataPerKelas = Detailsiswa::with('kelas')
            ->whereNotNull('kelas_id')
            ->where('kelas_id', $request->kelas_id)
            ->orderBy('kelas_id')
            ->get()
            ->groupBy('kelas_id');

        // Kirim data ke view
        // buku-wali-kelas-potrait.blade
        // E:\laragon\www\siakad\resources\views\role\paket\kerjasama\bukuadm\buku-wali-kelas-potrait.blade.php
        // $pdf = Pdf::loadView('role.paket.kerjasama.bukuadm.buku-wali-kelas-potrait', compact(
        //     'title',
        //     'breadcrumb',
        //     'Guru',
        //     'DataPerKelas',
        // ));

        // // Konfigurasi DOMPDF opsional (ukuran, orientasi)
        // $pdf->setPaper('a4', 'portrait');
        // $pdf->set_option('isHtml5ParserEnabled', true);
        // $pdf->set_option('isRemoteEnabled', true);

        // // Return PDF ke browser langsung (inline) atau unduh
        // return $pdf->stream('buku-wali-kelas.pdf');
        // return $pdf->download('buku-wali-kelas.pdf');
        return view('role.paket.kerjasama.bukuadm.buku-wali-kelas-potrait', compact(
            'title',
            'breadcrumb',
            'Guru',
            'DataPerKelas',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Paket Kerjasama';
        $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.paket.kerjasama.bukuadm.buku-adm-create', compact(
            'title',
            'breadcrumb',
        ));
    }
    public function DaftarNilai()
    {
        //dd($request->all());
        // $DaftarNilaiCetak = $DaftarNilaiCetak = Cache::tags(['cache_DaftarNilaiCetak'])->remember('remember_DaftarNilaiCetak', now()->addHours(2), function () use ($etapel){
        //     return model;
        // });
        // HapusCacheDenganTag('cache_DaftarNilaiCetak');
        $title = '';
        $DataPerKelas = Detailsiswa::with('kelas')
            ->whereNotNull('kelas_id')
            ->orderBy('kelas_id')
            ->get()
            ->groupBy('kelas_id');

        return view('role.paket.kerjasama.bukuadm.buku-adm-dn-guru', compact(
            'title',
            'DataPerKelas',
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
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        \App\Models\Paket\Kerjasama\BukuAdm::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Paket Kerjasama';
        $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama';
        $data = \App\Models\Paket\Kerjasama\BukuAdm::findOrFail($id);

        return view('role.paket.kerjasama.bukuadm.buku-adm-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Paket Kerjasama';
        $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama / Edit';
        $data = \App\Models\Paket\Kerjasama\BukuAdm::findOrFail($id);

        return view('role.paket.kerjasama.bukuadm.buku-adm-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Paket\Kerjasama\BukuAdm::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data yang ditemukan berdasarkan hasil validasi
        $data->update($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = \App\Models\Paket\Kerjasama\BukuAdm::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
    public function BukuWaliKelas()
    {
        $title = 'Buku Wali Kelas';
        $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama';
        $Guru = Detailguru::find(Auth::user()->detailguru_id);
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $DataKelas = Ekelas::where('detailguru_id', Auth::user()->detailguru_id)->where('tapel_id', $etapels->id)->first();
        $Siswa = Detailsiswa::where('kelas_id', $DataKelas->id)->get();
        // dd($kelas, $siswa);

        $DataPerKelas = Detailsiswa::with('kelas')
            ->whereNotNull('kelas_id')
            ->orderBy('kelas_id')
            ->get()
            ->groupBy('kelas_id');

        return view('role.paket.kerjasama.bukuadm.buku-wali-kelas', compact(
            'title',
            'breadcrumb',
            'Guru',
            'DataPerKelas',
        ));
    }

    public function BukuGuru()
    {
        $title = 'Buku Guru';
        $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama';
        // $data = \App\Models\Paket\Kerjasama\BukuAdm::findOrFail($id);
        $DataPerKelas = Detailsiswa::with('kelas')
            ->whereNotNull('kelas_id')
            ->orderBy('kelas_id')
            ->get()
            ->groupBy('kelas_id');

        return view('role.paket.kerjasama.bukuadm.buku-guru', compact(
            'title',
            'breadcrumb',
            'breadcrumb',
            'DataPerKelas',
        ));
    }
    public function BukuUks()
    {
        $title = 'Buku UKS';
        $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama';
        // $data = \App\Models\Paket\Kerjasama\BukuAdm::findOrFail($id);

        return view('role.paket.kerjasama.bukuadm.buku-uks', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function BukuKepala()
    {
        $title = 'Buku Kepala';
        $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama';

        $DataIdentitas = Cache::tags(['cache_DataIdentitas'])->remember('remember_DataIdentitas', now()->addHours(2), function () {
            return Identitas::first();
        });

        $TahunPelajaran = Cache::tags(['cache_TahunPelajaran'])->remember('remember_TahunPelajaran', now()->addHours(2), function () {
            return Etapel::where('aktiv', 'Y')->first();
        });

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('template/Buku Kepala.docx'));
        $templateProcessor->setValue('namasek', $DataIdentitas->namasek ?? '');
        $templateProcessor->setValue('alamat_sekolah', $DataIdentitas->alamat ?? '');
        $templateProcessor->setValue('nama_kepala', $DataIdentitas->nama_kepala ?? '');
        $templateProcessor->setValue('nip_kepala', $DataIdentitas->nip_kepala ?? '');
        $templateProcessor->setValue('tahun_pelajaran', $TahunPelajaran->tapel ?? '' . '/' . $TahunPelajaran->tapel + 1);
        $templateProcessor->setValue('semester', $TahunPelajaran->semester ?? '');

        $tempDoc = storage_path("app/Buku Kepala.docx");
        $templateProcessor->saveAs($tempDoc); // <--- Ini penting!

        return response()->download($tempDoc)->deleteFileAfterSend(true);
    }


    public function BukuPiket()
    {
        $title = 'Buku Piket';
        $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama';
        // $data = \App\Models\Paket\Kerjasama\BukuAdm::findOrFail($id);

        return view('role.paket.kerjasama.bukuadm.buku-piket', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function BukuInduk()
    {
        $title = 'Buku Induk';
        $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama';
        // $data = \App\Models\Paket\Kerjasama\BukuAdm::findOrFail($id);

        return view('role.paket.kerjasama.bukuadm.buku-induk', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function BukuCatatanSiswa()
    {
        $title = 'Buku Catatn Siswa';
        $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama';
        // $data = \App\Models\Paket\Kerjasama\BukuAdm::findOrFail($id);

        return view('role.paket.kerjasama.bukuadm.buku-catatan-siswa', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function BukuRapat(Request $request)
    {
        $title = 'Buku Rapat';
        $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama';
        // $data = \App\Models\Paket\Kerjasama\BukuAdm::findOrFail($id);
        $dataGuru = Detailguru::get();
        $data = [
            'judul' => $request->nama_kegiatan,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'waktu' => $request->waktu,
            'pembahasan' => $request->pembahasan,
        ];

        return view('role.paket.kerjasama.bukuadm.buku-rapat', compact(
            'title',
            'breadcrumb',
            'data',
            'dataGuru',
        ));
    }
    public function bukusertifikat()
    {
        $title = 'Buku Sertifikat';
        $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama';
        // $data = \App\Models\Paket\Kerjasama\BukuAdm::findOrFail($id);

        return view('role.paket.kerjasama.bukuadm.buku-sertifikat', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function masterDokumen(Request $request)
    {
        $title = 'Buku Lomba';
        $breadcrumb = 'xxxxxxxxxxxx / Paket Kerjasama';
        $dataIsi = [
            'tahun_pelajaran' => '2024/2025',
            'keperluan' => 'Mengikuti lomba LCTP tingkat kabupaten',
            'logo' => 'img/logo.png',
        ];
        $DataSIswa = DataSIswaId($request->detailsiswa_id);
        $dataIdentitas = DataIdentitas();
        $data = array_merge($dataIdentitas, $DataSIswa, $dataIsi);
        // dd($request->all(), $data);

        $pdf = PDF::loadView('role.program.surat.siswa.master-dokumen', $data);
        return $pdf->stream('surat-keterangan-aktif.pdf');

        // $data = \App\Models\Paket\Kerjasama\BukuAdm::findOrFail($id);

        // return view('role.program.surat.siswa.master-dokumen', compact(
        //     'title',
        //     'breadcrumb',
        //     // 'data',
        // ));
    }
    public function exportWord($id)
    {

        $siswa = Detailsiswa::findOrFail($id);

        $templateProcessor = new TemplateProcessor(public_path('docx/bukucatatan.docx'));
        // dd($templateProcessor->getVariables());
        $templateProcessor->setValue('nama_siswa', $siswa->nama_siswa);
        $templateProcessor->setValue('nis', $siswa->nis);
        $templateProcessor->setValue('nisn', $siswa->nisn);
        $templateProcessor->setValue('jengkel', $siswa->Elsitjengkel->list ?? '');
        $templateProcessor->setValue('tempat', $siswa->tempat_lahir);
        $templateProcessor->setValue('tanggal_lahir', \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y'));
        $templateProcessor->setValue('alamat', $siswa->alamat_siswa);
        $templateProcessor->setValue('nohp_siswa', $siswa->nohp_siswa);
        $templateProcessor->setValue('jml_saudara', $siswa->jml_saudara);
        $templateProcessor->setValue('agama', $siswa->elsiagama->list ?? '');
        // Ortu
        // Ayah
        $templateProcessor->setValue('nama_ayah', $siswa->nama_ayah);
        $templateProcessor->setValue('alamat_ayah', $siswa->alamat_ayah);
        $templateProcessor->setValue('pekerjaan_ayah', $siswa->pekerjaan_ayah);
        // ibu
        $templateProcessor->setValue('nama_ibu', $siswa->nama_ibu);
        $templateProcessor->setValue('alamat_ibu', $siswa->alamat_ibu);
        $templateProcessor->setValue('pekerjaan_ibu', $siswa->pekerjaan_ibu);
        $templateProcessor->setValue('pekerjaan_ayah', $siswa->pekerjaan_ayah);
        // wali
        $templateProcessor->setValue('nama_wali', $siswa->nama_wali);
        $templateProcessor->setValue('alamat_wali', $siswa->alamat_wali);
        $templateProcessor->setValue('pekerjaan_wali', $siswa->pekerjaan_wali);

        // menambah row tabl
        $templateProcessor->cloneRow('lomba', 3);

        $templateProcessor->setValue('lomba#1', 'LCC');
        $templateProcessor->setValue('juara#1', 'Juara 1');
        $templateProcessor->setValue('tingkat#1', 'Kecamatan');

        $templateProcessor->setValue('lomba#2', 'Cerdas Cermat');
        $templateProcessor->setValue('juara#2', 'Juara 2');
        $templateProcessor->setValue('tingkat#2', 'Kabupaten');

        $templateProcessor->setValue('lomba#3', 'Debat');
        $templateProcessor->setValue('juara#3', 'Juara Harapan');
        $templateProcessor->setValue('tingkat#3', 'Provinsi');
        // menambah row tabl

        // Optional: jika file fotonya ada
        function setImageIfExists($template, $placeholder, $path, $width = 120, $height = 150)
        {
            if (file_exists($path)) {
                $template->setImageValue($placeholder, [
                    'path' => $path,
                    'width' => $width,
                    'height' => $height,
                    'ratio' => true,
                ]);
            }
        }

        // Pemanggilan
        setImageIfExists($templateProcessor, 'fotodiri', public_path('img/siswa/20250361-3x4.png'));
        setImageIfExists($templateProcessor, 'qrabsen', public_path('img/qrabsen/20250361-3x4.png'));
        setImageIfExists($templateProcessor, 'qrdrive', public_path('img/qrdrive/20250361-3x4.png'));


        // Simpan hasil
        $path = storage_path('app/public/hasil-siswa-' . $siswa->nisn . '.docx');
        $templateProcessor->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);

        // Mode Zip
        // $siswa = Detailsiswa::findOrFail($id);
        // $template = public_path('docx/bukucatatan.docx');
        // $output = storage_path('app/public/bukucatatan-output.docx');

        // // Copy dulu template ke output
        // copy($template, $output);

        // $zip = new \ZipArchive;
        // if ($zip->open($output) === true) {
        //     $xml = $zip->getFromName('word/document.xml');

        //     // Replace semua variabel manual
        //     $xml = str_replace('{{nama_siswa}}', $siswa->nama_siswa, $xml);
        //     $xml = str_replace('{{nis}}', $siswa->nis, $xml);
        //     $xml = str_replace('{{nisn}}', $siswa->nisn, $xml);
        //     $xml = str_replace('{{alamat}}', $siswa->alamat, $xml);
        //     $xml = str_replace('{{tanggal_lahir}}', \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y'), $xml);
        //     // Tambah lainnya...

        //     // Simpan kembali
        //     $zip->addFromString('word/document.xml', $xml);
        //     $zip->close();

        //     return response()->download($output)->deleteFileAfterSend(true);
        // } else {
        //     abort(500, 'Gagal membuka file docx');
        // }
    }
    public function exportWordGabungan(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['message' => 'ID siswa tidak boleh kosong.'], 400);
        }

        $phpWordGabungan = new PhpWord();

        foreach ($ids as $index => $id) {
            $siswa = Detailsiswa::findOrFail($id);
            $template = new TemplateProcessor(public_path('template/bukucatatan.docx'));

            // Set Value Siswa
            $template->setValue('nama_siswa', $siswa->nama_siswa);
            $template->setValue('nis', $siswa->nis);
            $template->setValue('nisn', $siswa->nisn);
            $template->setValue('jengkel', $siswa->Elsitjengkel->list ?? '');
            $template->setValue('tempat', $siswa->tempat_lahir);
            $template->setValue('tanggal_lahir', \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y'));
            $template->setValue('alamat', $siswa->alamat_siswa);
            $template->setValue('nohp_siswa', $siswa->nohp_siswa);
            $template->setValue('jml_saudara', $siswa->jml_saudara);
            $template->setValue('agama', $siswa->elsiagama->list ?? '');
            $template->setValue('nama_ayah', $siswa->nama_ayah);
            $template->setValue('alamat_ayah', $siswa->alamat_ayah);
            $template->setValue('pekerjaan_ayah', $siswa->pekerjaan_ayah);
            $template->setValue('nama_ibu', $siswa->nama_ibu);
            $template->setValue('alamat_ibu', $siswa->alamat_ibu);
            $template->setValue('pekerjaan_ibu', $siswa->pekerjaan_ibu);
            $template->setValue('nama_wali', $siswa->nama_wali);
            $template->setValue('alamat_wali', $siswa->alamat_wali);
            $template->setValue('pekerjaan_wali', $siswa->pekerjaan_wali);

            // Clone Row Tabel Prestasi
            $template->cloneRow('lomba', 3);
            $template->setValue('lomba#1', 'LCC');
            $template->setValue('juara#1', 'Juara 1');
            $template->setValue('tingkat#1', 'Kecamatan');
            $template->setValue('lomba#2', 'Cerdas Cermat');
            $template->setValue('juara#2', 'Juara 2');
            $template->setValue('tingkat#2', 'Kabupaten');
            $template->setValue('lomba#3', 'Debat');
            $template->setValue('juara#3', 'Juara Harapan');
            $template->setValue('tingkat#3', 'Provinsi');

            // Gambar: Dinamis pakai NISN
            $fotoBase = $siswa->nisn . '-3x4.png';
            $fotoDir = [
                'fotodiri' => public_path("img/siswa/$fotoBase"),
                'qrabsen' => public_path("img/qrabsen/$fotoBase"),
                'qrdrive' => public_path("img/qrdrive/$fotoBase"),
            ];
            foreach ($fotoDir as $field => $path) {
                if (file_exists($path)) {
                    $template->setImageValue($field, [
                        'path' => $path,
                        'width' => 120,
                        'height' => 150,
                        'ratio' => true,
                    ]);
                }
            }

            // Simpan sementara
            $tempDoc = storage_path("app/temp_siswa_$id.docx");
            $template->saveAs($tempDoc);

            // Load dan masukkan ke dokumen gabungan
            $loaded = IOFactory::load($tempDoc);

            // Jika bukan siswa pertama, tambahkan page break
            if ($index > 0) {
                $phpWordGabungan->addSection()->addPageBreak();
            }

            $section = $phpWordGabungan->addSection();
            foreach ($loaded->getSections() as $subSection) {
                foreach ($subSection->getElements() as $element) {
                    $section->addElement(clone $element);
                }
            }
        }

        // Simpan hasil akhir
        $finalPath = storage_path('app/public/gabungan-siswa.docx');
        IOFactory::createWriter($phpWordGabungan, 'Word2007')->save($finalPath);

        return response()->download($finalPath)->deleteFileAfterSend(true);
    }
}

/*


// A. KETERANGAN PESERTA DIDIK
$template->setValue('nama_siswa', $siswa->nama_siswa);
$template->setValue('nama_panggilan', $siswa->nama_panggilan);
$template->setValue('jenis_kelamin', $siswa->jenis_kelamin);
$template->setValue('tempat_lahir', $siswa->tempat_lahir);
$template->setValue('tanggal_lahir', $siswa->tanggal_lahir);
$template->setValue('agama', $siswa->agama);
$template->setValue('kewarganegaraan', $siswa->kewarganegaraan);
$template->setValue('anak_ke', $siswa->anak_ke);
$template->setValue('jumlah_saudara', $siswa->jumlah_saudara);
$template->setValue('jumlah_saudara_tiri', $siswa->jumlah_saudara_tiri);
$template->setValue('jumlah_saudara_angkat', $siswa->jumlah_saudara_angkat);
$template->setValue('yatim', $siswa->yatim);
$template->setValue('bahasa', $siswa->bahasa);

// B. TEMPAT TINGGAL
$template->setValue('jalan', $siswa->jalan);
$template->setValue('rt', $siswa->rt);
$template->setValue('rw', $siswa->rw);
$template->setValue('desa', $siswa->desa);
$template->setValue('kecamatan', $siswa->kecamatan);
$template->setValue('kabupaten', $siswa->kabupaten);
$template->setValue('provinsi', $siswa->provinsi);
$template->setValue('kode_pos', $siswa->kode_pos);
$template->setValue('nohp_siswa', $siswa->nohp_siswa);
$template->setValue('tinggal_bersama', $siswa->tinggal_bersama);
$template->setValue('jarak_sekolah', $siswa->jarak_sekolah);

// C. KESEHATAN
$template->setValue('golongan_darah', $siswa->golongan_darah);
$template->setValue('riwayat_penyakit', $siswa->riwayat_penyakit);
$template->setValue('tinggi_badan', $siswa->tinggi_badan);
$template->setValue('berat_badan', $siswa->berat_badan);

// D. PENDIDIKAN
$template->setValue('asal_sekolah', $siswa->asal_sekolah);
$template->setValue('tanggal_ijazah_sd', $siswa->tanggal_ijazah_sd);
$template->setValue('nomor_ijazah_sd', $siswa->nomor_ijazah_sd);
$template->setValue('lama_belajar', $siswa->lama_belajar);
$template->setValue('kelas_penerimaan', $siswa->kelas_penerimaan);

// E. ORANG TUA: AYAH
$template->setValue('nama_ayah', $siswa->nama_ayah);
$template->setValue('agama_ayah', $siswa->agama_ayah);
$template->setValue('pendidikan_ayah', $siswa->pendidikan_ayah);
$template->setValue('pekerjaan_ayah', $siswa->pekerjaan_ayah);
$template->setValue('penghasilan_ayah', $siswa->penghasilan_ayah);
$template->setValue('jalan_ayah', $siswa->jalan_ayah);
$template->setValue('rt_ayah', $siswa->rt_ayah);
$template->setValue('rw_ayah', $siswa->rw_ayah);
$template->setValue('desa_ayah', $siswa->desa_ayah);
$template->setValue('kecamatan_ayah', $siswa->kecamatan_ayah);
$template->setValue('kabupaten_ayah', $siswa->kabupaten_ayah);
$template->setValue('provinsi_ayah', $siswa->provinsi_ayah);
$template->setValue('kode_pos_ayah', $siswa->kode_pos_ayah);
$template->setValue('nohp_ayah', $siswa->nohp_ayah);

// F. ORANG TUA: IBU
$template->setValue('nama_ibu', $siswa->nama_ibu);
$template->setValue('agama_ibu', $siswa->agama_ibu);
$template->setValue('pendidikan_ibu', $siswa->pendidikan_ibu);
$template->setValue('pekerjaan_ibu', $siswa->pekerjaan_ibu);
$template->setValue('penghasilan_ibu', $siswa->penghasilan_ibu);
$template->setValue('jalan_ibu', $siswa->jalan_ibu);
$template->setValue('rt_ibu', $siswa->rt_ibu);
$template->setValue('rw_ibu', $siswa->rw_ibu);
$template->setValue('desa_ibu', $siswa->desa_ibu);
$template->setValue('kecamatan_ibu', $siswa->kecamatan_ibu);
$template->setValue('kabupaten_ibu', $siswa->kabupaten_ibu);
$template->setValue('provinsi_ibu', $siswa->provinsi_ibu);
$template->setValue('kode_pos_ibu', $siswa->kode_pos_ibu);
$template->setValue('nohp_ibu', $siswa->nohp_ibu);

// G. WALI
$template->setValue('nama_wali', $siswa->nama_wali);
$template->setValue('agama_wali', $siswa->agama_wali);
$template->setValue('pendidikan_wali', $siswa->pendidikan_wali);
$template->setValue('pekerjaan_wali', $siswa->pekerjaan_wali);
$template->setValue('penghasilan_wali', $siswa->penghasilan_wali);
$template->setValue('jalan_wali', $siswa->jalan_wali);
$template->setValue('rt_wali', $siswa->rt_wali);
$template->setValue('rw_wali', $siswa->rw_wali);
$template->setValue('desa_wali', $siswa->desa_wali);
$template->setValue('kecamatan_wali', $siswa->kecamatan_wali);
$template->setValue('kabupaten_wali', $siswa->kabupaten_wali);
$template->setValue('provinsi_wali', $siswa->provinsi_wali);
$template->setValue('kode_pos_wali', $siswa->kode_pos_wali);
$template->setValue('nohp_wali', $siswa->nohp_wali);

// H. PERKEMBANGAN & PENDIDIKAN LANJUTAN
$template->setValue('tahun_lulus', $siswa->tahun_lulus);
$template->setValue('nomor_ijazah', $siswa->nomor_ijazah);

Array Version
$template->setValues([
    // A. KETERANGAN PESERTA DIDIK
    'nama_siswa' => $siswa->nama_siswa,
    'nama_panggilan' => $siswa->nama_panggilan,
    'jenis_kelamin' => $siswa->jenis_kelamin,
    'tempat_lahir' => $siswa->tempat_lahir,
    'tanggal_lahir' => $siswa->tanggal_lahir,
    'agama' => $siswa->agama,
    'kewarganegaraan' => $siswa->kewarganegaraan,
    'anak_ke' => $siswa->anak_ke,
    'jumlah_saudara' => $siswa->jumlah_saudara,
    'jumlah_saudara_tiri' => $siswa->jumlah_saudara_tiri,
    'jumlah_saudara_angkat' => $siswa->jumlah_saudara_angkat,
    'yatim' => $siswa->yatim,
    'bahasa' => $siswa->bahasa,

    // B. TEMPAT TINGGAL
    'jalan' => $siswa->jalan,
    'rt' => $siswa->rt,
    'rw' => $siswa->rw,
    'desa' => $siswa->desa,
    'kecamatan' => $siswa->kecamatan,
    'kabupaten' => $siswa->kabupaten,
    'provinsi' => $siswa->provinsi,
    'kode_pos' => $siswa->kode_pos,
    'nohp_siswa' => $siswa->nohp_siswa,
    'tinggal_bersama' => $siswa->tinggal_bersama,
    'jarak_sekolah' => $siswa->jarak_sekolah,

    // C. KESEHATAN
    'golongan_darah' => $siswa->golongan_darah,
    'riwayat_penyakit' => $siswa->riwayat_penyakit,
    'tinggi_badan' => $siswa->tinggi_badan,
    'berat_badan' => $siswa->berat_badan,

    // D. PENDIDIKAN
    'asal_sekolah' => $siswa->asal_sekolah,
    'tanggal_ijazah_sd' => $siswa->tanggal_ijazah_sd,
    'nomor_ijazah_sd' => $siswa->nomor_ijazah_sd,
    'lama_belajar' => $siswa->lama_belajar,
    'kelas_penerimaan' => $siswa->kelas_penerimaan,

    // E. ORANG TUA: AYAH
    'nama_ayah' => $siswa->nama_ayah,
    'agama_ayah' => $siswa->agama_ayah,
    'pendidikan_ayah' => $siswa->pendidikan_ayah,
    'pekerjaan_ayah' => $siswa->pekerjaan_ayah,
    'penghasilan_ayah' => $siswa->penghasilan_ayah,
    'jalan_ayah' => $siswa->jalan_ayah,
    'rt_ayah' => $siswa->rt_ayah,
    'rw_ayah' => $siswa->rw_ayah,
    'desa_ayah' => $siswa->desa_ayah,
    'kecamatan_ayah' => $siswa->kecamatan_ayah,
    'kabupaten_ayah' => $siswa->kabupaten_ayah,
    'provinsi_ayah' => $siswa->provinsi_ayah,
    'kode_pos_ayah' => $siswa->kode_pos_ayah,
    'nohp_ayah' => $siswa->nohp_ayah,

    // F. ORANG TUA: IBU
    'nama_ibu' => $siswa->nama_ibu,
    'agama_ibu' => $siswa->agama_ibu,
    'pendidikan_ibu' => $siswa->pendidikan_ibu,
    'pekerjaan_ibu' => $siswa->pekerjaan_ibu,
    'penghasilan_ibu' => $siswa->penghasilan_ibu,
    'jalan_ibu' => $siswa->jalan_ibu,
    'rt_ibu' => $siswa->rt_ibu,
    'rw_ibu' => $siswa->rw_ibu,
    'desa_ibu' => $siswa->desa_ibu,
    'kecamatan_ibu' => $siswa->kecamatan_ibu,
    'kabupaten_ibu' => $siswa->kabupaten_ibu,
    'provinsi_ibu' => $siswa->provinsi_ibu,
    'kode_pos_ibu' => $siswa->kode_pos_ibu,
    'nohp_ibu' => $siswa->nohp_ibu,

    // G. WALI
    'nama_wali' => $siswa->nama_wali,
    'agama_wali' => $siswa->agama_wali,
    'pendidikan_wali' => $siswa->pendidikan_wali,
    'pekerjaan_wali' => $siswa->pekerjaan_wali,
    'penghasilan_wali' => $siswa->penghasilan_wali,
    'jalan_wali' => $siswa->jalan_wali,
    'rt_wali' => $siswa->rt_wali,
    'rw_wali' => $siswa->rw_wali,
    'desa_wali' => $siswa->desa_wali,
    'kecamatan_wali' => $siswa->kecamatan_wali,
    'kabupaten_wali' => $siswa->kabupaten_wali,
    'provinsi_wali' => $siswa->provinsi_wali,
    'kode_pos_wali' => $siswa->kode_pos_wali,
    'nohp_wali' => $siswa->nohp_wali,

    // H. PENDIDIKAN LANJUTAN
    'tahun_lulus' => $siswa->tahun_lulus,
    'nomor_ijazah' => $siswa->nomor_ijazah,
]);

*/