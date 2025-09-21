<?php

// namespace App\Helpers;
// namspace ni terdaftar di autoload => pada composer.json di bagian files

require_once __DIR__ . '/IdentitasHelper.php';

require_once __DIR__ . '/Whatsapp/WhatsappHelper.php';
require_once __DIR__ . '/Whatsapp/PesanWaHelper.php';
require_once __DIR__ . '/PesanHelper.php';
//System
require_once __DIR__ . '/System/FormatHelper.php';
require_once __DIR__ . '/System/QrCodeHelper.php';
require_once __DIR__ . '/System/ChaceHelper.php';
require_once __DIR__ . '/System/HashidsHelper.php';
require_once __DIR__ . '/System/DomPdfHelper.php';
require_once __DIR__ . '/System/Imagick.php';
require_once __DIR__ . '/KartuHelper.php';
require_once __DIR__ . '/System/ImageHelper.php';
require_once __DIR__ . '/System/SvgHelper.php';
require_once __DIR__ . '/System/DropdownHelper.php';
require_once __DIR__ . '/System/UploadFileHelper.php';
// Data
require_once __DIR__ . '/DataGuruHelper.php';
require_once __DIR__ . '/SiswaHelper.php';
require_once __DIR__ . '/SuratHelper.php';


require_once __DIR__ . '/System/FileHelper.php';
require_once __DIR__ . '/AutoReply_SiswaHelper.php';
require_once __DIR__ . '/AutoReply_GuruHelper.php';
require_once __DIR__ . '/AutoReply_SuratHelper.php';
require_once __DIR__ . '/AutoReply_CariHelper.php';
require_once __DIR__ . '/AutoReply_AlumniHelper.php';
require_once __DIR__ . '/AutoReply_BKHelper.php';
require_once __DIR__ . '/AutoReply_RapatHelper.php';
require_once __DIR__ . '/AutoReply_Helper.php';
require_once __DIR__ . '/DataSekolah.php';
require_once __DIR__ . '/DataSekolahHelper.php';
require_once __DIR__ . '/Tahfidz/DataTahfidzHelper.php';
require_once __DIR__ . '/shalatberjamaahcommand.php';
require_once __DIR__ . '/DataRapatHelper.php';
require_once __DIR__ . '/CoCardHelper.php';

require_once __DIR__ . '/SyncHelper.php';
require_once __DIR__ . '/User/SyncHelper.php';
require_once __DIR__ . '/Absensi/RekapBulananHelper.php';
require_once __DIR__ . '/Absensi/AbsensiHelper.php';
require_once __DIR__ . '/Bendahara/Tabungan/TabunganHelper.php';

require_once __DIR__ . '/Bendahara/Komite/BendaharaKomiteHelper.php';
require_once __DIR__ . '/Bendahara/BOS/BendaharaBosHelper.php';
require_once __DIR__ . '/PPDB/PesertaPPDBHelper.php';
require_once __DIR__ . '/Bendahara/PembayaranHelper.php';

require_once __DIR__ . '/AutoReply_Alumni.php';
require_once __DIR__ . '/Auto_Reply_Database.php';

require_once __DIR__ . '/Vendor/Auto_Reply_VendorHelper.php';

require_once __DIR__ . '/Vendor/Auto_Reply_KepalaHelper.php';
require_once __DIR__ . '/PPDB/Auto_Reply_PPDBHelper.php';
require_once __DIR__ . '/System/ControllPCHelper.php';

require_once __DIR__ . '/Auto_Reply_ControlHelper.php';
require_once __DIR__ . '/System/DokumenHelper.php';
require_once __DIR__ . '/System/ReaderDeviceHelper.php';