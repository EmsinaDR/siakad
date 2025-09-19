<?php

namespace App\Http\Controllers\Program\SOP;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\FacadesLog;
use App\Models\Program\SOP\DataSOP;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\Element\Text;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpWord\Element\TextRun;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpWord\Element\Paragraph;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\Element\Table;  // Untuk elemen tabel jika dibutuhkan.
class DataSOPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view role.program.sop.data-sop
php artisan make:view role.program.sop.data-sop-single
php artisan make:model Program/SOP/DataSOP
php artisan make:controller Program/SOP/DataSOPController --resource



php artisan make:seeder Program/SOP/DataSOPSeeder
php artisan make:migration Migration_DataSOP




*/
    /*
    DataSOP
    $datasop
    role.program.sop
    role.program.sop.data-sop
    role.program.sop.blade_show
    Index = Data SOP
    Breadcume Index = 'Program SOP / Data SOP';
    Single = Data SOP
    php artisan make:view role.program.sop.data-sop
    php artisan make:view role.program.sop.data-sop-single
    php artisan make:seed DataSOPSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data SOP';
        $arr_ths = [
            'Bidang',
            'Judul',
            'Dasar Hukum',
        ];
        $breadcrumb = 'Program SOP / Data SOP';
        $titleviewModal = 'Lihat Data SOP';
        $titleeditModal = 'Edit Data SOP';
        $titlecreateModal = 'Create Data SOP';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = DataSOP::get();


        return view('role.program.sop.data-sop', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.sop.data-sop

    }


    public function show($id)
    {
        //
        //Title to Controller
        $title = 'Data SOP';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Program SOP / Data SOP';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = DataSOP::where('tapel_id', $etapels->id)->get();
        $data = DataSOP::find($id);


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.sop.data-sop-single', compact(
            'data',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.sop.data-sop-single
    }

    public function store(Request $request)
    {
        $request->validate([
            'bidang' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'dasar_hukum' => 'nullable|string',
            'kualifikasi_pelaksana' => 'nullable|string',
            'keterkaitan' => 'nullable|string',
            'peralatan' => 'nullable|string',
            'peringatan' => 'nullable|string',
            'pencatatan' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        DataSOP::create($request->all());

        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'bidang' => 'required|string|max:255',
            // 'kategori' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'dasar_hukum' => 'nullable|string',
            'kualifikasi_pelaksana' => 'nullable|string',
            'keterkaitan' => 'nullable|string',
            'peralatan' => 'nullable|string',
            'peringatan' => 'nullable|string',
            'pencatatan' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tanggal_pembuatan' => 'nullable|string',
            'tanggal_revisi' => 'nullable|string',
        ]);

        // Cari data berdasarkan ID
        $dataSOP = DataSOP::find($id);

        // Jika data tidak ditemukan
        if (!$dataSOP) {
            return Redirect::back()->with('error', 'Data tidak ditemukan');
        }

        // Update data
        $dataSOP->update($request->all());


        Session::flash('success', 'Data Berhasil Diperbaharui');
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //DataSOP
        // dd($id);
        // dd($request->all());
        $data = DataSOP::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }








    public function showForm()
    {
        return view('import-form'); // Menampilkan form upload file
    }

    public function importDoc(Request $request)
    {
        try {
            // Validasi file
            $request->validate([
                'docx_file' => 'required|mimes:docx|max:10240', // Validasi hanya .docx
            ]);

            // Ambil file dan path
            $file = $request->file('docx_file');
            $path = $file->getRealPath();

            // Membaca file .docx menggunakan PHPWord
            $phpWord = IOFactory::load($path);
            $sections = $phpWord->getSections();

            $data = [];

            // Iterasi setiap section
            foreach ($sections as $sectionIndex => $section) {
                $elements = $section->getElements();

                // Variabel untuk menyimpan data yang diekstrak
                $namasekolah = '';
                $judul = '';
                $dasarhukum = '';
                $kualifikasi = '';
                $keterkaitan = '';
                $peralatan = '';
                $peringatan = '';
                $pencatatan = '';

                // Mengekstrak data dari elemen-elemen dalam section
                foreach ($elements as $elementIndex => $element) {
                    // Jika elemen adalah TextRun (untuk teks dalam paragraf)
                    if ($element instanceof TextRun) {
                        $text = '';
                        foreach ($element->getElements() as $textElement) {
                            if ($textElement instanceof Text) {
                                $text .= $textElement->getText();
                            }
                        }

                        // Log atau proses teks
                        Log::info("Teks ditemukan: " . $text);
                    }

                    // Jika elemen adalah tabel
                    if ($element instanceof Table) {
                        Log::info("Tabel ditemukan di Section " . ($sectionIndex + 1));

                        $rows = $element->getRows();

                        // Pastikan tabel memiliki 7 baris dan 2 kolom
                        if (count($rows) >= 7) {
                            // Mengambil teks dari setiap cell dengan pengecekan elemen yang lebih dalam
                            $namasekolah = $this->getCellText($rows[0]->getCells()[0]);
                            $judul = $this->getCellText($rows[0]->getCells()[1]);

                            $dasarhukum = $this->getCellText($rows[2]->getCells()[0]);
                            $kualifikasi = $this->getCellText($rows[2]->getCells()[1]);

                            $keterkaitan = $this->getCellText($rows[4]->getCells()[0]);
                            $peralatan = $this->getCellText($rows[4]->getCells()[1]);

                            $peringatan = $this->getCellText($rows[6]->getCells()[0]);
                            $pencatatan = $this->getCellText($rows[6]->getCells()[1]);

                            // Debugging: Log hasil akhir per baris dan kolom
                            Log::info('namasekolah: ' . $namasekolah);
                            Log::info('judul: ' . $judul);
                            Log::info('dasarhukum: ' . $dasarhukum);
                            Log::info('kualifikasi: ' . $kualifikasi);
                            Log::info('keterkaitan: ' . $keterkaitan);
                            Log::info('peralatan: ' . $peralatan);
                            Log::info('peringatan: ' . $peringatan);
                            Log::info('pencatatan: ' . $pencatatan);
                        }

                        // Simpan data ke array
                        $data[] = [
                            'namasekolah' => $namasekolah,
                            'judul' => $judul,
                            'dasarhukum' => $dasarhukum,
                            'kualifikasi' => $kualifikasi,
                            'keterkaitan' => $keterkaitan,
                            'peralatan' => $peralatan,
                            'peringatan' => $peringatan,
                            'pencatatan' => $pencatatan,
                        ];
                    }
                }
            }

            // Simpan data ke database
            foreach ($data as $item) {
                DataSOP::create($item); // Simpan setiap item ke database
            }

            return redirect()->back()->with('success', 'Data berhasil diimpor');
        } catch (\Exception $e) {
            Log::error("Terjadi kesalahan: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Fungsi untuk mendapatkan teks dari cell dengan pengecekan elemen lain
    private function getCellText($cell)
    {
        $text = '';

        foreach ($cell->getElements() as $element) {
            // Jika elemen adalah TextRun, ambil teksnya
            if ($element instanceof TextRun) {
                $textContent = '';
                foreach ($element->getElements() as $textElement) {
                    if ($textElement instanceof Text) {
                        $textContent .= $textElement->getText();
                    }
                }

                // Mengganti karakter spasi non-breaking dengan spasi biasa
                $textContent = str_replace("\u{A0}", ' ', $textContent);

                // Debugging: Output teks sebelum diproses
                Log::info('Text before processing: ' . $textContent);

                // Mengganti newline dengan <br> agar tampak di HTML
                $textContent = nl2br($textContent);  // Mengubah newline menjadi <br>

                // Memisahkan teks berdasarkan titik (.) atau bintang (*), lalu menghapus whitespace berlebih
                $items = preg_split('/[\.*]+/', $textContent);
                $items = array_map('trim', array_filter($items)); // Menghapus elemen kosong dan memangkas spasi

                // Debugging: Output array setelah pemisahan
                Log::info('Items after split: ' . print_r($items, true));

                // Jika ada lebih dari satu item, buat list
                if (count($items) > 1) {
                    $text .= '<ul>';
                    foreach ($items as $item) {
                        $text .= '<li>' . htmlspecialchars($item) . '</li>';
                    }
                    $text .= '</ul>';
                } else {
                    // Jika hanya satu item atau tidak bisa dipisah, tampilkan sebagai teks biasa
                    $text .= htmlspecialchars($textContent);
                }
            }
        }

        // Debugging: Output teks yang dihasilkan
        Log::info('Final text: ' . $text);

        return trim($text); // Mengembalikan teks yang sudah dipangkas dan diformat
    }
}
