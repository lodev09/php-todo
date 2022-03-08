<?php

define('__DEV__', getenv('ENVIRONMENT') === 'dev');
define('__TEST__', getenv('ENVIRONMENT') === 'test');
define('__LOCAL__', getenv('LOCAL_DEV') === 'true');

// db
define('DB_PATH', getenv('DB_PATH'));

// app info
define('APP_TITLE', getenv('APP_TITLE'));
define('APP_DESCRIPTION', getenv('APP_DESCRIPTION'));

// get app version
$composer_json = json_decode(file_get_contents(ROOT_PATH.'/composer.json'));
define('APP_VERSION', $composer_json ? $composer_json->version : 1);
