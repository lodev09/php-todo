<?php

/**
 * Try codes and other stuff in this file.
 * Make sure to put this somewhere secure e.g. behind public folder
 */

chdir(__DIR__);
require_once 'const.php';
require_once 'root.php';
require_once 'db.php';
require_once 'debug.php';

$options = \Common\Util::getOptions('run,r:');
if (__DEV__ && isset($options['run'])) {
    $func = $options['run'];
    plog($func());
}

if (!(__DEV__ || __TEST__)) exit;

/* ------------------- BEGIN TESTS BELOW ------------------- */
