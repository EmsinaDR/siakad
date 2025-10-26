<?php

namespace App\Http\Controllers\AdminDev;

use Imagick;
use App\Models\admindev\SvgPng;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;

class SvgPngController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'admindev';
        $breadcrumb = 'admindev / Svg Png';
        $titleviewModal = 'Lihat admindev';
        $titleeditModal = 'Edit admindev';
        $titlecreateModal = 'Buat admindev';
        $arr_ths = [
            'Kategori',
            'Kode',

        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        // $SvgPng = Cache::tags(['SvgPng_Chace'])->remember(
        //     'SvgPng_Remember',
        //     now()->addHours(2),
        //     fn () => SvgPng::where('tapel_id', $etapels->id)->get()
        // );


        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.admindev.svgpng.svg-png', compact(
            'title',
            'title',
            'arr_ths',
            // 'SvgPng',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
    }
    public function GenerateKarpel(Request $request)
    {

        // dd($request->all());

        $idsiswas = explode(",", $request->input('halaman_siswa'));
        // id siswa, dan kode karpel
        // $idsiswas = [1, 2, 3, 4, 5];
        $kodeKarpel = 11;
        $folder = 'img/template/karpel';
        $Siswa = Detailsiswa::whereIn('id',  $idsiswas)->pluck('id');
        foreach ($idsiswas as $IdSiswa) {
            $result = generatekarpel_depan($IdSiswa, $kodeKarpel, $folder);
            // $result = generatekarpel_belakang($IdSiswa, $kodeKarpel, $folder);
        }
        // return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Seluruh siswa telah dibuat menjadi karpel');
    }
    public function GenerateKartuGuru(Request $request)
    {
        $idGurus = explode(",", $request->input('halaman_guru'));
        $KodeKartu = 1;
        $folder = 'img/template/kartu-guru';
        // $Siswa = Detailguru::whereIn('id', [1, 2, 3, 4, 5])->pluck('id');
        foreach ($idGurus as $idGuru) {
            $result = generatrKartuGuru_depan($idGuru, $KodeKartu, $folder);
            $result = generatrKartuGuru_belakang($idGuru, $KodeKartu, $folder);
            // $result = generatekarpel_belakang($IdSiswa, $kodeKarpel, $folder);
        }
        // return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Seluruh siswa telah dibuat menjadi karpel');
    }

    public function GenerateNisn(Request $request)
    {
        $idsiswas = explode(",", $request->input('halaman_siswa'));
        // id siswa, dan kode karpel
        // $idsiswas = [1, 2, 3, 4, 5];
        $kodeKarpel = 11;
        $folder = 'img/template/karpel';
        $Siswa = Detailsiswa::whereIn('id',  $idsiswas)->pluck('id');
        foreach ($idsiswas as $IdSiswa) {
            $result = generatekarpel_depan($IdSiswa, $kodeKarpel, $folder);
            $result = generatekarpel_belakang($IdSiswa, $kodeKarpel, $folder);
        }
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Pembuatan kartu NISN telah selesai');
    }
    public function AllInKartu(Request $request)
    {
        // dd($request->all());
        $idsiswas = explode(",", $request->input('halaman_siswa'));
        $jenis_kartu = $request->input('jenis_kartu');
        // id siswa, dan kode karpel
        // $idsiswas = [1, 2, 3, 4, 5];
        $template_id = $request->input('template_id');
        $Siswa = Detailsiswa::whereIn('id',  $idsiswas)->pluck('id');
        // dd($idsiswas);
        foreach ($idsiswas as $IdSiswa) {
            if ($jenis_kartu === 'Kartu Pelajar') {
                $folder = 'img/template/karpel';
                $template_id = 11;
                $result = generatekarpel_depan($IdSiswa, $template_id, $folder);
                $result = generatekarpel_belakang($IdSiswa, $template_id, $folder);
            } elseif ($jenis_kartu === 'Kartu NISN') {
                $folder = 'img/template/karpel';
                $result = generateNisn($IdSiswa, $template_id, $folder);
                $result = generateNisnBelakang($IdSiswa, $template_id, $folder);
            } elseif ($jenis_kartu === 'Kartu Pembayaran') {
                // dd($request->all());
                $folder = 'img/template/pembayaran';
                $result = KartuPembayaran($IdSiswa, $template_id, $folder);
                // $result = generateNisnBelakang($dataSiswa, $kodeKarpel, $folder);
            } elseif ($jenis_kartu === 'Kartu Perpustakaan') {
                $folder = 'img/template/kartu-perpustakaan';
                $result = generateNisn($IdSiswa, $template_id, $folder);
                $result = generateNisnBelakang($IdSiswa, $template_id, $folder);
            } else {
                // return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Anda belum memilih kartu');
            }
        }
        // return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Pembuatan kartu NISN telah selesai');
    }
    public function AllInKartuKelas(Request $request)
    {
        // dd($request->all());
        // $idsiswas = explode(",", $request->input('kelas_id'));
        $jenis_kartu = $request->input('jenis_kartu');
        // id siswa, dan kode karpel
        // $idsiswas = [1, 2, 3, 4, 5];
        $template_id = $request->input('template_id');
        $idsiswas = Detailsiswa::where('kelas_id',  $request->input('kelas_id'))->pluck('id');
        // dd($idsiswas);
        // $idsiswas = [133];
        foreach ($idsiswas as $IdSiswa) {
            if ($jenis_kartu === 'Kartu Pelajar') {

                $folder = 'img/template/karpel';
                $template_id = 11;
                $result = generatekarpel_depan($IdSiswa, $template_id, $folder);
                $result = generatekarpel_belakang($IdSiswa, $template_id, $folder);
            } elseif ($jenis_kartu === 'Kartu NISN') {
                $folder = 'img/template/karpel';
                $result = generateNisn($IdSiswa, $template_id, $folder);
                $result = generateNisnBelakang($IdSiswa, $template_id, $folder);
            } elseif ($jenis_kartu === 'Kartu Pembayaran') {
                // dd($request->all());
                $folder = 'img/template/pembayaran';
                $result = KartuPembayaran($IdSiswa, $template_id, $folder);
                // $result = generateNisnBelakang($dataSiswa, $kodeKarpel, $folder);
            } elseif ($jenis_kartu === 'Kartu Perpustakaan') {
                $folder = 'img/template/kartu-perpustakaan';
                $result = generateNisn($IdSiswa, $template_id, $folder);
                $result = generateNisnBelakang($IdSiswa, $template_id, $folder);
            } else {
                // return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Anda belum memilih kartu');
            }
        }
        // return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Pembuatan kartu NISN telah selesai');
    }
    public function GenerateKartuPembayaran(Request $request)
    {
        $nama = $request->input('nama', 'Dany Rosepta Ata F');
        // id siswa, dan kode karpel
        $idsiswas = [1, 2, 3, 4, 5];
        $kodeKarpel = 2;
        $folder = 'img/template/pembayaran';
        $Siswa = Detailsiswa::whereIn('id', [1, 2, 3, 4, 5])->pluck('id');
        foreach ($idsiswas as $IdSiswa) {
            $result = KartuPembayaran($IdSiswa, $kodeKarpel, $folder);
            // $result = generatekarpel_belakang($IdSiswa, $kodeKarpel, $folder);
        }
    }

    public function GenerateNisnArray(Request $request)
    {
        $nama = $request->input('nama', 'Dany Rosepta Ata F');
        // id siswa, dan kode karpel
        $idsiswas = [1, 2, 3, 4, 5];
        $kodeKarpel = 1;
        $folder = 'img/template/nisn';
        $Siswa = [
            [
                'nisn' => '0146575037',
                'nama_siswa' => 'Adinda Fitriani Adisty',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '11 Juli 2014',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '3142230715',
                'nama_siswa' => 'Adzkia Samha Faizin',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '09 Februari 2014',
                'jenis_kelamin' => 'Perempuan',
            ],

        ];
        foreach ($Siswa as $dataSiswa) {
            $result = generateNisn($dataSiswa, $kodeKarpel, $folder);
            $result = generateNisnBelakang($dataSiswa, $kodeKarpel, $folder);
        }
    }
    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data admindev';
        $breadcrumb = 'Create admindev / Svg Png';

        // Breadcrumb (jika diperlukan)

        return view('role.admindev.svgpng.svg-png-create', compact(
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
            'kategori' => 'required|string|min:3|max:255',
            'kode' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        SvgPng::create($validator->validated());

        HapusCacheDenganTag('SvgPng_Chace');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');
        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail admindev';
        $breadcrumb = 'Lihat admindev / Svg Png';
        $data = SvgPng::findOrFail($id);

        return view('role.admindev.svgpng.svg-png-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit admindev';
        $breadcrumb = 'xxxxxxxxxxxx / admindev / Edit';
        $data = SvgPng::findOrFail($id);


        return view('role.admindev.svgpng.svg-png-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = SvgPng::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'tapel_id' => 'required|numeric|min:1|max:100',
            'kategori' => 'required|string|min:3|max:255',
            'kode' => 'required|string|min:3|max:255',

        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data yang ditemukan berdasarkan hasil validasi
        $data->update($validator->validated());


        HapusCacheDenganTag('SvgPng_Chace');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = SvgPng::findOrFail($id);

        // Menghapus data
        $data->delete();

        HapusCacheDenganTag('SvgPng_Chace');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}
