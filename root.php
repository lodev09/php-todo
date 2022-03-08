<?php

// this is the main entry point of the app.
// this assumes that composer is already installed and const.php was required

require_once ROOT_PATH.'/vendor/autoload.php';

// load configuration from .env
$dotenv = Dotenv\Dotenv::create(ROOT_PATH, '.env');
$dotenv->load();

// global functions
require_once ROOT_PATH.'/config.php';
require_once ROOT_PATH.'/lib/func.php';
