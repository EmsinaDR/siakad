<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper SyncHelper
    |----------------------------------------------------------------------
    |
*/

if (!function_exists('SyncHelper')) {
    function SyncHelper($param = null) {
        return "Helper SyncHelper dijalankan dengan param: " . json_encode($param);
    }
}