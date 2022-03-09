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
        $.get($.ajaxUrl + '/get-tasks', function(data) {

            if (data && data.length > 0) {
                that.hideMessage();
                for (var t in data) {
                    var task = data[t];
                    that.appendTask(task);
                }
            } else {
                that.showMessage('You don\'t have any tasks at the moment.', 'circle-info');
            }

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
                that.clear(true);
            }).fail(function(xhr) {
                var message = $.xhrError(xhr);
                that.showMessage(message, 'triangle-exclamation');
            });
        })
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
    appendTask: function(task) {
        var $tasks = $(this._element).find('.js-tasks');

        // Create task element
        var $task = $('<li>');

        // Set data
        $task.data('task', task);

        // Append to DOM
        $tasks.prepend($task);

        // Create the task object
        return new Task($task.get(0));
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
        $element.html(
            $.escape(this.data.body) + `
            <div class="controls">
                <a href="#" class="text-success control js-complete"><i class="fas fa-circle-check"></i></a>
                <a href="#" class="text-warning control js-priority"><i class="fas fa-circle-exclamation"></i></a>
                <a href="#" class="text-danger control js-delete"><i class="fas fa-circle-xmark"></i></a>
            </div>
        `);

        this.initEvents();
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
    },
    delete: function() {
        var $element = $(this._element);

        $.post($.ajaxUrl + '/delete-task', { task_id: this.data.id }, function(data) {
            $element.remove();
            toastr.success(data.message);
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
