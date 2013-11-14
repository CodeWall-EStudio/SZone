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

//演示环境
$db['testing']['hostname'] = 'localhost';
$db['testing']['username'] = 'szone';
$db['testing']['password'] = 'x5ueUquSZaEzFmAQ';
$db['testing']['database'] = 'szone';
$db['testing']['dbdriver'] = 'mysql';
$db['testing']['dbprefix'] = '';
$db['testing']['pconnect'] = TRUE;
$db['testing']['db_debug'] = TRUE;
$db['testing']['cache_on'] = FALSE;
$db['testing']['cachedir'] = '';
$db['testing']['char_set'] = 'utf8';
$db['testing']['dbcollat'] = 'utf8_general_ci';
$db['testing']['swap_pre'] = '';
$db['testing']['autoinit'] = TRUE;
$db['testing']['stricton'] = FALSE;

//正式环境
$db['production']['hostname'] = 'localhost';
$db['production']['username'] = 'szone';
$db['production']['password'] = 'x5ueUquSZaEzFmAQ';
$db['production']['database'] = 'szone';
$db['production']['dbdriver'] = 'mysql';
$db['production']['dbprefix'] = '';
$db['production']['pconnect'] = TRUE;
$db['production']['db_debug'] = TRUE;
$db['production']['cache_on'] = FALSE;
$db['production']['cachedir'] = '';
$db['production']['char_set'] = 'utf8';
$db['production']['dbcollat'] = 'utf8_general_ci';
$db['production']['swap_pre'] = '';
$db['production']['autoinit'] = TRUE;
$db['production']['stricton'] = FALSE;

//开发环境1
$db['codewalle']['hostname'] = 'localhost';
$db['codewalle']['username'] = 'szone';
$db['codewalle']['password'] = 't8ecnVj6RAVMcCF8';
$db['codewalle']['database'] = 'szone';
$db['codewalle']['dbdriver'] = 'mysql';
$db['codewalle']['dbprefix'] = '';
$db['codewalle']['pconnect'] = TRUE;
$db['codewalle']['db_debug'] = TRUE;
$db['codewalle']['cache_on'] = FALSE;
$db['codewalle']['cachedir'] = '';
$db['codewalle']['char_set'] = 'utf8';
$db['codewalle']['dbcollat'] = 'utf8_general_ci';
$db['codewalle']['swap_pre'] = '';
$db['codewalle']['autoinit'] = TRUE;
$db['codewalle']['stricton'] = FALSE;

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

/* End of file database.php */
/* Location: ./application/config/database.php */
