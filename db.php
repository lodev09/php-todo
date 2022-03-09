<?php

/**
 * Load db models
 * @see https://github.com/lodev09/php-models
 */

$db_path = ROOT_PATH.DS.DB_PATH;
$blank_db = file_exists($db_path) === false;

\Models\Model::connect($db_path, null, null, null, null, \Models\DB::DRIVER_SQLITE);
\Models\Model::$debug = __DEV__ || __TEST__;

// Auto load tables if db is missing
if ($blank_db) {
    $sql = file_get_contents(ROOT_PATH.'/db/todo.sql');
    \Models\Model::$db->run($sql);
}

// Configure models
\Models\Task::register('tasks');
