<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| SZone SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed for szone app.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
*/


//文件上传相关配置
$config['upload-folds'] = 'file';
$config['upload-path'] = ROOTPATH.'../'.$config['upload-folds'].'/';
$config['dir-file-num'] = 512;

//上传类型
$config['filetype']['jpg'] = 1;   //图片
$config['filetype']['gif'] = 1;
$config['filetype']['png'] = 1;
$config['filetype']['jpeg'] = 1;
$config['filetype']['txt'] = 2;   //文档
$config['filetype']['doc'] = 2;
$config['filetype']['mid'] = 3;   //音乐
$config['filetype']['mp3'] = 3;
$config['filetype']['avi'] = 4;   //视频
$config['filetype']['mp4'] = 4;
$config['filetype']['exe'] = 5;   //应用
$config['filetype']['zip'] = 6;   //压缩包
$config['filetype']['rar'] = 6;   //压缩包

//分页数
$config['pagenum'] = 10;


$mime = array (
    //applications
    'ai'    => 'application/postscript',
    'eps'   => 'application/postscript',
    'exe'   => 'application/octet-stream',
    'doc'   => 'application/vnd.ms-word',
    'xls'   => 'application/vnd.ms-excel',
    'ppt'   => 'application/vnd.ms-powerpoint',
    'pps'   => 'application/vnd.ms-powerpoint',
    'pdf'   => 'application/pdf',
    'xml'   => 'application/xml',
    'odt'   => 'application/vnd.oasis.opendocument.text',
    'swf'   => 'application/x-shockwave-flash',
    // archives
    'gz'    => 'application/x-gzip',
    'tgz'   => 'application/x-gzip',
    'bz'    => 'application/x-bzip2',
    'bz2'   => 'application/x-bzip2',
    'tbz'   => 'application/x-bzip2',
    'zip'   => 'application/zip',
    'rar'   => 'application/x-rar',
    'tar'   => 'application/x-tar',
    '7z'    => 'application/x-7z-compressed',
    // texts
    'txt'   => 'text/plain',
    'php'   => 'text/x-php',
    'html'  => 'text/html',
    'htm'   => 'text/html',
    'js'    => 'text/javascript',
    'css'   => 'text/css',
    'rtf'   => 'text/rtf',
    'rtfd'  => 'text/rtfd',
    'py'    => 'text/x-python',
    'java'  => 'text/x-java-source',
    'rb'    => 'text/x-ruby',
    'sh'    => 'text/x-shellscript',
    'pl'    => 'text/x-perl',
    'sql'   => 'text/x-sql',
    // images
    'bmp'   => 'image/x-ms-bmp',
    'jpg'   => 'image/jpeg',
    'jpeg'  => 'image/jpeg',
    'gif'   => 'image/gif',
    'png'   => 'image/png',
    'tif'   => 'image/tiff',
    'tiff'  => 'image/tiff',
    'tga'   => 'image/x-targa',
    'psd'   => 'image/vnd.adobe.photoshop',
    //audio
    'mp3'   => 'audio/mpeg',
    'mid'   => 'audio/midi',
    'ogg'   => 'audio/ogg',
    'mp4a'  => 'audio/mp4',
    'wav'   => 'audio/wav',
    'wma'   => 'audio/x-ms-wma',
    // video
    'avi'   => 'video/x-msvideo',
    'dv'    => 'video/x-dv',
    'mp4'   => 'video/mp4',
    'mpeg'  => 'video/mpeg',
    'mpg'   => 'video/mpeg',
    'mov'   => 'video/quicktime',
    'wm'    => 'video/x-ms-wmv',
    'flv'   => 'video/x-flv',
    'mkv'   => 'video/x-matroska'
);

/* End of file szone.php */
/* Location: ./application/config/szone.php */