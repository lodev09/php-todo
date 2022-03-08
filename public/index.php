<?php

require_once 'init.php';

$_title = 'Home';
include_once APP_PATH.'/includes/_head.php';

$todos = \App\App::getTodos();

?>

<body>
    <div class="wrapper">
        <header><?= APP_TITLE ?></header>
        <small class="text-muted">Version <?= APP_VERSION ?></small>

        <div class="todo-input">
            <input type="text" placeholder="Add your new todo" autofocus>
            <button><i class="fas fa-plus"></i></button>
        </div>
        <?php if ($todos): ?>
            <ul class="todo-list">
                <?php foreach($todos as $todo): ?>
                    <li>
                        <?= escape($todo->body) ?>
                        <span class="icon"><i class="fas fa-xmark"></i></span>
                    </li>
                <?php endforeach ?>
            </ul>
        <?php else: ?>
            <small class="js-no-todo text-muted">
                <span class="fas fa-circle-info"></span>
                You don't have any to-do at the moment.
            </small>
        <?php endif ?>
    </div>

    <?php

    $_js = ['js/home.js'];
    include_once APP_PATH.'/includes/_js.php';

    ?>
</body>
</html>
