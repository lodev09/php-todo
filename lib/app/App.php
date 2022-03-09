<?php

namespace App;

use \Common\Util;
use \Models\Model;

class App {

    /**
     * Creates a new Task
     *
     * @param  string  $body
     * @param  boolean $priority
     * @return Task
     */
    public static function newTask($body, $priority = false) {
        return \Models\Task::insert([
            'body' => $body,
            'priority' => $priority ? 1 : 0
        ]);
    }

    /**
     * Get list of tasks
     * @return array
     */
    public static function getTasks() {
        return \Models\Task::query();
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

    /**
     * Error 404
     *
     * @param  string $message
     * @param  string $redirect
     * @return void
     */
    public static function error404($message = null, $redirect = null) {
        self::includeError(404, $message, $redirect);
    }
}
