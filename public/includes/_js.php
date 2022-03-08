<?php

$core = [
    'jquery' => 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js',
    'js/app.js'
];

$libs = array_merge($core, !empty($_js) ? array_filter($_js) : []);
foreach ($libs as $index => $path) {
    $attrs = null;
    if (is_int($index)) $source = ASSETS_URL.'/'.$path.'?v='.(defined('APP_VERSION') ? slugify(base64_encode(APP_VERSION)) : null);
    else {
        $path = is_array($path) ? $path : [$path];
        $source = $path[0];
        $attrs = $path[1] ?? '';
    }

    echo '<script src="'.$source.'" '.$attrs.'></script>'.EOL;
}
