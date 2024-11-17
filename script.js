$(document).ready(function () {
    // Load tasks on page load
    loadTasks();

    // Handle new task submission
    $('#new-task-form').submit(function (e) {
        e.preventDefault();
        $.post('tasks.php', { newTask: $('#task-input').val() }, function () {
            loadTasks();
            $('#task-input').val('');
        });
    });

    // Handle task completion
    $('#task-list').on('change', '.task input[type="checkbox"]', function () {
        $.post('tasks.php', { taskId: $(this).data('id') }, function () {
            loadTasks();
        });
    });

    // Handle task deletion
    $('#task-list').on('click', '.task button', function () {
        $.post('tasks.php', { deleteId: $(this).data('id') }, function () {
            loadTasks();
        });
    });

    // Function to load tasks from server
    function loadTasks() {
        $.get('tasks.php', function (data) {
            displayTasks(data);
        });
    }

    // Function to display tasks in the task list
    function displayTasks(tasks) {
        $('#task-list').empty();
        tasks.forEach(function (task, index) {
            const taskElement = $('<div class="task">');
            taskElement.append(<input type="checkbox" data-id="${index}" ${task.completed ? 'checked' : ''}>);
            taskElement.append(<span class="${task.completed ? 'completed' : ''}">${task.task}</span>);
            taskElement.append(<button data-id="${index}">Delete</button>);
            $('#task-list').append(taskElement);
        });
    }
});