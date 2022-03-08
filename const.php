<?php

define('DS', DIRECTORY_SEPARATOR);
define('EOL', PHP_EOL);
define('ROOT_PATH', __DIR__);
define('PUBLIC_PATH', ROOT_PATH.DS.'public');

if (!isset($argv)) {
	$argv = [isset($_SERVER['SCRIPT_FILENAME']) ? $_SERVER['SCRIPT_FILENAME'] : __FILE__];
	$args_list = isset($_GET['argv']) && is_array($_GET['argv']) ? $_GET['argv'] : $_GET;

	foreach ($args_list as $key => $value) {
		if ($value) $argv[] = $value;
	}
}

$is_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';
$server_port = null;

if (php_sapi_name() == 'cli' || !isset($_SERVER["REQUEST_METHOD"])) {
	$document_root = realpath(PUBLIC_PATH);
	$server_name = gethostname();
	$request_uri = str_replace(DS, '/', substr($_SERVER['PHP_SELF'], strlen($document_root)));
	$request_method = 'CLI';
} else {
	$document_root = realpath($_SERVER['DOCUMENT_ROOT']);
	$server_name = $_SERVER['SERVER_NAME'];
	$server_port = $_SERVER['SERVER_PORT'];
	$request_uri = $_SERVER['REQUEST_URI'];
	$request_method = $_SERVER['REQUEST_METHOD'];

	if (!in_array($server_port, [80, 443])) {
		$server_name .= ':'.$server_port;
	}
}

$document_url = ($is_https ? 'https' : 'http').'://'.$server_name;

$app_path = $document_root;
$app_url = $document_url;

$app_uri = '/';
if (strpos(PUBLIC_PATH, $document_root) === 0) {
	$app_uri = substr(PUBLIC_PATH, strlen($document_root));
	$app_path .= $app_uri;
	$app_url .= str_replace(DS, '/', $app_uri);
}

define('DOCUMENT_ROOT', $document_root);
define('SERVER_NAME', $server_name);
define('SERVER_PORT', $server_port);
define('SERVER_URL', $document_url);
define('SERVER_REQUEST', $document_url.$request_uri);

define('REQUEST_URI', $request_uri);
define('REQUEST_METHOD', $request_method);
define('REQUEST_PATH', parse_url($request_uri, PHP_URL_PATH));
define('REQUEST_QUERY', parse_url($request_uri, PHP_URL_QUERY));
define('REQUEST_ROUTE', str_replace($app_uri, '', REQUEST_PATH));

define('APP_PATH', $app_path);
define('APP_URL', $app_url);
define('APP_URI', $app_uri);

define('ASSETS_URL', APP_URL.'/assets');
define('ASSETS_PATH', APP_PATH.DS.'assets');
define('INCLUDES_PATH', APP_PATH.DS.'includes');

define('AJAX_URL', APP_URL.'/ajax');
define('AJAX_PATH', APP_PATH.DS.'ajax');