<?php


return [
    // config('whatsappSession.SingleSession');
    'SingleSession' => true,
    //config('whatsappSession.IdWaUtama');  GuruId
    'IdWaUtama' => 'Siswa',
    // config('whatsappSession.SekolahNoTujuan');
    'SekolahNoTujuan' => '6285329860005',
    // config('whatsappSession.NoKepala');
    'NoKepala' => '6285329860005',
    //config('whatsappSession.DevId');
    'DevId' => 'DevId',
    //config('whatsappSession.WhatsappGuru');
    'WhatsappGuru' => true,
    //config('whatsappSession.WhatsappDev');
    'WhatsappDev' => true,
    //config('whatsappSession.DevNoHP');
    'DevNoHPLogin' => '6282324399566',
    // config('whatsappSession.DevNomorTujuan');
    'DevNomorTujuan' => '6285329860005',
    // nanti akan diisi dinamis dari DB lewat AppServiceProvider
    'NoSekolah' => null,
    'NoYayasn' => null,
    'NoPengawas' => null,
    //config('whatsappSession.UrlAbsen');
    'UrlAbsen' => "https://192.168.1.29/siakad/public/absensi/",
    //config('whatsappSession.UrlAbsen');
    'ngRok' => true,
    //config('whatsappSession.vendor');
    'vendor' => true,
    // 'NoSekolah' => $Identias->phone, //config('whatsappSession.NoSekolah');
    // 'NoYayasn' => $Identias->phone, //config('whatsappSession.NoYayasn');
    // 'NoPengawas' => $Identias->phone, //config('whatsappSession.NoPengawas');
];
