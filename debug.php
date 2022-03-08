<?php

if (!(__DEV__ || __TEST__)) return;

ini_set('error_reporting', false);
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    print_debug($errno, $errstr, $errfile, $errline);
});

register_shutdown_function(function() {
    if ($error = error_get_last()) {
        print_debug(get('type', $error), get('message', $error), get('file', $error), get('line', $error));
    }
});

function debug_text($text, $color = 'warning') {
    $is_cli = \Common\Util::isCli();
    $is_ajax = \Common\Util::isAjax();
    $is_pjax = \Common\Util::isPjax();

    $content_type = get_header('Content-Type', headers_list());
    if ($content_type === 'application/json') return $text;

    if ($is_cli) {
        $colors = [
            'danger' => '31',
            'primary' => '95',
            'light' => '90',
            'warning' => '93'
        ];

        if (isset($colors[$color])) {
            $color = $colors[$color];
            $text = "\033[{$color}m$text\033[0m";
        }

        return $text;
    }

    return '<span class="text-'.$color.'">'.$text.'</span>';
}

function print_debug($errno, $errstr, $errfile, $errline) {
    // $errno = $errno & error_reporting();
    if ($errno == 0) return;

    \Common\Util::setStatus($errno > 1 ? $errno : 500);

    if (!defined('E_STRICT'))            define('E_STRICT', 2048);
    if (!defined('E_RECOVERABLE_ERROR')) define('E_RECOVERABLE_ERROR', 4096);

    switch ($errno) {
        case E_ERROR:               $error = 'Error';                  break;
        case E_WARNING:             $error = 'Warning';                break;
        case E_PARSE:               $error = 'Parse Error';            break;
        case E_NOTICE:              $error = 'Notice';                 break;
        case E_CORE_ERROR:          $error = 'Core Error';             break;
        case E_CORE_WARNING:        $error = 'Core Warning';           break;
        case E_COMPILE_ERROR:       $error = 'Compile Error';          break;
        case E_COMPILE_WARNING:     $error = 'Compile Warning';        break;
        case E_USER_ERROR:          $error = 'User Error';             break;
        case E_USER_WARNING:        $error = 'User Warning';           break;
        case E_USER_NOTICE:         $error = 'User Notice';            break;
        case E_STRICT:              $error = 'Strict Notice';          break;
        case E_RECOVERABLE_ERROR:   $error = 'Recoverable Error';      break;
        default:                    $error = 'Unknown error ('.$errno.')'; break;
    }
    $message = $error.': '.debug_text($errstr).' at '.debug_text($errfile, 'white').debug_text(':'.$errline, 'white font-weight-bold').PHP_EOL.PHP_EOL;
    if (function_exists('debug_backtrace')) {
        $backtrace = debug_backtrace();
        array_shift($backtrace);
        foreach ($backtrace as $i => $l) {
            $message .= debug_text('['.$i.']', 'light').' in '.debug_text((isset($l['class']) ? $l['class'] : '').(isset($l['type']) ? $l['type'] : '').$l['function']);
            if (isset($l['file'])) $message .= ' at '.debug_text($l['file'], 'white');
            if (isset($l['line'])) $message .= debug_text(':'.$l['line'], 'white font-weight-bold');
            $message .= PHP_EOL;
        }
    }

    plog($message);
}
