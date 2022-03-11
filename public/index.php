<?php

require_once 'init.php';

$sort = get('sort', $_GET, \Models\Task::SORT_PRIORITY);

$_title = 'Home';
include_once APP_PATH.'/includes/_head.php';

?>

<body>
    <div class="wrapper">
        <header><?= APP_TITLE ?></header>
        <small class="text-muted">Version <?= APP_VERSION ?></small>

        <div class="js-todo" data-sort="<?= escape($sort) ?>">
            <form method="post" class="js-new-task-form todo-input">
                <input name="body" type="text" class="js-task-input" placeholder="Add your new todo" autofocus required autocomplete="off">
                <button type="submit" class="js-add-task" disabled><i class="fas fa-plus"></i></button>
            </form>
            <div class="d-flex justify-content-between">
                <div class="stats js-stats" style="display: none">
                    <div class="stat js-stat-completed"></div>
                    <div class="stat js-stat-total"></div>
                </div>
                <div class="sort">
                    <small>
                        <?php if ($sort === \Models\Task::SORT_PRIORITY): ?>
                            <a href="<?= APP_URL.'?sort='.\Models\Task::SORT_NAME ?>" class="text-muted">Click to sort by <strong>Name</strong></a>
                        <?php else: ?>
                            <a href="<?= APP_URL.'?sort='.\Models\Task::SORT_PRIORITY ?>" class="text-muted">Click to sort by <strong>Priority</strong></a>
                        <?php endif ?>
                    </small>
                </div>
            </div>
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
