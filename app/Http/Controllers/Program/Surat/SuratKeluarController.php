<?php

namespace App\Http\Controllers\Program\Surat;

use Carbon\Carbon;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Admin\Identitas;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\File;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Program\Surat\SuratKeluar;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Surat\SuratKlasifikasi;
use App\Models\Program\Template\TemplateDokumen;

class SuratKeluarController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Program Surat Keluar';
        $breadcrumb = 'Data Surat / Program Surat Keluar';
        $titleviewModal = 'Lihat Program Surat Keluar';
        $titleeditModal = 'Edit Program Surat Keluar';
        $titlecreateModal = 'Buat Program Surat Keluar';
        $arr_ths = [
            'No Surat',
            'Tanggal Surat',
            'Klasifikasi',
            'Perihal',
            'Tujuan',
            'Keterangan',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Program\Surat\SuratKeluar::with(['Klasifikasi'])->where('tapel_id', $etapels->id)->orderBy('created_at', 'DESC')->get();
        $TemplateDokuments = TemplateDokumen::get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.program.surat.suratkeluar.surat-keluar', compact(
            'title',
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'TemplateDokuments',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Program Surat Keluar';
        $breadcrumb = 'xxxxxxxxxxxx / Program Surat Keluar';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.program.surat.suratkeluar.surat-keluar-create', compact(
            'title',
            'breadcrumb',
        ));
    }
    public function ViewEdaran()
    {
        // Judul halaman
        $title = 'Tambah Data Program Surat Keluar';
        $breadcrumb = 'Data Surat / Program Surat Keluar';
        $TemplateDokuments = TemplateDokumen::get();
        $Klasifikasis = SuratKlasifikasi::get();



        return view('role.program.surat.suratkeluar.surat-keluar-edaran', compact(
            'title',
            'breadcrumb',
            'TemplateDokuments',
            'Klasifikasis',
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
        \App\Models\Program\Surat\SuratKeluar::create($validator->validated());

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Program Surat Keluar';
        $breadcrumb = 'xxxxxxxxxxxx / Program Surat Keluar';
        $data = \App\Models\Program\Surat\SuratKeluar::findOrFail($id);

        return view('role.program.surat.suratkeluar.surat-keluar-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Program Surat Keluar';
        $breadcrumb = 'xxxxxxxxxxxx / Program Surat Keluar / Edit';
        $data = \App\Models\Program\Surat\SuratKeluar::findOrFail($id);

        return view('role.program.surat.suratkeluar.surat-keluar-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function SuratKeluarCetak(Request $request)
    {
        // Menemukan data berdasarkan ID
        // dd($request->all());
        $title = 'Edit Program Surat Keluar';
        $breadcrumb = 'Program Surat / Program Surat Keluar / Edit';
        $data = $request->all();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $DataContent = $request->content;
        $content = $request->input('content');
        $Identitas = Identitas::first();
        $KodeSurat = SuratKeluar::generateNoSurat($request->klasifikasi);
        // dd($Kode);
        $bagian_atas = '
<div class="col-xl-12 mb-4">
    <table style="border-collapse: collapse; width: 85%; border: none;">
        <tbody>
            <tr>
                <td style="width: 12%;"><span style="font-size: 12pt;">Nomor</span></td>
                <td style="width: 3%;">:</td>
                <td style="width: 85%;"><span style="font-size: 12pt;">{{nomor_surat}}</span></td>
            </tr>
            <tr>
                <td><span style="font-size: 12pt;">Lampiran</span></td>
                <td>:</td>
                <td><span style="font-size: 12pt;">{{lampiran_surat}}</span></td>
            </tr>
            <tr>
                <td><span style="font-size: 12pt;">Perihal</span></td>
                <td>:</td>
                <td><span style="font-size: 12pt;"><strong>{{perihal_surat}}</strong></span></td>
            </tr>
        </tbody>
    </table>
</div><div class="col-xl-12 mb-1"> <br></div>';

        $tgl_mulai = Carbon::create($request->input('tanggal_pelaksanaan_mulai'));
        $tgl_selesai = Carbon::create($request->input('tanggal_pelaksanaan_selesai'));

        if ($tgl_mulai->month === $tgl_selesai->month && $tgl_mulai->year === $tgl_selesai->year) {
            // Bulan & tahun sama → format pendek
            $tanggal_pelaksanaan_gabungan = $tgl_mulai->format('j') . ' – ' . $tgl_selesai->translatedFormat('j F Y');
        } else {
            // Bulan atau tahun beda → format lengkap
            $tanggal_pelaksanaan_gabungan = $tgl_mulai->translatedFormat('d F Y') . ' - ' . $tgl_selesai->translatedFormat('d F Y');
        }

        $content = $bagian_atas . $content;
        $placeholders = [
            '{{nama_sekolah}}' => $Identitas->namasek,
            '{{alamat_sekolah}}' => $Identitas->alamat,
            '{{tahun_pelajaran}}' => $etapels->tapel,
            '{{semester}}' => $etapels->semester,
            '{{nama_kegiatan}}' => $request->input('nama_kegiatan') ?? '',
            '{{tanggal_normal}}' => Carbon::create($request->input('tanggal_normal'))->translatedformat('l, d F Y') ?? '',
            '{{tanggal_pelaksanaan}}' => Carbon::create($request->input('tanggal_pelaksanaan'))->translatedformat('l, d F Y') ?? '',
            '{{waktu_pelaksanaan}}' => Carbon::create($request->input('waktu_pelaksanaan'))->translatedformat('H:i') . ' WIB',
            '{{tanggal_pelaksanaan_mulai}} s.d. {{tanggal_pelaksanaan_selesai}}' => $tanggal_pelaksanaan_gabungan,
            '{{tempat_pelaksanaan}}' => $request->input('tempat_pelaksanaan') ?? '',
            '{{periode}}' => $request->input('periode') ?? '',
            '{{peserta_kegiatan}}' => $request->input('peserta_kegiatan') ?? '',
            '{{perihal_surat}}' => $request->input('perihal_surat') ?? '',
            '{{nomor_surat}}' => $KodeSurat,
            '{{lampiran_surat}}' => $request->input('lampiran_surat') === '0' ? '-' : $request->input('lampiran_surat') ?? '',
            '{{tembusan_surat}}' => $request->input('perihal_surat') ?? '',
            '{{materi}}' => $request->input('materi') ?? '',
            '{{jumlah_hari}}' => $request->input('jumlah_hari').' Hari',
            '{{jam_masuk}}' => Carbon::create($request->input('jam_masuk'))->translatedformat('H:i').' WIB',
            '{{jam_pulang}}' => Carbon::create($request->input('jam_pulang'))->translatedformat('H:i').' WIB',
            '{{jam_operasional}}' => Carbon::create($request->input('jam_operasional'))->translatedformat('H:i').' WIB',
            '{{data_link}}' => $request->input('data_link'),
            '{{nama_mapel}}' => $request->input('nama_mapel'),
        ];
        if ($request->filled('nama_siswa_dropdown')) {
            $detailsiswa = Detailsiswa::find($request->nama_siswa_dropdown);

            if ($detailsiswa) {
                $placeholders = array_merge($placeholders, $detailsiswa->generateDataSiswa());
            }
        }

        $contentx = str_replace(array_keys($placeholders), array_values($placeholders), $content);
        if ($request->filled('nama_guru_dropdown')) {
            $detailguru = Detailguru::find($request->nama_guru_dropdown);

            if ($detailguru) {
                $placeholders = array_merge($placeholders, $detailguru->generateDataGuru());
            }
        }
        $content = str_replace(array_keys($placeholders), array_values($placeholders), $contentx);
        // dd($content);

        // dd($perihal_surat, $Identitas, $kodeSurat, $JumlahSuratId, $Klasifikasi, $placeholders, $request->all(), $content);

        return view('role.program.surat.suratkeluar.surat-keluar-cetak', compact(
            'title',
            'breadcrumb',
            'data',
            'content',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Program\Surat\SuratKeluar::findOrFail($id);

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
        $data = \App\Models\Program\Surat\SuratKeluar::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
    public function SuratKeluarSave(Request $request)
    {

        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->

        $Identitas = Identitas::first();
        $Klasifikasi = SuratKlasifikasi::find($request->klasifikasi_id);


        if ($request->nama_surat === 'Aktif Belajar') {
            foreach ($request->detailsiswa_id as $Siswa) {
                $DataSiswa = Detailsiswa::with('KelasOne')->where('id', $Siswa)->first();
                $data = [
                    'detailsiswa_id' => $DataSiswa->id,
                    'nama_siswa' => $DataSiswa->nama_siswa,
                    'nis_siswa' => $DataSiswa->nis,
                    'nisn_siswa' => $DataSiswa->nisn,
                    'ttl_siswa' => $DataSiswa->tempat_lahir . ', ' . Carbon::create($DataSiswa->tanggal_lahir)->translatedformat('d F Y'),
                    'nama_ayah' => $DataSiswa->nama_ayah ?? '-',
                    'nama_ibu' => $DataSiswa->nama_ibu ?? '-',
                    'alamat_siswa' => $DataSiswa->alamat_siswa ?? '-',
                    'kelas_siswa' => $DataSiswa->KelasOne->kelas ?? '-',
                ];
                $JumlahSurat = SuratKeluar::where('tapel_id', $etapels->id)->count() + 1;
                $NoUrutSurat = str_pad($JumlahSurat, 3, '0', STR_PAD_LEFT);
                $NoSurat = $NoUrutSurat . '/' . $Klasifikasi->kode . '/' . $Identitas->jenjang . $Identitas->nomor . '/' . date('m') . '/' . date('Y');
                \App\Models\Program\Surat\SuratKeluar::create(
                    [
                        'tapel_id' => $etapels->id,
                        'klasifikasi_id' => $request->klasifikasi_id,
                        'nomor_surat' => $NoSurat,
                        'variabel' => json_encode($data),
                        'tanggal_surat' => now(),
                        'tujuan' => 'Pemenuhan administrasi dokumen siswa',
                        'perihal' => $Klasifikasi->nama,
                        'template_id' => $request->template_id,
                        'keterangan' => $request->keterangan ?? 'Pemenuhan administrasi dokumen siswa bernama : ' . $DataSiswa->nama_siswa,
                    ]
                );
            }
        } elseif ($request->nama_surat === 'Surat Pindah Sekolah Siswa') {
            // sekolah_tujuan
            //alamat_tujuan
            // dd($request->all());
            foreach ($request->detailsiswa_id as $Siswa) {
                $DataSiswa = Detailsiswa::with('KelasOne')->where('id', $Siswa)->first();
                $data = [
                    'detailsiswa_id' => $DataSiswa->id ?? '-',
                    'nama_siswa' => $DataSiswa->nama_siswa ?? '-',
                    'nis_siswa' => $DataSiswa->nis ?? '-',
                    'nisn_siswa' => $DataSiswa->nisn ?? '-',
                    'ttl_siswa' => $DataSiswa->tempat_lahir . ', ' . Carbon::create($DataSiswa->tanggal_lahir)->translatedformat('d F Y'),
                    'nama_ayah' => $DataSiswa->nama_ayah ?? '-',
                    'nama_ibu' => $DataSiswa->nama_ibu ?? '-',
                    'alamat_siswa' => $DataSiswa->alamat_siswa ?? '-',
                    'kelas_siswa' => $DataSiswa->KelasOne->kelas ?? '-',
                    'sekolah_tujuan' => $request->sekolah_tujuan ?? '-',
                    'alamat_tujuan' => $request->alamat_tujuan ?? '-',
                ];
                $JumlahSurat = SuratKeluar::where('tapel_id', $etapels->id)->count() + 1;
                $NoUrutSurat = str_pad($JumlahSurat, 3, '0', STR_PAD_LEFT);
                $NoSurat = $NoUrutSurat . '/' . $Klasifikasi->kode . '/' . $Identitas->jenjang . $Identitas->nomor . '/' . date('m') . '/' . date('Y');
                \App\Models\Program\Surat\SuratKeluar::create(
                    [
                        'tapel_id' => $etapels->id,
                        'klasifikasi_id' => $request->klasifikasi_id,
                        'nomor_surat' => $NoSurat,
                        'variabel' => json_encode($data),
                        'tanggal_surat' => now(),
                        'tujuan' => 'Pemenuhan administrasi dokumen siswa',
                        'perihal' => $Klasifikasi->nama,
                        'template_id' => $request->template_id,
                        'keterangan' => $request->keterangan ?? 'Pemenuhan administrasi dokumen siswa bernama : ' . $DataSiswa->nama_siswa . ' untuk Mutasi',
                    ]
                );
            }
            // dd($request->all(), $DataSiswa, $DataSiswa->KelasOne->kelas, $data);
        } elseif ($request->nama_surat === 'Surat Tidak Mampu') {
            foreach ($request->detailsiswa_id as $Siswa) {
                $DataSiswa = Detailsiswa::with('KelasOne')->where('id', $Siswa)->first();
                $data = [
                    'detailsiswa_id' => $DataSiswa->id ?? '-',
                    'nama_siswa' => $DataSiswa->nama_siswa ?? '-',
                    'nis_siswa' => $DataSiswa->nis ?? '-',
                    'nisn_siswa' => $DataSiswa->nisn ?? '-',
                    'ttl_siswa' => $DataSiswa->tempat_lahir . ', ' . Carbon::create($DataSiswa->tanggal_lahir)->translatedformat('d F Y'),
                    'nama_ayah' => $DataSiswa->nama_ayah ?? '-',
                    'pekerjaan_ayah' => $DataSiswa->pekerjaan_ayah ?? '-',
                    'nama_ibu' => $DataSiswa->nama_ibu ?? '-',
                    'alamat_siswa' => $DataSiswa->alamat_siswa ?? '-',
                    'kelas_siswa' => $DataSiswa->KelasOne->kelas ?? '-',
                    'sekolah_tujuan' => $request->sekolah_tujuan ?? '-',
                    'alamat_tujuan' => $request->alamat_tujuan ?? '-',
                ];
                $JumlahSurat = SuratKeluar::where('tapel_id', $etapels->id)->count() + 1;
                $NoUrutSurat = str_pad($JumlahSurat, 3, '0', STR_PAD_LEFT);
                $NoSurat = $NoUrutSurat . '/' . $Klasifikasi->kode . '/' . $Identitas->jenjang . $Identitas->nomor . '/' . date('m') . '/' . date('Y');
                \App\Models\Program\Surat\SuratKeluar::create(
                    [
                        'tapel_id' => $etapels->id,
                        'klasifikasi_id' => $request->klasifikasi_id,
                        'nomor_surat' => $NoSurat,
                        'variabel' => json_encode($data),
                        'tanggal_surat' => now(),
                        'tujuan' => 'Pemenuhan administrasi dokumen siswa',
                        'perihal' => $Klasifikasi->nama,
                        'template_id' => $request->template_id,
                        'keterangan' => $request->keterangan ?? 'Pemenuhan administrasi dokumen siswa bernama : ' . $DataSiswa->nama_siswa . ' untuk kelengkapan administrasi',
                    ]
                );
            }
        } elseif ($request->nama_surat === 'Surat Aktif Mengajar') {
            $DataGuru = Detailguru::find($request->detailguru_id);
        } elseif ($request->nama_surat === 'Surat Keterangan Izin Mengikuti Lomba') {
            foreach ($request->detailsiswa_id as $Siswa) {
                $DataSiswa = Detailsiswa::with('KelasOne')->where('id', $Siswa)->first();
                $data = [
                    'detailsiswa_id' => $DataSiswa->id ?? '-',
                    'nama_siswa' => $DataSiswa->nama_siswa ?? '-',
                    'nis_siswa' => $DataSiswa->nis ?? '-',
                    'nisn_siswa' => $DataSiswa->nisn ?? '-',
                    'ttl_siswa' => $DataSiswa->tempat_lahir . ', ' . Carbon::create($DataSiswa->tanggal_lahir)->translatedformat('d F Y'),
                    'nama_ayah' => $DataSiswa->nama_ayah ?? '-',
                    'pekerjaan_ayah' => $DataSiswa->pekerjaan_ayah ?? '-',
                    'nama_ibu' => $DataSiswa->nama_ibu ?? '-',
                    'alamat_siswa' => $DataSiswa->alamat_siswa ?? '-',
                    'kelas_siswa' => $DataSiswa->KelasOne->kelas ?? '-',
                    'nama_lomba' => $request->sekonama_lombalah_tujuan ?? '-',
                    'tingkat_lomba' => $request->tingkat_lomba ?? '-',
                    'tanggal_lomba' => $request->tanggal_lomba ?? '-',
                    'tempat_lomba' => $request->tempat_lomba ?? '-',
                ];
                $JumlahSurat = SuratKeluar::where('tapel_id', $etapels->id)->count() + 1;
                $NoUrutSurat = str_pad($JumlahSurat, 3, '0', STR_PAD_LEFT);
                $NoSurat = $NoUrutSurat . '/' . $Klasifikasi->kode . '/' . $Identitas->jenjang . $Identitas->nomor . '/' . date('m') . '/' . date('Y');
                \App\Models\Program\Surat\SuratKeluar::create(
                    [
                        'tapel_id' => $etapels->id,
                        'klasifikasi_id' => $request->klasifikasi_id,
                        'nomor_surat' => $NoSurat,
                        'variabel' => json_encode($data),
                        'tanggal_surat' => now(),
                        'tujuan' => 'Pemenuhan administrasi lomba',
                        'perihal' => $Klasifikasi->nama,
                        'template_id' => $request->template_id,
                        'keterangan' => $request->keterangan ?? 'Pemenuhan administrasi dokumen siswa bernama : ' . $DataSiswa->nama_siswa . ' untuk kebutuhan lomba.',
                    ]
                );
            }
            // Edaran dan Pemberitahuan
        } elseif ($request->nama_surat === 'Surat Pemberitahuan Kegiatan Sekolah') {
        } elseif ($request->nama_surat === 'Surat Pemberitahuan Libur Sekolah') {
        } elseif ($request->nama_surat === 'Surat Pemberitahuan Kenaikan Kelas') {
        } elseif ($request->nama_surat === 'Surat Pemberitahuan Pembayaran Seiring Akan Diadakannya Kegiatan') {
        } elseif ($request->nama_surat === 'Surat Pemberitahuan Daftar Ulang') {
        } elseif ($request->nama_surat === 'Pemberitahuan Libur Sekolah / PHBN') {
        } elseif ($request->nama_surat === 'Pemberitahuan Ujian Tengah Semester Terkait Pembayaran') {
        } elseif ($request->nama_surat === 'Pemberitahuan Ujian Tengah Semester') {
        } elseif ($request->nama_surat === 'xxxxxxxxxxxxxxxxxx') {
        } elseif ($request->nama_surat === 'xxxxxxxxxxxxxxxxxx') {
        } elseif ($request->nama_surat === 'xxxxxxxxxxxxxxxxxx') {
            $DataGuru = Detailguru::find($request->detailguru_id);
        } else {
        }
        // dd($NoUrutSurat, $NoSurat, $Identitas, $Klasifikasi);

        //   {nomor_surat} <br>
        //             {nama_kepala} <br>
        //             {data_nama_sekolah} <br>
        //             {nama_siswa} <br>
        //             {nis_siswa} <br>
        //             {kelas_siswa} <br>
        //             {nama_ayah} <br>
        //             {alamat_siswa} <br>
        //             {data_kabupaten} <br>
        // body_method
        Session::flash('success', 'Data Berhasil Dsimpan');
        return Redirect::back();
    }
    public function suratAktifWhatsapp()
    {
        // Validasi form input

        // Data surat (bisa juga ambil dari DB jika perlu)
        $data = [
            'nama'           => 'aaa',
            'keperluan'           => 'aaa',
        ];

        // Lokasi simpan
        $folder = public_path('temp');
        $filename = $data['nama'] . '.pdf';
        $filepath = $folder . '/' . $filename;

        // Buat folder kalau belum ada
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        // \laragon\www\siakad\resources\views\role\program\surat\surat - aktif - siswa . php

        // Generate dan simpan PDF
        $pdf = Pdf::loadView('role.program.surat.surat-aktif-siswa', $data);
        $pdf->save($filepath);

        // Bisa return ke view, JSON, atau redirect
        return response()->json([
            'message' => 'Surat berhasil disimpan.',
            'nama_file' => $filename,
            'url' => asset('temp/' . $filename),
        ]);
    }
    public function suratAktifWhatsappx(Request $request)
    {
        // Validasi form input
        $request->validate([
            'nama'           => 'required|string|max:255',
            'nisn'           => 'required|string|max:20',
            'kelas'          => 'required|string|max:50',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'tahun_ajaran'   => 'required|string|max:15',
            'keperluan'      => 'required|string|max:255',
        ]);

        // Data surat (bisa juga ambil dari DB jika perlu)
        $data = [
            'nama'           => $request->nama,
            'nisn'           => $request->nisn,
            'kelas'          => $request->kelas,
            'tempat_lahir'   => $request->tempat_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'tahun_ajaran'   => $request->tahun_ajaran,
            'keperluan'      => $request->keperluan,
            'logo'           => public_path('img/logo-sekolah.png'),
            'nama_kepsek'    => 'Drs. Edukator Cerdas', // bisa juga dari setting sekolah
            'nip_kepsek'     => '19600101 198001 1 001',
            'tanggal_surat'  => Carbon::now()->translatedFormat('d F Y'),
            'nomor_surat'    => '421/' . rand(100, 999) . '/SMPN1/' . date('Y'),
            'lokasi_surat'   => 'Kota Edukasi',
        ];

        // Lokasi simpan
        $folder = public_path('temp');
        $filename = $data['nisn'] . '.pdf';
        $filepath = $folder . '/' . $filename;

        // Buat folder kalau belum ada
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        // \laragon\www\siakad\resources\views\role\program\surat\surat - aktif - siswa . php

        // Generate dan simpan PDF
        $pdf = Pdf::loadView('role.program.surat.surat-aktif-siswa', $data);
        $pdf->save($filepath);

        // Bisa return ke view, JSON, atau redirect
        return response()->json([
            'message' => 'Surat berhasil disimpan.',
            'nama_file' => $filename,
            'url' => asset('temp/' . $filename),
        ]);
    }
}
