<?php

use PhpOffice\PhpWord\TemplateProcessor;

if (!function_exists('TemplateWordHelper')) {

    /**
     * TemplateWordHelper
     * @param array $config
     *
     * Struktur $config:
     * [
     *   'template' => 'path/to/template.docx',
     *   'output'   => 'path/to/output.docx',
     *   'values'   => ['nama' => 'Budi'],
     *   'rows'     => [
     *       'row_identifier' => [
     *           ['col1' => 'A', 'col2' => 'B'],
     *           ['col1' => 'C', 'col2' => 'D'],
     *       ]
     *   ],
     *   'images'   => [
     *       'foto' => [
     *           'path' => 'storage/foto.jpg',
     *           'width' => 150,
     *           'height' => 150,
     *       ]
     *   ]
     * ]
     */
    /*
    cara penggunaan :
    $file = TemplateWordHelper([
        'template' => storage_path('app/template.docx'),
        'output'   => storage_path('app/hasil.docx'),

        'values' => [
            'nama' => 'Bro Programmer',
            'kelas' => 'XI RPL 2',
        ],

        'rows' => [
            'row.nama' => [
                ['row.nama' => 'Andi', 'row.nilai' => 90],
                ['row.nama' => 'Rina', 'row.nilai' => 85],
            ]
        ],

        'images' => [
            'foto' => [
                'path' => storage_path('app/foto.jpg'),
                'width' => 120,
                'height' => 120,
            ]
        ],
    ]);

    return response()->download($file)->deleteFileAfterSend(true);
    */
    function TemplateWordHelper(array $config)
    {
        $template = new TemplateProcessor($config['template']);

        /* --------------------------
         | 1. Replace TEXT
         --------------------------- */
        if (!empty($config['values'])) {
            foreach ($config['values'] as $key => $val) {
                $template->setValue($key, $val);
            }
        }

        /* --------------------------
         | 2. Insert TABLE (cloneRow)
         --------------------------- */
        if (!empty($config['rows'])) {
            foreach ($config['rows'] as $identifier => $rows) {

                $template->cloneRow($identifier, count($rows));

                foreach ($rows as $i => $rowData) {
                    $rowNumber = $i + 1;

                    foreach ($rowData as $colKey => $colVal) {
                        $template->setValue("{$colKey}#{$rowNumber}", $colVal);
                    }
                }
            }
        }

        /* --------------------------
         | 3. Insert IMAGES
         --------------------------- */
        if (!empty($config['images'])) {
            foreach ($config['images'] as $key => $img) {

                // path harus ada
                if (!isset($img['path']) || !file_exists($img['path'])) {
                    continue;
                }

                $template->setImageValue($key, [
                    'path'  => $img['path'],
                    'width' => $img['width'] ?? 150,
                    'height' => $img['height'] ?? 150,
                ]);
            }
        }

        /* --------------------------
         | 4. Save the file
         --------------------------- */
        $output = $config['output'] ?? storage_path('app/output.docx');
        $template->saveAs($output);

        return $output;
    }
}

/*
contoh penggunaan :


$file = TemplateWordHelperx([
    'template' => public_path('template/tester.docx'),
    'output'   => public_path('template/tester-hasil.docx'),

    'values' => [
        'nama' => 'Bro Programmer',
    ],

    'images' => [
        'qrcode' => [
            'path' => qrttd('ABSEN-123'), // <-- Base64 langsung
            'width' => 200,
            'height' => 200,
        ],
        'foto' => [
            'path' => public_path('test_resized.jpg'),
            'width' => 200,
            'height' => 200,
        ]

    ],
]);
$result = py_print($file);
*/
if (!function_exists('TemplateWordHelperx')) {

    function TemplateWordHelperx(array $config)
    {
        $template = new TemplateProcessor($config['template']);
        $availableVars = $template->getVariables();

        /* ------------------------------
     | 1. TEXT
     ------------------------------ */
        if (!empty($config['values'])) {
            foreach ($config['values'] as $key => $val) {
                if (in_array($key, $availableVars)) {
                    $template->setValue($key, $val);
                }
            }
        }

        /* ------------------------------
     | 2. TABLE ROWS
     ------------------------------ */
        if (!empty($config['rows'])) {
            foreach ($config['rows'] as $identifier => $rows) {

                if (!in_array($identifier, $availableVars)) {
                    continue;
                }

                try {
                    $template->cloneRow($identifier, count($rows));
                } catch (\Throwable $e) {
                    continue;
                }

                foreach ($rows as $i => $rowData) {
                    $rowNumber = $i + 1;

                    foreach ($rowData as $colKey => $colVal) {
                        try {
                            $template->setValue("{$colKey}#{$rowNumber}", $colVal);
                        } catch (\Throwable $e) {
                        }
                    }
                }
            }
        }

        /* ------------------------------
     | 3. IMAGES (support Base64)
     ------------------------------ */
        if (!empty($config['images'])) {

            foreach ($config['images'] as $key => $img) {

                if (!in_array($key, $availableVars)) {
                    continue;
                }

                $imgPath = $img['path'];

                // --- Base64 QR? ---
                if (str_starts_with($imgPath, 'data:image')) {

                    // ambil data base64
                    [$meta, $data] = explode(',', $imgPath);
                    $binary = base64_decode($data);

                    // simpan sebagai file sementara
                    $tempPath = storage_path("app/temp_{$key}.png");
                    file_put_contents($tempPath, $binary);

                    $finalPath = $tempPath;
                }
                // --- File normal ---
                else {
                    if (!file_exists($imgPath)) continue;
                    $finalPath = $imgPath;
                }

                try {
                    $template->setImageValue($key, [
                        'path'  => $finalPath,
                        'width' => $img['width'] ?? 200,
                        'height' => $img['height'] ?? 200,
                    ]);
                } catch (\Throwable $e) {
                }
            }
        }

        /* ------------------------------
     | 4. SAVE
     ------------------------------ */
        $output = $config['output'] ?? storage_path('app/output.docx');
        $template->saveAs($output);

        return $output;
    }
}
