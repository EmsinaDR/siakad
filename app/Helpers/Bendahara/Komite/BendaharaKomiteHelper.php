<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper BendaharaKomiteHelper
    |----------------------------------------------------------------------
    |
*/

if (!function_exists('BendaharaKomiteHelper')) {
    function BendaharaKomiteHelper($param = null) {
        return "Helper BendaharaKomiteHelper dijalankan dengan param: " . json_encode($param);
    }
}