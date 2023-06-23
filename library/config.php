<?php
ini_set('display_errors', 'on');
//ob_start("ob_gzhandler");
//error_reporting(E_ALL);

// start the session
session_start();

// database connection config

$dbHost = '10.0.0.1:4308';
$dbUser = 'root';
$dbPass = '1234';
$dbName = 'db_event_management';




$thisFile = str_replace('\\', '/', __FILE__);
$docRoot = $_SERVER['DOCUMENT_ROOT'];

$webRoot  = str_replace(array($docRoot, 'library/config.php'), '', $thisFile);
$srvRoot  = str_replace('library/config.php', '', $thisFile);

define('WEB_ROOT', $webRoot);
define('SRV_ROOT', $srvRoot);


 
	
	if (isset($_GET)) {
		foreach ($_GET as $key => $value) {
			$_GET[$key] = trim(addslashes($value));
		}
	}


require_once 'database.php';
require_once 'common.php';

?>