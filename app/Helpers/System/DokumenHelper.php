<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper DokumenHelper
    |----------------------------------------------------------------------
    |
*/

if (!function_exists('dokumen_siswa')) {
    /**
     * Cari dokumen siswa berdasarkan NIS & type di folder
     *
     * @param string|int $nis
     * @param string $type
     * @param string $folder Path folder
     * @param array $extensions Ekstensi file yang diizinkan
     * @return array Daftar file matching
     */
    /*
        $folder = __DIR__ . '/dokumen';
        $folder = base_path('dokumen');
        $folder = storage_path('app/dokumen');

        $nis    = 250001;
        $type   = 'kk';
        $files = dokumen_siswa($nis, $type, $folder);
        print_r($files);
        format file : 250001_kk_2025_09_06_94432.jpg
    */
    function dokumen_siswa($nis, string $type, string $folder, array $extensions = ['jpg', 'jpeg', 'png', 'pdf']): array
    {
        $result = [];
        if (!is_dir($folder)) return $result;
        $files = scandir($folder);
        foreach ($files as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if (!in_array(strtolower($ext), $extensions)) continue;
            $name = pathinfo($file, PATHINFO_FILENAME);
            $parts = explode('_', $name);
            $fileNis  = $parts[0] ?? null;
            $fileType = $parts[1] ?? null;

            if ($fileNis == $nis && strtolower($fileType) == strtolower($type)) {
                $result[] = $file;
            }
        }

        return $result;
    }
}
