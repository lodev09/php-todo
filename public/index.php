<?php

require_once 'init.php';

$_title = 'Home';
include_once APP_PATH.'/includes/_head.php';

?>

<body>
    <div class="wrapper">
        <header><?= APP_TITLE ?></header>
        <small class="text-muted">Version <?= APP_VERSION ?></small>

        <div class="js-todo">
            <form method="post" class="js-new-task-form todo-input">
                <input name="body" type="text" class="js-task-input" placeholder="Add your new todo" autofocus required autocomplete="off">
                <button type="submit" class="js-add-task" disabled><i class="fas fa-plus"></i></button>
            </form>
            <ul class="tasks js-tasks"></ul>
            <small class="text-muted js-message"></small>
        </div>
    </div>

    <?php

    $_js = [
        'js/libs/todo.js',
        'js/home.js'
    ];
    include_once APP_PATH.'/includes/_js.php';

    ?>
</body>
</html>
