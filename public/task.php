<?php

require_once 'init.php';

$task_id = get('task_id');
$task = \Models\Task::instance($task_id);
if (!$task) {
    \App\App::error404();
    exit;
}

$task_url = APP_URL.'/tasks/'.$task->id;

if (is_post()) {
    $body = get('body', $_POST);

    $task->update([
        'body' => $body,
        'priority' => get('priority', $_POST) ? 1 : 0,
        'completed' => get('completed', $_POST) ? 1 : 0
    ]);

    redirect($task_url.'?updated=1');

    exit;
}

$_title = 'Task #'.$task->id;
include_once APP_PATH.'/includes/_head.php';

?>

<body>
    <div class="wrapper">
        <header>
            <small><a href="<?= APP_URL ?>" class="text-muted mr-2"><span class="fas fa-arrow-left"></span></a></small>
            Task #<?= $task->id ?>
        </header>

        <?php if (get('updated')): ?>
            <div class="mt-2 text-success">
                <span class="fas fa-circle-info"></span>
                Task has been successfully updated
            </div>
        <?php endif ?>

        <form method="post" action="<?= $task_url ?>" class="mt-3">
            <div class="mb-3">
                <label>Body</label>
                <input name="body" type="text" value="<?= escape($task->body) ?>" placeholder="Add your new todo" autofocus required autocomplete="off">
            </div>

            <div class="mb-4">
                <input type="checkbox" name="priority" id="input-priority" <?= $task->isPriority() ? 'checked' : '' ?>>
                <label for="input-priority">Priority</label>

                <input type="checkbox" name="completed" id="input-completed" <?= $task->isCompleted() ? 'checked' : '' ?> value="1" class="ml-3">
                <label for="input-completed">Completed</label>
            </div>

            <button type="submit">Update Task</button>
        </form>
    </div>

    <?php

    include_once APP_PATH.'/includes/_js.php';

    ?>
</body>
</html>
