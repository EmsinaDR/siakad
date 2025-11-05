<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper ReaderDeviceHelper
    |----------------------------------------------------------------------
    |
*/

if (!function_exists('getClientIp')) {
    function getClientIp()
    {
        return request()->ip();
    }
}

if (!function_exists('getUserAgent')) {
    function getUserAgent()
    {
        return request()->header('User-Agent');
    }
}
if (!function_exists('getIp')) {
    function getIp()
    {
        $ip = request()->ip();
        // Jika IPv6 localhost (::1), ubah jadi IPv4 localhost
        return $ip === '::1' ? '127.0.0.1' : $ip;
    }
}

if (!function_exists('getDeviceName')) {
    function getDeviceName()
    {
        $agent = strtolower(request()->userAgent());

        // Urutan penting
        if (preg_match('/android/i', $agent)) {
            return 'Android';
        }
        if (preg_match('/iphone/i', $agent)) {
            return 'iPhone';
        }
        if (preg_match('/ipad/i', $agent)) {
            return 'iPad';
        }
        if (preg_match('/windows/i', $agent)) {
            return 'Windows';
        }
        if (preg_match('/macintosh|mac os/i', $agent)) {
            return 'MacOS';
        }
        if (preg_match('/linux/i', $agent)) {
            return 'Linux';
        }

        return 'Unknown';
    }
}

if (!function_exists('getMapPosition')) {
    function getMapPosition(): array
    {
        // nanti nilainya diisi dari request POST fetch di atas
        return [
            'lat' => request()->input('lat'),
            'lng' => request()->input('lng'),
        ];
    }
}
if (!function_exists('getMapPositionString')) {
    function getMapPositionString(): string
    {
        $pos = getMapPosition();
        return $pos['lat'] . ', ' . $pos['lng'];
    }
}
