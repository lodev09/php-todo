<?php

// Init
//
// The main entry point for the web content

chdir(__DIR__);
require_once '../const.php';

// initialize composer
$autoload_file = ROOT_PATH.'/vendor/autoload.php';
if (!file_exists($autoload_file)) {
	include_once APP_PATH.'/_install.php';
	exit;
}

// Check for the config file
if (file_exists(ROOT_PATH.'/.env') === false) {
    include_once APP_PATH.'/_config.php';
    exit;
}

require_once ROOT_PATH.'/root.php';
require_once ROOT_PATH.'/debug.php';

// check folder permissions
if (!is_writable(ROOT_PATH)) {
	include_once APP_PATH.'/_permissions.php';
	exit;
}

// initialize database
try {
    require_once ROOT_PATH.'/db.php';
} catch (Exception $ex) {
    $_db_error = $ex->getMessage();
    include_once APP_PATH.'/_database.php';
    exit;
}
