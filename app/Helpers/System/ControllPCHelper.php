<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper ControllPC
    |----------------------------------------------------------------------
    |
*/

if (!function_exists('ShutdownPC')) {
    function ShutdownPC()
    {
        $result = run_bat("executor\\pc\\shudown_komputer.exe");
        $pesan =
            "*Path  :*\n{$result['path']}\n" .
            "*File  :*\n{$result['success']}\n";
        return $pesan;
    }
}
if (!function_exists('RestartPC')) {
    function RestartPC()
    {
        $result = run_bat("executor\\pc\\restart_komputer.exe");
        $pesan =
            "*Path  :*\n{$result['path']}\n" .
            "*File  :*\n{$result['success']}\n";
        return $pesan;
    }
}
if (!function_exists('CekServices')) {
    function CekServices()
    {
        $result = run_bating("executor\\nssm\\win64\\cek_services.bat");
        // parsing hasil sc query
        $parsed = parse_service_output($result['output']);
        // buat pesan WA
        $pesan = "*Service Status:*\n";
        foreach ($parsed as $name => $status) {
            $pesan .= "- {$name}: {$status}\n";
        }
        return $pesan;
        // kirim ke WhatsApp
        // return "Helper ControllPC dijalankan dengan param: ";
    }
}
if (!function_exists('RestartServices')) {
    function RestartServices()
    {
        $result = run_bat("executor\\whatsapp\\restart_services.exe");
        $pesan =
            "*Path  :*\n{$result['path']}\n" .
            "*File  :*\n{$result['success']}\n";
        return $pesan;

        // return $pesan;
        // kirim ke WhatsApp
        // return "Helper ControllPC dijalankan dengan param: ";
    }
}
if (!function_exists('UpdateSiakad')) {
    function UpdateSiakad()
    {
        $result = run_bat("executor\\siakad\\update.exe");
        $pesan =
            "*Path  :*\n{$result['path']}\n" .
            "*File  :*\n{$result['success']}\n";
        return $pesan;

        // return $pesan;
        // kirim ke WhatsApp
        // return "Helper ControllPC dijalankan dengan param: ";
    }
}
if (!function_exists('UpdateWhatsapp')) {
    function UpdateWhatsapp()
    {
        $result = run_bat("executor\\siakad\\update.exe");
        $pesan =
            "*Path  :*\n{$result['path']}\n" .
            "*File  :*\n{$result['success']}\n";
        return $pesan;

        // return $pesan;
        // kirim ke WhatsApp
        // return "Helper ControllPC dijalankan dengan param: ";
    }
}
