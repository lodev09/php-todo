//
// Todo Object
//

var Todo = function(element, options) {
    this._element = element;
    this.options = $.extend(true, {}, options, $(element).data());

    this.init();
}

Todo.prototype = {
    init: function() {
        var that = this;
        this.initEvents();
        this.initTasks();
    },
    initTasks: function() {
        var that = this;
        var $element = $(this._element);

        this.showMessage('Loading your tasks...', 'hourglass')
        $.get($.ajaxUrl + '/get-tasks', { sort: this.options.sort }, function(data) {

            if (data && data.length > 0) {
                that.hideMessage();
                for (var t in data) {
                    var task = data[t];
                    that.appendTask(task);
                }
            } else {
                that.showMessage('You don\'t have any tasks at the moment.', 'circle-info');
            }

            that.initStats();

        }).fail(function(xhr) {
            $.xhrError(xhr);
            that.showMessage('Something went wrong :(', 'triangle-exclamation');
        });
    },
    initEvents: function() {
        var that = this;
        var $element = $(this._element);

        var $addTaskBtn = $element.find('.js-add-task');
        var $taskInput = $element.find('.js-task-input');
        var $newTaskForm = $element.find('.js-new-task-form');

        $taskInput.on('keyup', function(e) {
            var task = $(this).val().trim();
            $addTaskBtn.prop('disabled', task === '');
        });

        // When form is submitted
        $newTaskForm.on('submit', function(e) {
            var $this = $(this);

            e.preventDefault();
            $.post($.ajaxUrl + '/new-task', $this.serialize(), function(data) {

                // Append the newly created task
                that.appendTask(data);

                // Refresh stats
                that.initStats();

                // Clear form
                that.clear(true);

            }).fail(function(xhr) {
                var message = $.xhrError(xhr);
                that.showMessage(message, 'triangle-exclamation');
            });
        })
    },
    initStats: function() {
        var $element = $(this._element);
        var $stats = $element.find('.js-stats');
        var $taskItems = $element.find('.js-tasks').find('li');
        var total = 0;
        var completed = 0;

        if ($taskItems.length === 0) {
            $stats.hide();
            return;
        }

        completed = $taskItems.filter(function() {
            return $(this).is('.completed') === true;
        }).length;

        total = $taskItems.length;

        $stats.show();

        $stats.find('.js-stat-total').html(`<small>Total: <strong>` + total + `</strong></small>`);
        $stats.find('.js-stat-completed').html(`<small>Completed: <strong>` + completed + `</strong></small>`);
    },
    clear: function(focus) {
        var $element = $(this._element);
        var $taskInput = $element.find('.js-task-input');
        var $addTaskBtn = $element.find('.js-add-task');

        $taskInput.val('');
        $addTaskBtn.prop('disabled', true);
        this.hideMessage();

        focus && $taskInput.focus();
    },
    hideMessage: function() {
        $(this._element).find('.js-message').hide();
    },
    showMessage: function(message, icon) {
        var $message = $(this._element).find('.js-message');

        $message.show();
        $message.html(`
            <span class="fas fa-` + icon + `"></span>
            ` + message + `
        `);
    },
    appendTask: function(data) {
        var that = this;
        var $element = $(this._element);
        var $tasks = $element.find('.js-tasks');

        // Create task element
        var $task = $('<li>');

        // Set data
        $task.data('task', data);

        // Append to DOM
        // Insert before first completed task
        var $firstCompletedTask = $element.find('li.completed').eq(0);

        if ($firstCompletedTask.length) $task.insertBefore($firstCompletedTask);
        else $tasks.append($task);

        // Create the task object
        var task = new Task($task.get(0));

        //
        // Task events
        //

        //
        // Completed
        $task.on('task-completed', function() {
            that.initStats();
        });

        //
        // Deleted
        $task.on('task-deleted', function() {
            $(this).remove();
            that.initStats();
        });

        //
        // Prioritized
        $task.on('task-prioritized', function() {
            that.initStats();
        });
    }
}

//
// Task object
//

var Task = function(element) {
    this._element = element;
    this.data = $(element).data('task');

    this.init();
}

Task.prototype = {
    init: function() {
        var $element = $(this._element);
        $element.html(`
            <span class="fas fa-circle-exclamation text-warning js-priority-indicator" style="display: none"></span>
            <a href="` + $.appUrl + `/tasks/` + this.data.id + `">
                ` + $.escape(this.data.body) + `
            </a>
            <div class="controls">
                <a href="#" class="text-success control js-complete"><i class="fas fa-circle-check"></i></a>
                <a href="#" class="text-warning control js-prioritize"><i class="fas fa-circle-exclamation"></i></a>
                <a href="#" class="text-danger control js-delete"><i class="fas fa-circle-xmark"></i></a>
            </div>
        `);

        this.initEvents();
        this.initIndicators();
    },
    _triggerEvent: function(event, param) {
        $(this._element).trigger($.extend({ type: event }, this), param);
    },
    initIndicators: function() {
        var $element = $(this._element);

        // Completed
        if (this.data.completed) {
            $element.addClass('completed');
        } else {
            $element.removeClass('completed');
        }

        // Priority
        if (this.data.priority) {
            $element.find('.js-priority-indicator').show();
            $element.addClass('priority');
        } else {
            $element.find('.js-priority-indicator').hide();
            $element.removeClass('priority');
        }
    },
    initEvents: function() {
        var that = this;
        var $element = $(this._element);

        //
        // Delete this task
        $element.find('.js-delete').on('click', function(e) {
            e.preventDefault();
            that.delete();
        });

        //
        // Complete this task
        $element.find('.js-complete').on('click', function(e) {
            e.preventDefault();
            that.complete();
        });

        //
        // Prioritize task
        $element.find('.js-prioritize').on('click', function(e) {
            e.preventDefault();
            that.prioritize();
        });
    },
    delete: function() {
        var that = this;
        var $element = $(this._element);

        $.post($.ajaxUrl + '/delete-task', { task_id: this.data.id }, function(data) {

            toastr.success(data.message);
            that._triggerEvent('task-deleted');

        }).fail($.xhrError);
    },
    complete: function() {
        var that = this;
        var $element = $(this._element);

        $.post($.ajaxUrl + '/complete-task', { task_id: this.data.id }, function(data) {
            that.data.completed = true;
            toastr.success(data.message);
            that.initIndicators();
            that._triggerEvent('task-completed');

        }).fail($.xhrError);
    },
    prioritize: function() {
        var that = this;
        var $element = $(this._element);

        $.post($.ajaxUrl + '/prioritize-task', { task_id: this.data.id }, function(data) {
            that.data.priority = true;
            toastr.success(data.message);
            that.initIndicators();
            that._triggerEvent('task-prioritized');

        }).fail($.xhrError);
    }
}

//
// Extend Todo as plugin
$.fn.extend({
    todo: function(options) {
        return this.each(function() {
            $(this).data('todo', new Todo(this, options));
        })
    }
})
