<?php

chdir(__DIR__);
require_once '../const.php';

require_once ROOT_PATH.'/root.php';
require_once ROOT_PATH.'/debug.php';

$sql = file_get_contents(ROOT_PATH.'/db/todo.sql');
$db = new \Models\DB(ROOT_PATH.DS.DB_PATH, null, null, null, null, \Models\DB::DRIVER_SQLITE);
$db->run($sql);

plog('OK');
