<?php

namespace App\Models;

use QRcode;
use Illuminate\Database\Eloquent\Model;

class QrCodeGenerates extends Model
{
    //
    public function generate($userId)
    {
        echo "<h1>PHP QR Code</h1><hr/>";
        $dataq = ['dany', 'isma', 'iki', 'aufa', 'wisnu', 'imam', 'emira', '12345', '123451'];
        // $dataq =['dany'];

        // $nama = "nama1";
        //set it to writable location, a place for temp generated PNG files
        $PNG_TEMP_DIR = public_path('temp/');
        // $PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;



        //html PNG location prefix
        $PNG_WEB_DIR = public_path('temp/');
        require_once app_path('Helpers/qrlib.php');
        // include "tools/phpqrcode/qrlib.php";
        for ($i = 0; $i < count($dataq); $i++) {
            echo $dataq[$i] . "<br>";

            //Ini bagian generate nama
            $data = $dataq[$i];
            // $data = $nama;
            $_REQUEST['data'] = $dataq[$i];
            //ofcourse we need rights to create temp dir
            if (!file_exists($PNG_TEMP_DIR))
                mkdir($PNG_TEMP_DIR);


            $filename = $PNG_TEMP_DIR . 'test.png';

            //processing form input
            //remember to sanitize user input in real-life solution !!!
            $errorCorrectionLevel = 'L';
            if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L', 'M', 'Q', 'H')))
                $errorCorrectionLevel = $_REQUEST['level'];

            $matrixPointSize = 4;
            if (isset($_REQUEST['size']))
                $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


            if (isset($_REQUEST['data'])) {


                //it's very important!
                if (trim($_REQUEST['data']) == '')
                    die('data cannot be empty! <a href="?">back</a>');

                // user data
                // ini bagian nama file
                //$filename = $PNG_TEMP_DIR.$data.'.png';
                $filename = $PNG_TEMP_DIR . $data . '.png';
                // dd($PNG_TEMP_DIR);
                QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);
            } else {

                //default data
        //         echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a>
        // <hr />';
                QRcode::png($filename, $errorCorrectionLevel, $matrixPointSize, 2);
            }
        }

        return response()->json([]);
        // return view('blade', compact('variabel_satu', 'ariabel_dua');
    }
}
