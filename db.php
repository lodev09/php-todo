<?php

// https://github.com/lodev09/php-models
\Models\Model::connect(ROOT_PATH.DS.DB_PATH, null, null, null, null, \Models\DB::DRIVER_SQLITE);
\Models\Model::$debug = __DEV__ || __TEST__;

// configure models
\Models\Todo::register('todos');
