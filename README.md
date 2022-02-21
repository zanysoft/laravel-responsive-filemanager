# Laravel-Responsive-FileManager

[![Downloads](https://img.shields.io/packagist/dt/Snowsoft/laravel-responsive-filemanager.svg?style=flat-square)](https://packagist.org/packages/Snowsoft/laravel-responsive-filemanager)
[![GitHub license](https://img.shields.io/badge/License-MIT-informational.svg)](https://github.com/Snowsoft/laravel-responsive-filemanager/blob/master/LICENSE)
[![GitHub license](https://img.shields.io/badge/Licence-CC%20BY%20NC%203.0-informational.svg)](https://creativecommons.org/licenses/by-nc/3.0/)
[![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-informational.svg)](https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity)
[![GitHub tag](https://img.shields.io/github/tag/Snowsoft/laravel-responsive-filemanager.svg?style=flat&logo=laravel&color=informational)](https://github.com/Snowsoft/laravel-responsive-filemanager/tags)

 

This repo is under MIT Licence except parts where antoher licence is mentioned in file.

The Laravel plugin code part here is under **MIT Licence**.

*The RFM author delivers a commercial version of his code (a modified ```include.js```). You will need to modify this file if you use CSRF check on your laravel app by adding ```_token: jQuery('meta[name="csrf-token"]').attr('content')``` on ajax calls. You can use [www.diffchecker.com](https://www.diffchecker.com) to check modifications you will have to apply to your ```include.commercial.js``` file. I can't deliver myself a licence to use RFM for commercial purpose*

__**If you have some corrections, recommendations or anything else to say please let me know.**__

**__[Read Responsive File Manager Documentation](https://responsivefilemanager.com/index.php#documentation-section)__**

___

## **How to Install ?**

### *Install in your project*

    composer require Snowsoft/laravel-responsive-filemanager

Now there is a new configuration file ```rfm.php```

Install in ```config/app.php```

    'providers' => [
            /*
             * Laravel Framework Service Providers...
             */
            ...
            // Responsive File Manager
            Snowsoft\ResponsiveFileManager\FileManagerServiceProvider::class
    ],

In ```app/Http/Kernel.php``` need to use StartSession, can also use and is recommended CSRF Token

    protected $middlewareGroups = [
        ...
        'web' => [
            ...
            \Illuminate\Session\Middleware\StartSession::class,
            // Responsive File Manager supports CSRF Token usage
            \App\Http\Middleware\VerifyCsrfToken::class
        ]
        ...
    ];

then do

    php artisan vendor:publish --provider="Snowsoft\ResponsiveFileManager\FileManagerServiceProvider"

Generate private key for url identification

    php artisan rfm:generate

All configs included to work out of the box.
Files are meant to be stored in public folder.

**Don't forget to set upload dir in config file**

    $upload_dir = 'media/';
    $thumbs_upload_dir = 'thumbs/'; //this will create inside upload directory
    
**Set route prefix in config file**

    'route_prefix' => 'filemanager/',
    //or
    'route_prefix' => 'admin/filemanager/',  
      
**Set middleware in config file for security purpose**

    'middleware' => 'auth', //defaualt is web
    
___

### Use as StandAlone

*Use helpers to write filemanager url*

    <a href="@filemanager_get_resource(dialog.php)?field_id=imgField&lang=en_EN&akey=@filemanager_get_key()">Open RFM</a>
    // OR
    <a href="@filemanager_dialog(['field_id'=>'imgField'])">Open RFM</a>    
    // OR
    <a href="@filemanager_dialog()">Open RFM</a>

see ```USE AS STAND-ALONE FILE MANAGER``` in Responsible [File Manager Doc](https://responsivefilemanager.com/index.php#documentation-section)

___

### Include in TinyMCE or CKEDITOR

#### *Include JS*

- **For CKEditor**

__**Replace #MYTEXTAREAJS with your textarea input**__

    <script src='{{ asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}'></script>
    <script>
        $(document).ready(function() {
            if($("#MYTEXTAREAID").length) {
                CKEDITOR.replace( 'postBody', {
                    filebrowserBrowseUrl : '@filemanager_get_resource(dialog.php)?akey=@filemanager_get_key()&type=2&editor=ckeditor&fldr=',
                    filebrowserUploadUrl : '@filemanager_get_resource(dialog.php)?akey=@filemanager_get_key()&type=2&editor=ckeditor&fldr=',
                    filebrowserImageBrowseUrl : '@filemanager_get_resource(dialog.php)?akey=@filemanager_get_key()&type=1&editor=ckeditor&fldr=',
                    language : '<?php App::getLocale() ?>'
                });
            }
        })
    </script>

- **For TinyMCE**

with tinymce parameters

    $(document).ready(() => {
        $('textarea').first().tinymce({
            script_url : '/tinymce/tinymce.min.js',
            width: 680,height: 300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor filemanager code"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
        image_advtab: true ,
        filemanager_access_key: '@filemanager_get_key()',
        filemanager_relative_url: true,
        filemanager_sort_by: '',
        filemanager_descending: '',
        filemanager_subfolder: '',
        filemanager_crossdomain: '',
        external_filemanager_path: '@filemanager_get_resource(dialog.php)',
        filemanager_title:"Responsive Filemanager" ,
        external_plugins: { "filemanager" : "/vendor/responsivefilemanager/plugin.min.js"}
        });
    });

**To make private folder use .htaccess with ```Deny from all```**