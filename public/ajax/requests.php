<?php

function new_task() {
    $body = get('body', $_POST);
    if (!$body) throw new Exception('Body is required for a new task');

    $task = \App\App::newTask($body);
    if (!$task) throw new Exception('Failed to add task. Please try again later');

    return $task->get();
}

function delete_task() {
    $task_id = get('task_id', $_POST);
    $task = \Models\Task::instance($task_id);
    if (!$task) throw new Exception('Task not found', 404);

    $result = $task->delete();
    if (!$result) throw new Exception('Unable to delete this task. Please try again later');

    return 'Task has been successfully deleted';
}

function prioritize_task() {
    $task_id = get('task_id', $_POST);
    $task = \Models\Task::instance($task_id);
    if (!$task) throw new Exception('Task not found', 404);

    $task->prioritize();
    return 'Task has been successfully prioritized';
}

function complete_task() {
    $task_id = get('task_id', $_POST);
    $task = \Models\Task::instance($task_id);
    if (!$task) throw new Exception('Task not found', 404);

    $task->complete();
    return 'Task has been completed successfully';
}

function get_tasks() {
    $sort = get('sort', $_GET, \Models\Task::SORT_PRIORITY);
    $data = [];

    $tasks = \App\App::getTasks($sort);
    foreach ($tasks as $task) {
        $data[] = $task->get();
    }

    return $data;
}
