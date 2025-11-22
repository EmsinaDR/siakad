<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper PyCetakHelper
    |----------------------------------------------------------------------
    |
*/
/*
Cara Penggunaan :
$filePath = 'C:\Users\drmed\Documents\10_TK_A_Smt1_10_Binatang_Air.docx';
$result = print_docx($filePath);

return response()->json([
    'status' => 'ok',
    'message' => $result,
]);
*/
if (!function_exists('print_docx')) {
    /**
     * Cetak file DOCX ke printer default
     *
     * @param string $filePath
     * @return string
     */
    function print_docx($filePath)
    {
        // Normalisasi path (Windows pakai \)
        $filePath = str_replace('/', '\\', $filePath);

        // Inline Python langsung (tanpa file .py)
        $cmd = 'python -c "import os; os.startfile(r\'' . $filePath . '\', \'print\')"';

        // Jalankan command
        $output = shell_exec($cmd . " 2>&1");

        return $output ?: 'File berhasil dikirim ke printer default';
    }
}
if (!function_exists('py_print')) {
    /**
     * Cetak file DOCX ke printer default
     *
     * @param string $filePath
     * @return string
     */
    function py_print($filePath)
    {
        // Normalisasi path (Windows pakai \)
        $filePath = str_replace('/', '\\', $filePath);

        // Path full ke Python Laragon
        $pythonPath = 'C:\\laragon\\bin\\python\\python-3.10\\python.exe'; // sesuaikan versi

        // Inline Python langsung (tanpa file .py)
        $cmd = "$pythonPath -c \"import os; os.startfile(r'$filePath', 'print')\"";

        // Jalankan command
        $output = shell_exec($cmd . " 2>&1");

        return $output ?: 'File berhasil dikirim ke printer default';
    }
}
