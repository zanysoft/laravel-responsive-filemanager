<?php

use Illuminate\Support\Str;
use Snowsoft\ResponsiveFileManager\RfmResources;

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

if (!function_exists('filemanager_get_resource')) {

    function filemanager_get_resource($file, $full_url = true)
    {
        if (\Route::has('filemanager.' . $file)) {
            $r = parse_url(route('filemanager.' . $file), PHP_URL_PATH);
            if ($r) {
                return $r;
            }
        }

        $vendor_file = RfmResources::getResourceFiles($file);
        if ($vendor_file) {
            return $full_url ? asset($vendor_file) : $vendor_file;
        }
        if (config('app.debug')) {
            throw new \Exception('unkow file ' . $file . ' in Reponsive File Manager');//phpcs:ignore
        }
    }
}

if (!function_exists('filemanager_tinymce_plugin')) {
    function filemanager_tinymce_plugin()
    {
        return RfmResources::getTinymcePluginFile();
    }
}

if (!function_exists('filemanager_get_asset')) {

    function filemanager_get_asset($file)
    {
        $vendor_file = RfmResources::getResourceFiles($file);
        if ($vendor_file) {
            return asset($vendor_file);
        } else {
            return asset(RfmResources::$public_path . trim($file, '/\\'));
        }
    }
}

if (!function_exists('filemanager_dialog')) {

    function filemanager_dialog($params = [])
    {
        $config = config('rfm');
        $r = route('filemanager.dialog.php');
        if ($r) {
            if ($params) {
                eval("\$query_data = $params;");
            } else {
                $query_data = [];
            }

            if (!isset($query_data['akey'])) {
                $query_data['akey'] = filemanager_get_key();
            }

            if (!isset($query_data['type'])) {
                $query_data['type'] = 0;
            }

            if (!isset($query_data['lang'])) {
                $query_data['lang'] = config('rfm.default_language', 'en_EN');
            }
            return $r . '?' . http_build_query($query_data);
        }

        if (config('app.debug')) {
            throw new \Exception('unkow file dialog.php in Reponsive File Manager');//phpcs:ignore
        }
    }
}

if (!function_exists('external_filemanager_path')) {
    function external_filemanager_path($file = '')
    {
        $route_prefix = rtrim(config('rfm.route_prefix', 'filemanager/'), '/ ');

        $file = trim($file, '/ ');

        return rtrim(url($route_prefix . ($file ? '/' . $file : '')), '/') . '/';
    }
}
