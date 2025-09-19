<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper BendaharaBosHelper
    |----------------------------------------------------------------------
    |
*/

if (!function_exists('BendaharaBosHelper')) {
    function BendaharaBosHelper($param = null) {
        return "Helper BendaharaBosHelper dijalankan dengan param: " . json_encode($param);
    }
}