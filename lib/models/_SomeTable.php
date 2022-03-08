<?php

namespace Models;

class SomeTable extends Model {

    public function get() {
        $data = $this->toArray(['id', 'created_at']);
        return $data;
    }
}