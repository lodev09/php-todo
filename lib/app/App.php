<?php

namespace App;

use \Common\Util;
use \Models\Model;

class App {
    /**
     * Get list to-do items
     * @return array
     */
    public static function getTodos() {
        return \Models\Todo::query();
    }

    /**
     * Include the error file
     *
     * @param  int $code
     * @param  string $message
     * @param  string $redirect
     *
     * @return void
     */
    public static function includeError($code, $message = '', $redirect = null) {
        if (!Util::isPjax() && !Util::isAjax()) {
            if ($redirect) redirect($redirect);
            include_once self::getInclude('_'.$code);
        } else {
            Util::setStatus($code);
            if ($message) {
                Util::setContentType('application/json');
                echo json_encode(is_string($message) ? ['message' => $message] : $message);
            }
        }
    }

    public static function getInclude($path) {
        $path = in_string('.php', $path) ? $path : $path.'.php';
        $path = INCLUDES_PATH.'/'.$path;

        if (file_exists($path)) return $path;
        else return self::getInclude('_404');
    }
}
