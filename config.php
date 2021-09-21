<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'Moodle';
$CFG->dbuser    = 'admin';
$CFG->dbpass    = 'moodle_repo';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => '',
  'dbsocket' => '',
  'dbcollation' => 'utf8_general_ci',
);

$CFG->wwwroot   = 'http://localhost:8888/moodle_repo';
$CFG->dataroot  = '/Applications/MAMP/moodledata';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!

//=================
// PHPUNIT SUPPORT
//=================
$CFG->phpunit_dbtype    = 'mysqli';      // 'pgsql', 'mariadb', 'mysqli', 'mssql', 'sqlsrv' or 'oci'
$CFG->phpunit_dblibrary = 'native';     // 'native' only at the moment
$CFG->phpunit_dbhost    = 'localhost';  // eg 'localhost' or 'db.isp.com' or IP
$CFG->phpunit_dbname    = 'moodle_test';     // database name, eg moodle
$CFG->phpunit_dbuser    = 'admin';   // your database username
$CFG->phpunit_dbpass    = 'moodle_repo';   // your database password

$CFG->phpunit_prefix = 'phpu_';
$CFG->phpunit_dataroot = '/Applications/MAMP/moodletestdata';

//=================
// PREVENT JS CACHING
//=================
$CFG->cachejs = false;
