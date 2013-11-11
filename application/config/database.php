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

//echo ENVIRONMENT;
//$active_group = 'default';
//$active_group = 'development';
$active_group = ENVIRONMENT;
$active_record = TRUE;


//正式环境
$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'szone';
$db['default']['password'] = 'x5ueUquSZaEzFmAQ';
$db['default']['database'] = 'szone';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

//开发环境1
$db['lifeclaw']['hostname'] = 'localhost';
$db['lifeclaw']['username'] = 'root';
$db['lifeclaw']['password'] = 'bka113';
$db['lifeclaw']['database'] = 'szone';
$db['lifeclaw']['dbdriver'] = 'mysql';
$db['lifeclaw']['dbprefix'] = '';
$db['lifeclaw']['pconnect'] = TRUE;
$db['lifeclaw']['db_debug'] = TRUE;
$db['lifeclaw']['cache_on'] = FALSE;
$db['lifeclaw']['cachedir'] = '';
$db['lifeclaw']['char_set'] = 'utf8';
$db['lifeclaw']['dbcollat'] = 'utf8_general_ci';
$db['lifeclaw']['swap_pre'] = '';
$db['lifeclaw']['autoinit'] = TRUE;
$db['lifeclaw']['stricton'] = FALSE;

//开发环境2
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

//开发环境2
// $db['development']['hostname'] = 'localhost';
// $db['development']['username'] = 'root';
// $db['development']['password'] = 'bka113';
// $db['development']['database'] = 'szone';
// $db['development']['dbdriver'] = 'mysql';
// $db['development']['dbprefix'] = '';
// $db['development']['pconnect'] = TRUE;
// $db['development']['db_debug'] = TRUE;
// $db['development']['cache_on'] = FALSE;
// $db['development']['cachedir'] = '';
// $db['development']['char_set'] = 'utf8';
// $db['development']['dbcollat'] = 'utf8_general_ci';
// $db['development']['swap_pre'] = '';
// $db['development']['autoinit'] = TRUE;
// $db['development']['stricton'] = FALSE;


//演示环境
$db['live']['hostname'] = 'localhost';
$db['live']['username'] = 'root';
$db['live']['password'] = 'bka113';
$db['live']['database'] = 'szone';
$db['live']['dbdriver'] = 'mysql';
$db['live']['dbprefix'] = '';
$db['live']['pconnect'] = TRUE;
$db['live']['db_debug'] = TRUE;
$db['live']['cache_on'] = FALSE;
$db['live']['cachedir'] = '';
$db['live']['char_set'] = 'utf8';
$db['live']['dbcollat'] = 'utf8_general_ci';
$db['live']['swap_pre'] = '';
$db['live']['autoinit'] = TRUE;
$db['live']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */
