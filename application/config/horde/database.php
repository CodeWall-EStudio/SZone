<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = ENVIRONMENT;
$active_record = TRUE;

//开发环境 - horde
$db['horde']['hostname'] = 'localhost';
$db['horde']['username'] = 'root';
$db['horde']['password'] = 'bka113';
$db['horde']['database'] = 'szone';
$db['horde']['dbdriver'] = 'mysql';
$db['horde']['dbprefix'] = '';
$db['horde']['pconnect'] = TRUE;
$db['horde']['db_debug'] = TRUE;
$db['horde']['cache_on'] = FALSE;
$db['horde']['cachedir'] = '';
$db['horde']['char_set'] = 'utf8';
$db['horde']['dbcollat'] = 'utf8_general_ci';
$db['horde']['swap_pre'] = '';
$db['horde']['autoinit'] = TRUE;
$db['horde']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */




// //文件上传相关配置
// $config['upload-folds'] = 'file';
// $config['upload-path'] = ROOTPATH.'../'.$config['upload-folds'].'/';
// $config['dir-file-num'] = 512;

// //上传类型
// $config['filetype']['jpg'] = 1;   //图片
// $config['filetype']['gif'] = 1;
// $config['filetype']['png'] = 1;
// $config['filetype']['jpeg'] = 1;
// $config['filetype']['txt'] = 2;   //文档
// $config['filetype']['doc'] = 2;
// $config['filetype']['mid'] = 3;   //音乐
// $config['filetype']['mp3'] = 3;
// $config['filetype']['avi'] = 4;   //视频
// $config['filetype']['mp4'] = 4;
// $config['filetype']['exe'] = 5;   //应用
// $config['filetype']['zip'] = 6;   //压缩包
// $config['filetype']['rar'] = 6;   //压缩包

// //分页数
// $config['pagenum'] = 10;
