<?php


return [

    /*
    |--------------------------------------------------------------------------
    | 📌 Data Dev :
    |--------------------------------------------------------------------------
    */
    'IdWaUtama' => 'GuruId',
    // Untuk multisesion harus false
    // config('whatsappSession.SingleSession');
    // config('whatsappSession.IdWaUtama');
    'SingleSession' => true,
    //config('whatsappSession.IdWaUtama');  GuruId
    'DevId' => 'DevId',
    // real dev harus false utnu kirim ke ortu / dll
    // config('whatsappSession.WhatsappDev');
    'WhatsappDev' => true,
    //config('whatsappSession.DevNoHP');
    //6282324399566
    'DevNoHPLogin' => '6285329860005',
    // config('whatsappSession.DevNomorTujuan');
    // 6285329860005
    'DevNomorTujuan' => '6285329860005',
    //config('whatsappSession.WhatsappGuru');
    'WhatsappGuru' => true,
    //config('whatsappSession.WhatsappDev');
    //config('whatsappSession.vendor');
    'vendor' => 'Ata Digital',
    'ngRok' => true,

    //config('whatsappSession.UrlAbsen');
    'UrlAbsen' => "https://192.168.1.29/siakad/public/absensi/",
    //config('whatsappSession.UrlAbsen');
    'lockAbsensi' => true, // Mengunci absensi ssiwa
    'lockBendahara' => true, // Mengunci absensi ssiwa
    'lockBK' => true, // Mengunci absensi ssiwa
    'lockPerpustakaan' => true, // Mengunci absensi ssiwa

    /*
    |--------------------------------------------------------------------------
    | 📌 Data Sekolah :
    |--------------------------------------------------------------------------
    */
    // Proses Coding
    // Data Sekolah
    // config('whatsappSession.SekolahNoTujuan');
    'SekolahNoTujuan' => null, // Penerima Dummy => 6287835485773
    // config('whatsappSession.NoKepala');
    'NoKepala' => null, // Penerima laporan
    // config('whatsappSession.NoBendaharaKomite');
    'NoBendaharaKomite' => null, // Bendahara NoBendaharaKomite
    // config('whatsappSession.NoBendaharaBos');
    'NoBendaharaBos' => null, // Bendahara Bos
    //config('whatsappSession.DevId');
    'noBK' => null, // Bendahara Bos
    //config('whatsappSession.wakaKesiswaan');
    'wakaKesiswaan' => null, // Bendahara Bos
    //config('whatsappSession.wakaKurikulum');
    'wakaKurikulum' => null, // Bendahara Bos
    //config('whatsappSession.wakaSarpras');
    'wakaSarpras' => null, // Bendahara Bos

    // nanti akan diisi dinamis dari DB lewat AppServiceProvider
    'NoSekolah' => null,
    'NoYayasn' => null,
    'NoPengawas' => null,
];
