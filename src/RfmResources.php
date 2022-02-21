<?php


namespace Snowsoft\ResponsiveFileManager;


class RfmResources
{
    public static $public_path = "vendor/responsivefilemanager/";

    private static $script_files = [
        'plugin.min.js'
    ];
    protected static $css_files = [
        'jquery.fileupload.css',
        'jquery.fileupload-noscript.css',
        'jquery.fileupload-ui.css',
        'jquery.fileupload-ui-noscript.css',
        'rtl-style.css',
        'style.css'
    ];

    private static $js_files = [
        'include.js',
        'jquery.fileupload.js',
        'jquery.fileupload-angular.js',
        'jquery.fileupload-audio.js',
        'jquery.fileupload-image.js',
        'jquery.fileupload-jquery-ui.js',
        'jquery.fileupload-process.js',
        'jquery.fileupload-ui.js',
        'jquery.fileupload-validate.js',
        'jquery.fileupload-video.js',
        'jquery.iframe-transport.js',
        'load_more.js',
        'modernizr.custom.js',
        'plugins.js',
    ];

    private static $js_vendor = [
        'jquery.min.js',
        'jquery.ui.widget.js',
        'jquery-ui.min.js',
    ];


    private static $images = [
        'clipboard_apply.png', 'clipboard_clear.png', 'copy.png', 'cut.png',
        'date.png', 'dimension.png', 'down.png', 'download.png', 'duplicate.png',
        'edit_img.png', 'file_edit.png', 'glyphicons-halflings-white.png',
        'glyphicons-halflings.png', 'info.png', 'key.png', 'label.png',
        'loading.gif', 'logo.png', 'preview.png', 'processing.gif', 'rename.png',
        'size.png', 'sort.png', 'storing_animation.gif', 'trans.jpg', 'up.png',
        'upload.png', 'url.png', 'zip.png'
    ];

    private static $icons = [
        'ac3.jpg', 'c4d.jpg', 'dxf.jpg', 'html.jpg', 'mov.jpg', 'odp.jpg',
        'pdf.jpg', 'sql.jpg', 'webm.jpg', 'accdb.jpg', 'css.jpg',
        'favicon.ico', 'iso.jpg', 'mp3.jpg', 'ods.jpg', 'png.jpg',
        'stp.jpg', 'wma.jpg', 'ade.jpg', 'csv.jpg', 'fla.jpg', 'jpeg.jpg',
        'mp4.jpg', 'odt.jpg', 'ppt.jpg', 'svg.jpg', 'xhtml.jpg', 'adp.jpg',
        'default.jpg', 'flv.jpg', 'jpg.jpg', 'mpeg.jpg', 'ogg.jpg', 'pptx.jpg',
        'tar.jpg', 'xls.jpg', 'aiff.jpg', 'dmg.jpg', 'folder_back.png',
        'log.jpg', 'mpg.jpg', 'otg.jpg', 'psd.jpg', 'tiff.jpg', 'xlsx.jpg',
        'ai.jpg', 'doc.jpg', 'folder.png', 'm4a.jpg', 'odb.jpg', 'otp.jpg',
        'rar.jpg', 'txt.jpg', 'xml.jpg', 'avi.jpg', 'docx.jpg', 'gif.jpg',
        'mdb.jpg', 'odf.jpg', 'ots.jpg', 'rtf.jpg', 'vwx.jpg', 'zip.jpg',
        'bmp.jpg', 'dwg.jpg', 'gz.jpg', 'mid.jpg', 'odg.jpg', 'ott.jpg',
        'skp.jpg', 'wav.jpg'
    ];

    private static $icons_dark = [
        'ac3.jpg', 'css.jpg', 'flv.jpg', 'jpg.jpg', 'mpeg.jpg', 'ogg.jpg',
        'pptx.jpg', 'txt.jpg', 'zip.jpg', 'accdb.jpg', 'csv.jpg',
        'folder_back.png', 'log.jpg', 'mpg.jpg', 'otg.jpg', 'psd.jpg',
        'wav.jpg', 'ade.jpg', 'default.jpg', 'folder.png', 'm4a.jpg',
        'odb.jpg', 'otp.jpg', 'rar.jpg', 'webm.jpg', 'adp.jpg', 'dmg.jpg',
        'gif.jpg', 'mdb.jpg', 'odf.jpg', 'ots.jpg', 'rtf.jpg', 'wma.jpg',
        'aiff.jpg', 'doc.jpg', 'gz.jpg', 'mid.jpg', 'odg.jpg', 'ott.jpg',
        'sql.jpg', 'xhtml.jpg', 'ai.jpg', 'docx.jpg', 'html.jpg', 'mov.jpg',
        'odp.jpg', 'pdf.jpg', 'svg.jpg', 'xls.jpg', 'avi.jpg', 'favicon.ico',
        'iso.jpg', 'mp3.jpg', 'ods.jpg', 'png.jpg', 'tar.jpg', 'xlsx.jpg',
        'bmp.jpg', 'fla.jpg', 'jpeg.jpg', 'mp4.jpg', 'odt.jpg', 'ppt.jpg',
        'tiff.jpg', 'xml.jpg'
    ];

    private static $svg_images = [
        'icon-a.svg', 'icon-b.svg', 'icon-c.svg',
        'icon-d.svg', 'svg.svg'
    ];

    public static function getTinymcePluginFile()
    {
        return self::$public_path . 'tinymce/plugins/responsivefilemanager/plugin.min.js';
    }

    public static function getResourceFiles($file = null)
    {
        $FM_VENDOR_PREP = [
            '/' => self::$script_files,
            'css/' => self::$css_files,
            'js/' => self::$js_files,
            'js/vendor/' => self::$js_vendor,
            'img/' => self::$images,
            'img/ico/' => self::$icons,
            'img/ico_dark/' => self::$icons_dark,
            'svg/' => self::$svg_images,
        ];

        $FM_VENDOR = [];

        foreach ($FM_VENDOR_PREP as $folder_path => $file_table) {
            foreach ($file_table as $_file) {
                $FM_VENDOR[$_file] = self::$public_path . $folder_path . $_file;
            }
        }

        if ($file) {
            return isset($FM_VENDOR[$file]) ? $FM_VENDOR[$file] : '';
        }

        return $FM_VENDOR;
    }
}
