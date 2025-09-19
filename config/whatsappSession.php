<?php


return [
    'IdWaUtama' => 'Siswa', //config('whatsappSession.IdWaUtama');  GuruId
    'SingleSession' => true, // config('whatsappSession.SingleSession');
    'SekolahNoTujuan' => '6285329860005', // config('whatsappSession.SekolahNoTujuan');
    'NoKepala' => '6285329860005', // config('whatsappSession.NoKepala');
    'DevId' => 'DevId', //config('whatsappSession.DevId');
    'WhatsappGuru' => true, //config('whatsappSession.WhatsappDev');
    'WhatsappDev' => true, //config('whatsappSession.WhatsappDev');
    // config('whatsappSession.DevNomorTujuan');
    'DevNomorTujuan' => '6285329860005',
    'DevNoHPLogin' => '6282324399566', //config('whatsappSession.DevNoHP');
    'NoSekolah' => null,  // nanti akan diisi dinamis dari DB lewat AppServiceProvider
    'NoYayasn' => null,
    'NoPengawas' => null,
    'UrlAbsen' => "https://192.168.1.29/siakad/public/absensi/", //config('whatsappSession.UrlAbsen');
    'ngRok' => true, //config('whatsappSession.UrlAbsen');
    'vendor' => true, //config('whatsappSession.vendor');

    // 'NoSekolah' => $Identias->phone, //config('whatsappSession.NoSekolah');
    // 'NoYayasn' => $Identias->phone, //config('whatsappSession.NoYayasn');
    // 'NoPengawas' => $Identias->phone, //config('whatsappSession.NoPengawas');
];

/*
6282328273372
if(!config('whatsappSession.WhatsappDev')){ //false
$notujuan = siswa
}else{
    $notujuan = nodev
    }


    C:\laragon\www\siakad\config\whatsappSession.php
*/