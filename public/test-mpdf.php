<?php
require __DIR__ . '/../vendor/autoload.php'; // Pastikan autoload MPDF
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<h1>Test PDF Berhasil</h1>');
$mpdf->Output();
