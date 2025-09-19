<?php

namespace App\Http\Controllers\AdminDev;

use Imagick;
use App\Models\admindev\SvgPng;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin\Etapel;
use App\Http\Controllers\Controller;
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
        $nama = $request->input('nama', 'Dany Rosepta Ata F');
        // id siswa, dan kode karpel
        $idsiswas = [1, 2, 3, 4, 5];
        $kodeKarpel = 8;
        $folder = 'img/template/karpel';
        $Siswa = Detailsiswa::whereIn('id', [1, 2, 3, 4, 5])->pluck('id');
        foreach ($idsiswas as $IdSiswa) {
            $result = generatekarpel_depan($IdSiswa, $kodeKarpel, $folder);
            // $result = generatekarpel_belakang($IdSiswa, $kodeKarpel, $folder);
        }
        // return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Seluruh siswa telah dibuat menjadi karpel');
    }

    public function GenerateNisn(Request $request)
    {
        $nama = $request->input('nama', 'Dany Rosepta Ata F');
        // id siswa, dan kode karpel
        $idsiswas = [1, 2, 3, 4, 5];
        $kodeKarpel = 10;
        $folder = 'img/template/nisn';
        $Siswa = Detailsiswa::whereIn('id', [1, 2, 3, 4, 5])->pluck('id');
        foreach ($idsiswas as $IdSiswa) {
            $result = generatekarpel_depan($IdSiswa, $kodeKarpel, $folder);
            $result = generatekarpel_belakang($IdSiswa, $kodeKarpel, $folder);
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
            [
                'nisn' => '0145221920',
                'nama_siswa' => 'Afriza Asqi',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '21 Desember 2014',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '3136802239',
                'nama_siswa' => 'Afwah Mumtazah',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '22 Juli 2013',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '3139073805',
                'nama_siswa' => 'Ahmad Muachid Chasbulloh',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '25 Oktober 2013',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '3137207662',
                'nama_siswa' => 'Aisyah Fairuz Salsabila',
                'tempat_lahir' => 'Boyolali',
                'tanggal_lahir' => '29 Oktober 2013',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '3137459804',
                'nama_siswa' => 'Al Fira Ainunnisa',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '21 Agustus 2013',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '3142752902',
                'nama_siswa' => 'Alya Zakiya Zahra',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '06 Februari 2014',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '0147163193',
                'nama_siswa' => 'Arjuna Wirasatya Hendriansyah',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '04 Februari 2014',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '3132162926',
                'nama_siswa' => 'Aulia Izzatun Nisa',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '24 Oktober 2013',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '3139343633',
                'nama_siswa' => 'Aulia Wulan Fitriani',
                'tempat_lahir' => 'Tegal',
                'tanggal_lahir' => '28 Desember 2013',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '3134664738',
                'nama_siswa' => 'Bintang Deanova Zahir',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '05 November 2013',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '3133170321',
                'nama_siswa' => 'Ciko Novriyansa',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '05 November 2013',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '3141981549',
                'nama_siswa' => 'Daffa Zaki Hanafi',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '05 Januari 2014',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '0137103022',
                'nama_siswa' => 'Diaz Hardianto',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '08 November 2013',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '3138569138',
                'nama_siswa' => 'Elsha Sarifahtul Nikmah',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '26 September 2013',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '3137450534',
                'nama_siswa' => 'Fahmi Alfandi Yusuf',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '15 Mei 2013',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '3134509750',
                'nama_siswa' => 'Fakhira Salwa Nabila',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '09 November 2013',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '3135580904',
                'nama_siswa' => 'Gerald Derby Eldira',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '01 Mei 2013',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '3138072309',
                'nama_siswa' => 'Ghifari Alif Ardiyan',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '03 September 2013',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '0145002915',
                'nama_siswa' => 'Hasby Muzayin Faqih',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '03 Mei 2014',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '0145247568',
                'nama_siswa' => 'Ikhwan Bukhori',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '05 Maret 2014',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '0136569287',
                'nama_siswa' => 'Kenji Ovta Jefriwan',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '07 Desember 2013',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '0145333559',
                'nama_siswa' => 'Khanifa Putri Riyadi',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '01 Maret 2014',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '0148611820',
                'nama_siswa' => 'Kharis Novyan',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '01 Januari 2014',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '3124889975',
                'nama_siswa' => 'Linda Nurhidayat',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '18 September 2012',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '3130719155',
                'nama_siswa' => 'Lintang Aalimah',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '21 Mei 2013',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '0146736230',
                'nama_siswa' => 'Maliha Assyabiya Rafifa',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '29 Mei 2014',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '0139119289',
                'nama_siswa' => 'Muhamad Aufar Habibi',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '17 Desember 2013',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '3136733666',
                'nama_siswa' => 'Muhamad Habibi',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '17 Juli 2013',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '0134617202',
                'nama_siswa' => 'Muhammad AL Farizi',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '11 Agustus 2013',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '3143785043',
                'nama_siswa' => 'Nadia A\'inun Syafira',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '23 April 2014',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '0145421950',
                'nama_siswa' => 'Naila Azzahra',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '09 April 2014',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '3133898959',
                'nama_siswa' => 'Shafira Ashifa',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '27 Januari 2013',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '0132551057',
                'nama_siswa' => 'Sultan Muhammad Al Fatih',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '19 Mei 2013',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '3148023704',
                'nama_siswa' => 'Yudha Ahmad Fadhil',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '24 Maret 2014',
                'jenis_kelamin' => 'Laki - laki',
            ],
            [
                'nisn' => '3148807455',
                'nama_siswa' => 'Yumna Aulia Izzatunnissa',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '30 Mei 2014',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '3136455279',
                'nama_siswa' => 'Yumna Fariha Azmi',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '21 September 2013',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '3145480737',
                'nama_siswa' => 'Zahra Febriyana',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '27 Mei 2014',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'nisn' => '0139685959',
                'nama_siswa' => 'Zaky Fauzy Naher',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '31 Oktober 2013',
                'jenis_kelamin' => 'Laki - laki',
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
