<?php

require_once 'init.php';

$errors = [404, 500, 503];

$error_code = get('code');
\App\App::includeError(in_array($error_code, $errors) ? $error_code : 500);

?>
