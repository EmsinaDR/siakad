<?php

namespace App\Http\Controllers\Program\PKKS;

use HTMLPurifier;
use HTMLPurifier_Config;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use App\Models\Admin\Identitas;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\Row;
use PhpOffice\PhpWord\Writer\HTML;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\Element\Cell;
use PhpOffice\PhpWord\Element\Text;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpWord\Element\Table;
use App\Models\Program\PKKS\DataPKKS;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Reader\Word2007;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DataPKKSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    DataPKKS
    $datapkks
    role.program.pkks
    role.program.pkks.data-pkks
    role.program.pkks.blade_show
    Index = Data PKKS
    Breadcume Index = 'Program PKKS / Data PKKS';
    Single = Data PKKS
    php artisan make:view role.program.pkks.data-pkks
    php artisan make:view role.program.pkks.data-pkks-single
    php artisan make:seed DataPKKSSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data PKKS';
        $arr_ths = [
            'System',
            'Kategori',
            'Indikator',
            // 'Point',
            'Kode Dokumen',
            'Nama Dokumen',
            'Referensi',
        ];
        $breadcrumb = 'Program PKKS / Data PKKS';
        $titleviewModal = 'Lihat Data PKKS';
        $titleeditModal = 'Edit Data PKKS';
        $titlecreateModal = 'Create Data PKKS';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = DataPKKS::get();
        // $DataPPKS = DataPKKS::get();
        // dump($$DataPPKS);
        // $DataPPKS = DataPKKS::where('system', 'Y')->get();


        return view('role.program.pkks.data-pkks', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.pkks.data-pkks

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data PKKS';
        $arr_ths = [
            'Kategori',
            'Indikator',
            'Point',
            'Nama Dokumen',
        ];
        $breadcrumb = 'Program PKKS / Data PKKS';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = DataPKKS::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.pkks.data-pkks-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.pkks.data-pkks-single
    }

    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
        ]);

        // Validasi data
        // $validator = Validator::make($request->all(), [
        //     data_field_validator
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }



        // DataPKKS::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update(Request $request, $id)
    {
        // Validasi input
        // dd($request->all());
        // $request->validate([
        //     'editor' => 'required|string',
        // ]);

        // if (!$request->system) {
        //     Session::flash('success', 'Tidak ada system yang dirubah');
        //     return Redirect::back();
        // }
        // Ambil data berdasarkan ID
        $data = DataPkks::findOrFail($id);

        // Update field converter dengan data dari TinyMCE
        // $data->converter = $request->editor;
        $data->update([
            'system' => $request->system ? 'Y' : null,
        ]);

        // dd($request->all());

        // Redirect atau response JSON jika pakai AJAX
        return redirect()->route('data-pkks.index')->with('success', 'Data berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //DataPKKS
        // dd($id);
        // dd($request->all());
        $data = DataPKKS::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
    //Upload untuk Converter
    // public function upload(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:docx|max:2048'
    //     ]);

    //     // Ambil ID dari dropdown
    //     $id = $request->input('id');

    //     // Cari data berdasarkan ID yang dipilih
    //     $data = \App\Models\Program\PKKS\DataPKKS::find($id);

    //     if (!$data) {
    //         return back()->with('error', 'Kode dokumen tidak ditemukan!');
    //     }

    //     // Buat folder jika belum ada
    //     $destinationPath = public_path('dokumen/pkks/doc');
    //     if (!File::exists($destinationPath)) {
    //         File::makeDirectory($destinationPath, 0777, true, true);
    //     }

    //     // Simpan file ke public/dokumen/pkks/doc
    //     $file = $request->file('file');
    //     $filename = time() . '.' . $file->getClientOriginalExtension();
    //     $filePath = $destinationPath . '/' . $filename;
    //     $file->move($destinationPath, $filename);

    //     // Baca isi file DOCX
    //     $text = '';
    //     $reader = IOFactory::createReader('Word2007');
    //     // dd($filename, $text); // Debug sebelum insert

    //     try {
    //         $phpWord = $reader->load($filePath); // Load file DOCX

    //         // Loop over each section and extract text
    //         foreach ($phpWord->getSections() as $section) {
    //             foreach ($section->getElements() as $element) {
    //                 // Periksa apakah elemen ini adalah Text
    //                 if ($element instanceof Text) {
    //                     $text .= $element->getText() . "\n";
    //                 }
    //                 // Jika elemen adalah TextRun
    //                 elseif ($element instanceof TextRun) {
    //                     foreach ($element->getElements() as $childElement) {
    //                         if ($childElement instanceof Text) {
    //                             $text .= $childElement->getText() . "\n";
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Gagal membaca isi file DOCX: ' . $e->getMessage());
    //     }

    //     // Update atau simpan data ke database
    //     $data->update([
    //         'filename' => $filename,
    //         'converter' => $text
    //     ]);

    //     return back()->with('success', 'File berhasil diunggah dan dikonversi!');
    // }
    // public function upload(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:docx|max:2048'
    //     ]);

    //     $id = $request->input('id');
    //     $data = \App\Models\Program\PKKS\DataPKKS::find($id);

    //     if (!$data) {
    //         return back()->with('error', 'Kode dokumen tidak ditemukan!');
    //     }

    //     $destinationPath = public_path('dokumen/pkks/doc');
    //     if (!File::exists($destinationPath)) {
    //         File::makeDirectory($destinationPath, 0777, true, true);
    //     }

    //     $file = $request->file('file');
    //     $filename = time() . '.' . $file->getClientOriginalExtension();
    //     $filePath = $destinationPath . '/' . $filename;
    //     $file->move($destinationPath, $filename);

    //     // Konversi ke HTML
    //     try {
    //         $phpWord = IOFactory::load($filePath);
    //         $htmlContent = '';

    //         foreach ($phpWord->getSections() as $section) {
    //             foreach ($section->getElements() as $element) {

    //                 // Cek jika elemen adalah TextRun (kalimat atau paragraf)
    //                 if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
    //                     $textContent = '';
    //                     $indentation = 0; // Default tanpa indentasi
    //                     $alignment = 'left'; // Default rata kiri

    //                     // Cek apakah memiliki paragraph style
    //                     if (method_exists($element, 'getParagraphStyle')) {
    //                         $paragraphStyle = $element->getParagraphStyle();
    //                         if ($paragraphStyle) {
    //                             $alignment = $paragraphStyle->getAlignment() ?: 'left';

    //                             // Ambil indentasi jika tersedia
    //                             if (method_exists($paragraphStyle, 'getIndentation') && $paragraphStyle->getIndentation()) {
    //                                 $indentation = $paragraphStyle->getIndentation()->getLeft() / 10; // Konversi ke px
    //                             }
    //                         }
    //                     }

    //                     foreach ($element->getElements() as $childElement) {
    //                         if ($childElement instanceof \PhpOffice\PhpWord\Element\Text) {
    //                             $text = $childElement->getText();
    //                             $style = '';

    //                             if (method_exists($childElement, 'getFontStyle')) {
    //                                 $fontStyle = $childElement->getFontStyle();
    //                                 if ($fontStyle instanceof \PhpOffice\PhpWord\Style\Font) {
    //                                     if ($fontStyle->isBold()) $style .= 'font-weight: bold;';
    //                                     if ($fontStyle->isItalic()) $style .= 'font-style: italic;';
    //                                     if ($fontStyle->getUnderline() && $fontStyle->getUnderline() !== 'none') {
    //                                         $style .= 'text-decoration: underline;';
    //                                     }
    //                                 }
    //                             }

    //                             $textContent .= "<span style='{$style}'>{$text}</span>";
    //                         }
    //                     }

    //                     $htmlContent .= "<p style='text-align: {$alignment}; margin-left: {$indentation}px;'>{$textContent}</p>";
    //                 }

    //                 // Jika elemen adalah teks biasa (bukan dalam TextRun)
    //                 elseif ($element instanceof \PhpOffice\PhpWord\Element\Text) {
    //                     $text = $element->getText();
    //                     $alignment = 'left';
    //                     $indentation = 0;

    //                     if (method_exists($element, 'getParagraphStyle')) {
    //                         $paragraphStyle = $element->getParagraphStyle();
    //                         if ($paragraphStyle) {
    //                             $alignment = $paragraphStyle->getAlignment() ?: 'left';
    //                             if (method_exists($paragraphStyle, 'getIndentation') && $paragraphStyle->getIndentation()) {
    //                                 $indentation = $paragraphStyle->getIndentation()->getLeft() / 10;
    //                             }
    //                         }
    //                     }

    //                     $htmlContent .= "<p style='text-align: {$alignment}; margin-left: {$indentation}px;'>{$text}</p>";
    //                 }

    //                 // Jika elemen adalah tabel
    //                 elseif ($element instanceof \PhpOffice\PhpWord\Element\Table) {
    //                     $htmlContent .= '<table border="1" style="border-collapse: collapse; width: 100%;">';
    //                     foreach ($element->getRows() as $row) {
    //                         $htmlContent .= '<tr>';
    //                         foreach ($row->getCells() as $cell) {
    //                             $cellText = '';
    //                             foreach ($cell->getElements() as $cellElement) {
    //                                 if ($cellElement instanceof \PhpOffice\PhpWord\Element\Text) {
    //                                     $cellText .= $cellElement->getText() . ' ';
    //                                 }
    //                             }
    //                             $htmlContent .= "<td style='padding:5px;'>{$cellText}</td>";
    //                         }
    //                         $htmlContent .= '</tr>';
    //                     }
    //                     $htmlContent .= '</table>';
    //                 }
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Gagal membaca isi file DOCX: ' . $e->getMessage());
    //     }

    //     // Simpan ke database
    //     $data->update([
    //         'filename' => $filename,
    //         'converter' => $htmlContent
    //     ]);

    //     return back()->with('success', 'File berhasil diunggah dan dikonversi!');
    // }

    public function upload(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:docx|max:2048'
        ]);

        $id = $request->input('id');
        $data = \App\Models\Program\PKKS\DataPKKS::find($id);

        if (!$data) {
            return back()->with('error', 'Kode dokumen tidak ditemukan!');
        }

        // Tentukan path tujuan untuk menyimpan file
        $destinationPath = public_path('dokumen/pkks/doc');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true, true);
        }

        // Upload file
        $file = $request->file('file');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $filePath = $destinationPath . '/' . $filename;
        $file->move($destinationPath, $filename);

        // Konversi file DOCX menjadi HTML
        try {
            $phpWord = IOFactory::load($filePath);
            $htmlContent = '';

            // Proses setiap section dalam dokumen
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {

                    // **Menangani Tabel**
                    if ($element instanceof \PhpOffice\PhpWord\Element\Table) {
                        Log::info("Tabel ditemukan.");
                        $htmlContent .= "<table border='1' style='border-collapse: collapse; width: 100%;'>";

                        // Proses setiap baris dalam tabel
                        foreach ($element->getRows() as $row) {
                            if (!$row instanceof \PhpOffice\PhpWord\Element\Row) continue;

                            $htmlContent .= "<tr>";

                            // Proses setiap sel dalam baris
                            foreach ($row->getCells() as $cell) {
                                if (!$cell instanceof \PhpOffice\PhpWord\Element\Cell) continue;

                                $cellText = '';
                                foreach ($cell->getElements() as $cellElement) {
                                    if ($cellElement instanceof \PhpOffice\PhpWord\Element\Text) {
                                        $cellText .= $cellElement->getText() . " ";
                                    } elseif ($cellElement instanceof \PhpOffice\PhpWord\Element\TextRun) {
                                        foreach ($cellElement->getElements() as $childElement) {
                                            if ($childElement instanceof \PhpOffice\PhpWord\Element\Text) {
                                                $cellText .= $childElement->getText() . " ";
                                            }
                                        }
                                    }
                                }
                                Log::info("Isi sel: " . trim($cellText));
                                $htmlContent .= "<td style='padding:5px;'>{$cellText}</td>";
                            }
                            $htmlContent .= "</tr>";
                        }
                        $htmlContent .= "</table><br>";
                    }

                    // **Menangani Indentasi pada Teks**
                    elseif ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                        // Mengambil gaya paragraf jika tersedia
                        $paragraphStyle = method_exists($element, 'getParagraphStyle') ? $element->getParagraphStyle() : null;

                        // Mendapatkan indentasi dan alignment dari gaya paragraf
                        $indentation = $paragraphStyle ? $paragraphStyle->getIndentation() : null;
                        $alignment = $paragraphStyle ? $paragraphStyle->getAlignment() : 'left';

                        // Inisialisasi gaya indentasi
                        $indentStyle = "";
                        $leftIndentPx = 0;
                        $firstLineIndentPx = 0;
                        $hangingIndentPx = 0;

                        // Jika ada indentasi, ambil nilai Left, FirstLine, dan Hanging
                        if ($indentation) {
                            // Mendapatkan masing-masing nilai indentasi
                            $leftIndent = method_exists($indentation, 'getLeft') ? $indentation->getLeft() : 0;
                            $firstLineIndent = method_exists($indentation, 'getFirstLine') ? $indentation->getFirstLine() : 0;
                            $hangingIndent = method_exists($indentation, 'getHanging') ? $indentation->getHanging() : 0;

                            // Konversi Twip ke Pixel (1 Twip = 1/20 Pt, 1 Pt ≈ 1.33 Px)
                            $leftIndentPx = ($leftIndent / 1000) * 1.33;
                            $firstLineIndentPx = ($firstLineIndent / 1000) * 1.33;
                            $hangingIndentPx = ($hangingIndent / 1000) * 1.33;

                            // Menyusun gaya CSS untuk indentasi
                            if ($leftIndentPx > 0) {
                                //{$leftIndentPx}
                                $indentStyle .= "margin-left: 100px;";
                            }
                            if ($firstLineIndentPx > 0) {
                                $indentStyle .= " text-indent: {$firstLineIndentPx}px;";
                            }
                            if ($hangingIndentPx > 0) {
                                // {$hangingIndentPx}
                                $indentStyle .= " padding-left: 100px;";
                            }
                        }

                        // Debug: Log indentasi untuk memeriksa nilai yang ditemukan
                        Log::info("Indentasi ditemukan: Left = {$leftIndentPx}px, FirstLine = {$firstLineIndentPx}px, Hanging = {$hangingIndentPx}px");

                        // Menyiapkan teks dalam elemen TextRun
                        $textContent = '';
                        foreach ($element->getElements() as $childElement) {
                            if ($childElement instanceof \PhpOffice\PhpWord\Element\Text) {
                                $textContent .= $childElement->getText();
                            }
                        }

                        // Membuat HTML dengan gaya indentasi yang sudah diterapkan
                        $htmlContent .= "<p style='text-align: {$alignment}; {$indentStyle}'>{$textContent}</p>";
                    }


                    // **Menangani List**
                    // elseif ($element instanceof \PhpOffice\PhpWord\Element\ListItem) {
                    //     // Mengambil gaya dari ListItem
                    //     $listStyle = $element->getStyle();

                    //     // Debugging untuk melihat semua properti dan metode yang tersedia di objek listStyle
                    //     dd($listStyle);

                    //     // Jika gaya ditemukan, coba akses properti Left atau Hanging
                    //     if ($listStyle) {
                    //         $indentation = 0;

                    //         // Debugging untuk melihat properti secara rinci
                    //         Log::info('List Style Debug: ' . print_r($listStyle, true));

                    //         // Coba akses properti Left atau Hanging secara langsung
                    //         $indentation = isset($listStyle->Left) ? $listStyle->Left : 0;
                    //         $hangingIndent = isset($listStyle->Hanging) ? $listStyle->Hanging : 0;

                    //         // Jika tidak ada, set indentasi ke default
                    //         if ($indentation == 0) {
                    //             $indentation = 0;
                    //         }

                    //         // Konversi Twips ke Piksel (1 Twip = 1/15 Pixel)
                    //         $twipToPixel = 15;
                    //         $adjustedIndentation = $indentation / $twipToPixel;

                    //         // Tentukan batas maksimum indentasi
                    //         $maxIndentation = 100;

                    //         // Sesuaikan jika indentasi lebih besar dari batas
                    //         if ($adjustedIndentation > $maxIndentation) {
                    //             $adjustedIndentation = $maxIndentation;
                    //         }

                    //         // Terapkan margin-left untuk style indentasi
                    //         $indentStyle = $adjustedIndentation ? "margin-left: {$adjustedIndentation}px;" : '';
                    //     } else {
                    //         // Jika tidak ada gaya, set indentasi ke 0
                    //         $adjustedIndentation = 0;
                    //         $indentStyle = '';
                    //     }

                    //     // Ambil teks dari ListItem
                    //     $textContent = '';
                    //     foreach ($element->getElements() as $childElement) {
                    //         if ($childElement instanceof \PhpOffice\PhpWord\Element\Text) {
                    //             $textContent .= $childElement->getText();
                    //         } elseif ($childElement instanceof \PhpOffice\PhpWord\Element\TextRun) {
                    //             foreach ($childElement->getElements() as $subChildElement) {
                    //                 if ($subChildElement instanceof \PhpOffice\PhpWord\Element\Text) {
                    //                     $textContent .= $subChildElement->getText();
                    //                 }
                    //             }
                    //         }
                    //     }

                    //     // Masukkan hasil ke dalam HTML dengan indentasi yang disesuaikan
                    //     $htmlContent .= "<p style='{$indentStyle}'>{$textContent}</p>";
                    // }














                    // **Menangani Teks Biasa**
                    elseif ($element instanceof \PhpOffice\PhpWord\Element\Text) {
                        $paragraphStyle = method_exists($element, 'getParagraphStyle') ? $element->getParagraphStyle() : null;
                        $alignment = $paragraphStyle ? $paragraphStyle->getAlignment() : 'left';
                        $htmlContent .= "<p style='text-align: {$alignment};'>" . $element->getText() . "</p>";
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error processing DOCX: ' . $e->getMessage());
            return back()->with('error', 'Gagal membaca isi file DOCX: ' . $e->getMessage());
        }

        // Simpan ke database
        $data->update([
            'filename' => $filename,
            'converter' => $htmlContent
        ]);

        return back()->with('success', 'File berhasil diunggah dan dikonversi!');
    }
    //Export Docx
    public function exportToDocx(Request $request)
    {
        // Ambil konten HTML yang dikirimkan dari AJAX
        $content = $request->input('content');
        if (!$content) {
            Log::error('Konten tidak ditemukan');
            return response()->json(['error' => 'Konten tidak ditemukan!'], 400);
        }

        // Membuat instance PHPWord
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        // Menambahkan section baru
        $section = $phpWord->addSection();

        // Menambahkan konten HTML dengan menggunakan addHtml()
        // addHtml akan mengonversi HTML ke dalam format yang dapat dibaca oleh Word
        $section->addHtml($content);

        // Menyiapkan file untuk diunduh tanpa menyimpan file ke server
        $filename = 'data-pkks.docx';

        // Menyiapkan stream untuk mengunduh file langsung
        try {
            $response = response()->stream(function () use ($phpWord) {
                // Mengonversi PHPWord ke format Word2007 (DOCX)
                $phpWord->save('php://output', 'Word2007');
            }, 200, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
            return $response;
        } catch (\Exception $e) {
            Log::error('Error saat mengekspor DOCX: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat mengekspor DOCX.'], 500);
        }
    }
}
