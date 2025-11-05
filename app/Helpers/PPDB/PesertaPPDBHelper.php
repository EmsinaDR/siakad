<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper PesertaPPDBHelper
    |----------------------------------------------------------------------
    |
*/

if (!function_exists('PesertaPPDBHelper')) {
    function PesertaPPDBHelper($param = null) {
        return "Helper PesertaPPDBHelper dijalankan dengan param: " . json_encode($param);
    }
}