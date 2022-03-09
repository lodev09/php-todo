<?php

namespace Models;

class Task extends Model {

    public static function query() {
        return self::select("
            SELECT *
            FROM tasks
            WHERE active = 1
            ORDER BY completed, priority DESC, body
        ");
    }

    public function prioritize() {
        return $this->update('priority', 1);
    }

    public function complete() {
        return $this->update('completed', 1);
    }

    public function isPriority() {
        return $this->priority ? true : false;
    }

    public function isCompleted() {
        return $this->completed ? true : false;
    }

    public function get() {
        $data = $this->toArray(['id', 'priority', 'completed', 'body', 'created_at']);
        return $data;
    }
}
