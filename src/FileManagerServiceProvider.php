<?php

namespace Snowsoft\ResponsiveFileManager;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class FileManagerServiceProvider extends ServiceProvider
{
    protected $commands = [
        'Snowsoft\ResponsiveFileManager\Commands\RFMGenerate'
    ];


    /**
     * Overwrite any vendor / package configuration.
     *
     * This service provider is intended to provide a convenient location for you
     * to overwrite any "vendor" or package configuration that you may want to
     * modify before the application handles the incoming request / command.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);

        require_once 'Helpers/helpers.php';
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Publish all static ressources
         */
        $FMPRIVPATH = "/../resources/filemanager/";
        $FMPUBPATH = "vendor/responsivefilemanager/";

        $FM_PUBLISH = [];
        $FM_PUBLISH[__DIR__ . $FMPRIVPATH . 'config/config.php'] = config_path('rfm.php');//phpcs:ignore
        $FM_PUBLISH[__DIR__ . $FMPRIVPATH . '/plugin.min.js'] = public_path($FMPUBPATH . '/plugin.min.js');//phpcs:ignore
        $FM_PUBLISH[__DIR__ . $FMPRIVPATH . '/css'] = public_path($FMPUBPATH . '/css');//phpcs:ignore
        $FM_PUBLISH[__DIR__ . $FMPRIVPATH . '/img'] = public_path($FMPUBPATH . '/img');//phpcs:ignore
        $FM_PUBLISH[__DIR__ . $FMPRIVPATH . '/js'] = public_path($FMPUBPATH . '/js');//phpcs:ignore
        $FM_PUBLISH[__DIR__ . $FMPRIVPATH . '/svg'] = public_path($FMPUBPATH . '/svg');//phpcs:ignore
        $FM_PUBLISH[__DIR__ . $FMPRIVPATH . '/tinymce'] = public_path($FMPUBPATH . '/tinymce');//phpcs:ignore
        $FM_PUBLISH[__DIR__ . '/I18N'] = resource_path('lang/vendor/rfm');
        $this->publishes($FM_PUBLISH);

        sleep(1);

        $config = \Config::get('rfm');

        if (!empty($config)) {
            $config['base_url'] = trim($config['base_url'], '/') . '/';
            $config['upload_dir'] = $upload_dir = $this->fixPath($config['upload_dir'], true) . '/';
            $config['current_path'] = $current_path = $this->fixPath($config['current_path'], true) . '/';
            $config['thumbs_upload_dir'] = $thumbs_upload_dir = $this->fixPath($config['thumbs_upload_dir'], true) . '/';
            $config['thumbs_base_path'] = $thumbs_base_path = $this->fixPath($config['thumbs_base_path'], true) . '/';

            if (!Str::startsWith($thumbs_upload_dir, $upload_dir)) {
                $config['thumbs_upload_dir'] = $thumbs_upload_dir = $upload_dir . $thumbs_upload_dir;
            }

            if (!Str::startsWith($thumbs_base_path, $upload_dir)) {
                $config['thumbs_base_path'] = $thumbs_base_path = $upload_dir . $thumbs_base_path;
            }

            \Config::set('rfm', $config);

            $this->createDir($upload_dir, $config);
            $this->createDir($current_path, $config);
            $this->createDir($thumbs_upload_dir, $config);
            $this->createDir($thumbs_base_path, $config);
        }

        // Add package routes.
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        $this->loadJsonTranslationsFrom(__DIR__ . '/I18N');


        /**
         * Blade print
         */
        Blade::directive('filemanager_assets', function ($file) use ($FMPUBPATH) {
            return url($FMPUBPATH . '/' . trim($file, '/'));
        });

        Blade::directive('external_filemanager_path', function ($file) use ($FMPUBPATH) {
            return "<?php echo external_filemanager_path({$file}); ?>";
        });

        Blade::directive('filemanager_get_key', function () {
            return filemanager_get_key();
        });

        Blade::directive('filemanager_get_config', function ($expression) {
            if ($expression) {
                $expression = trim($expression, '"\'');
            }
            return filemanager_get_config($expression);
        });

        Blade::directive('filemanager_get_resource', function ($expression) {
            if ($expression) {
                $expression = trim($expression, '"\'');
            }
            return "<?php echo filemanager_get_resource('{$expression}'); ?>";
        });

        Blade::directive('filemanager_get_asset', function ($expression) {
            if ($expression) {
                $expression = trim($expression, '"\'');
            }
            return "<?php echo filemanager_get_asset('{$expression}'); ?>";
        });

        Blade::directive('filemanager_dialog', function ($params) {
            return filemanager_dialog($params);
        });

        Blade::directive('filemanager_tinymce_plugin', function () {
            return filemanager_tinymce_plugin();
        });
    }

    protected function createDir($path, $config = null)
    {

        $this->fixPath($path, true);

        if (!Str::startsWith($path, public_path())) {
            $path = public_path($path);
        }

        if (file_exists($path)) {
            return false;
        }

        $oldumask = umask(0);
        $permission = 0755;
        $output = false;
        if (isset($config['folderPermission'])) {
            $permission = $config['folderPermission'];
        }
        if ($path && !file_exists($path)) {
            $output = mkdir($path, $permission, true);
        } // or even 01777 so you get the sticky bit set

        umask($oldumask);

        return $output;
    }

    protected function fixPath($str, $trim_slash = false)
    {
        $str = str_replace('\\', '/', $str);
        $str = str_replace('//', '/', $str);

        if ($trim_slash) {
            $str = trim($str, '/');
        }

        return $str;
    }
}
