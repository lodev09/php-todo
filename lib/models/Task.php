<?php

namespace Models;

class Task extends Model {

    public static function query() {
        return self::select("
            SELECT *
            FROM tasks
            WHERE active = 1
            ORDER BY priority DESC
        ");
    }

    public function get() {
        $data = $this->toArray(['id', 'priority', 'body', 'created_at']);
        return $data;
    }
}
