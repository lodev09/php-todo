<?php

namespace Models;

class Task extends Model {

    const SORT_PRIORITY = 'priority';
    const SORT_NAME = 'name';

    public static function query($sort = self::SORT_PRIORITY) {
        $order = '';

        switch ($sort) {
            case self::SORT_NAME:
                $order = ', body, priority DESC, created_at';
                break;

            default:
                $order = ', priority DESC, created_at';
                break;
        }

        return self::select("
            SELECT *
            FROM tasks
            WHERE active = 1
            ORDER BY completed $order
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
