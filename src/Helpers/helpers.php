<?php

use Illuminate\Support\Str;

if (!function_exists('filemanager_get_key')) {

    function filemanager_get_key($encoded = true)
    {
        $key = isset(config('rfm.access_keys')[0]) ? config('rfm.access_keys')[0] : '';//phpcs:ignore
        return $encoded ? urlencode($key) : $key;
    }
}

if (!function_exists('filemanager_get_config')) {

    function filemanager_get_config($key = null)
    {
        if (Str::startsWith($key, 'rfm.')) {
            $key = str_replace('rfm.', '', $key);
        }

        if ($key) {
            return config('rfm.' . $key);
        }

        return config('rfm');
    }
}