<?php
$FM_ROUTES = [
    'ajax_calls.php' => ['get', 'post'],
    'dialog.php' => ['get'],
    'dialog' => ['get'],
    'execute.php' => ['post'],
    'force_download.php' => ['post'],
    'fview.php' => ['get'],
    'upload.php' => ['get', 'post']];

require_once __DIR__ . '/boot.php';

$middleware = config('rfm.middleware', 'web');
$route_prefix = config('rfm.route_prefix', 'filemanager/');

// Routes For Responsive API and Web (dialog.php)
if ($middleware == 'auth') {
    Route::group(['middleware' => 'web'], function () use ($route_prefix, $FM_ROUTES, $middleware) {
        Route::group(['middleware' => $middleware], function () use ($route_prefix, $FM_ROUTES) {
            foreach ($FM_ROUTES as $file => $method) {
                $file = \Illuminate\Support\Str::endsWith($file, '.php') ? $file : $file . '.php';

                Route::match($method, $route_prefix . $file, function () use ($file) {
                    include __DIR__ . '/../Http/' . $file;
                    return;
                })->name('filemanager.' . $file);
            }
        });
    });
} else {
    Route::group(['middleware' => $middleware], function () use ($route_prefix, $FM_ROUTES) {
        foreach ($FM_ROUTES as $file => $method) {
            $file = \Illuminate\Support\Str::endsWith($file, '.php') ? $file : $file . '.php';

            Route::match($method, $route_prefix . $file, function () use ($file) {
                include __DIR__ . '/../Http/' . $file;
                return;
            })->name('filemanager.' . $file);
        }
    });
}
