<?php


return [
    'IdWaUtama' => 'GuruId', //config('whatsappSession.IdWaUtama');
    'SingleSession' => true, // config('whatsappSession.SingleSession');
    'SekolahNoTujuan' => '6285329860005', // config('whatsappSession.SekolahNoTujuan');
    'DevId' => 'DevId', //config('whatsappSession.DevId');
    'WhatsappGuru' => true, //config('whatsappSession.WhatsappDev');
    'WhatsappDev' => true, //config('whatsappSession.WhatsappDev');
    'DevNomorTujuan' => '6285329860005', //config('whatsappSession.DevNomorTujuan');
    'DevNoHPLogin' => '6282324399566', //config('whatsappSession.DevNoHP');
    'NoSekolah' => null,  // nanti akan diisi dinamis dari DB lewat AppServiceProvider
    'NoYayasn' => null,
    'NoPengawas' => null,
    'UrlAbsen' => "https://192.168.1.29/siakad/public/absensi/", //config('whatsappSession.UrlAbsen');
    'ngRok' => true, //config('whatsappSession.UrlAbsen');

    // 'NoSekolah' => $Identias->phone, //config('whatsappSession.NoSekolah');
    // 'NoYayasn' => $Identias->phone, //config('whatsappSession.NoYayasn');
    // 'NoPengawas' => $Identias->phone, //config('whatsappSession.NoPengawas');
];
/*
if(!config('whatsappSession.WhatsappDev')){ //false
$notujuan = siswa
}else{
    $notujuan = nodev
    }
*/