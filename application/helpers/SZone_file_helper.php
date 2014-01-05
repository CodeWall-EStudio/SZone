<?php
/**
 * Created by IntelliJ IDEA.
 * User: code
 * Date: 11/21/13
 * Time: 14:47
 * To change this template use File | Settings | File Templates.
 */

/**
 * Create a Directory Map
 *
 * Reads the specified directory and builds an array
 * representation of it.  Sub-folders contained with the
 * directory will be mapped as well.
 *
 * @access	public
 * @param	string	path to source
 * @param	int		depth of directories to traverse (0 = fully recursive, 1 = current dir, etc)
 * @return	array
 */
if ( ! function_exists('format_size'))
{
    function format_size($size)
    {
        $prec = 3;
        $size = round(abs($size));
        $units = array(
            0 => " B ",
            1 => " KB",
            2 => " MB",
            3 => " GB",
            4 => " TB"
        );
        if ($size == 0)
        {
            return str_repeat(" ", $prec) . "0$units[0]";
        }
        $unit = min(4, floor(log($size) / log(2) / 10));
        $size = $size * pow(2, -10 * $unit);
        $digi = $prec - 1 - floor(log($size) / log(10));
        $size = round($size * pow(10, $digi)) * pow(10, -$digi);
        return $size . $units[$unit];
    }

}


if ( ! function_exists('get_ext_type')){
    function get_ext_type($mimes){
        echo $mimes;
        switch($mimes)
        {        
            case 'application/x-gzip':
                return 'gz';
            case 'application/x-bzip2':
                return 'bz';
            case 'application/zip':
                return 'zip';
            case 'application/x-rar':
                return 'rar';
            case 'application/x-7z-compressed':
                return '7z';
            // documents
            case 'application/postscript':
                return 'ai';
            case 'application/vnd.ms-word':
            case 'application/msword':
                return 'doc';
            case 'application/vnd.ms-excel':
                return 'xls';
            case 'application/vnd.ms-powerpoint':
                return 'ppt';
            case 'application/pdf':
                return 'pdf';
            case 'application/xml':
                return 'xml';
            case 'application/vnd.oasis.opendocument.text':
                return 'odt';
            case 'application/x-shockwave-flash':
                return 2;
            // texts
            case 'text/plain':
                return 'txt';
            case 'text/x-php':
                return 'php';
            case 'text/html':
                return 'html';
            case 'text/javascript':
                return 'js';
            case 'text/css':
                return 'css';
            case 'text/rtf':
                return 'rtf';
            case 'text/rtfd':
                return 'rtfd';
            case 'text/x-python':
                return 'py';
            case 'text/x-java-source':
                return 'java';
            case 'text/x-ruby':
                return 'rb';
            case 'text/x-shellscript':
                return 'sh';
            case 'text/x-perl':
                return 'pl';
            case 'text/x-sql':
                return 'sql';
                // images
            case 'image/x-ms-bmp':
                return 'bmp';
            case 'image/jpeg':
                return 'jpg';
            case 'image/gif':
                return 'gif';
            case 'image/png':
                return 'png';
            case 'image/tiff':
                return 'tif';
            case 'image/x-targa':
                return 'tga';
            case 'image/vnd.adobe.photoshop':
                return 'psd';
                //audio
            case 'audio/mpeg':
                return 'mp3';
            case 'audio/midi':
                return 'mid';
            case 'audio/ogg':
                return 'ogg';
            case 'audio/mp4':
                return 'mp4a';
            case 'audio/wav':
                return 'wav';
            case 'audio/x-ms-wma':
                return 'wma';
                // video
            case 'video/x-msvideo':
                return 'avi';
            case 'video/x-dv':
                return 'dv';
            case 'video/mp4':
                return 'mp4';
            case 'video/mpeg':
                return 'mpeg';
            case 'video/quicktime':
                return 'mov';
            case 'video/x-ms-wmv':
                return 'wm';
            case 'video/x-flv':
                return 'flv';
            case 'video/x-matroska':
                return 'mkv';
            case 'application/octet-stream':
                return 'exe';
            default:
                return '';        
        }
    }
}

if ( ! function_exists('format_type'))
{
    function format_type($mimes)
    {
        switch($mimes)
        {
            // archives
            case 'application/x-gzip':
            case 'application/x-bzip2':
            case 'application/zip':
            case 'application/x-rar':
            case 'application/x-7z-compressed':
                return 6;
            // documents
            case 'application/postscript':
            case 'application/vnd.msword':
            case 'application/vnd.ms-word':
            case 'application/vnd.ms-excel':
            case 'application/vnd.ms-powerpoint':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.template':
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.template':
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
            case 'application/vnd.openxmlformats-officedocument.presentationml.template':
            case 'application/vnd.openxmlformats-officedocument.presentationml.slideshow':
            case 'application/msword':
            case 'application/kswps':
            case 'application/pdf':
            case 'application/xml':
            case 'application/vnd.oasis.opendocument.text':
            case 'application/x-shockwave-flash':
            case 'application/vnd.openxmlformats-officedocument.wordprocessing':
            case 'application/doc':
            case 'application/macwriteii':
            case 'application/microsoft_word':
            case 'application/mswrite':
            case 'application/rtf':
            case 'application/wri':
            case 'application/x-dos_ms_word':
            case 'application/x-mswrite':
            case 'application/x-rtf':
            case 'application/x-soffice':
            case 'application/x-wri':
                return 2;
            // texts
            case 'text/plain':
            case 'text/x-php':
            case 'text/html':
            case 'text/javascript':
            case 'text/css':
            case 'text/rtf':
            case 'text/rtfd':
            case 'text/x-python':
            case 'text/x-java-source':
            case 'text/x-ruby':
            case 'text/x-shellscript':
            case 'text/x-perl':
            case 'text/x-sql':
                return 2;
                // images
            case 'image/x-ms-bmp':
            case 'image/jpeg':
            case 'image/gif':
            case 'image/png':
            case 'image/tiff':
            case 'image/x-targa':
            case 'image/vnd.adobe.photoshop':
                return 1;
                //audio
            case 'audio/mpeg':
            case 'audio/midi':
            case 'audio/ogg':
            case 'audio/mp4':
            case 'audio/wav':
            case 'audio/x-ms-wma':
                return 3;
                // video
            case 'video/x-msvideo':
            case 'video/x-dv':
            case 'video/mp4':
            case 'video/mpeg':
            case 'video/quicktime':
            case 'video/x-ms-wmv':
            case 'video/x-flv':
            case 'video/x-matroska':
                return 4;
            case 'application/octet-stream':
                return 5;
            default:
                return 0;
        }
    }

}