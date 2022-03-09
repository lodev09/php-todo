<?php

chdir(__DIR__);
require_once '../init.php';

$action = get('action');
$func = str_replace('-', '_', $action);

// Include requests
include_once AJAX_PATH.'/requests.php';

// Determine the request
if (function_exists($func)) {
    // Always JSON
    \Common\Util::setContentType('application/json');

    try {
        // Call the request function
        $data = $func();

        // If string is returned, create status/message response
        if (is_string($data)) $data = ['status' => 'OK', 'message' => $data];

        echo json_encode($data);

    } catch (Exception $ex) {
        $code = $ex->getCode();
        $status = $code > 200 ? \Common\Util::getHttpStatus($code) : 'Failed to process request';
        \Common\Util::setStatus(max($code, 400));

        echo json_encode(['status' => $status, 'message' => $ex->getMessage()], __DEV__ ? JSON_PRETTY_PRINT : null);
    }

    exit;
}

// If request does not exists
// Return 404
\App\App::error404();
