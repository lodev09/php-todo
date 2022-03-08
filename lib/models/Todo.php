<?php

namespace Models;

class Todo extends Model {

    public static function query() {
        return self::select("SELECT * FROM todos");
    }

    public function get() {
        $data = $this->toArray(['id', 'created_at']);
        return $data;
    }
}
