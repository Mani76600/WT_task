<!DOCTYPE html>
<html>
<head>
    <title>Task Management</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function(){
            // load tasks when page loads
            loadTasks();

            // create task
            $("#create-task-form").on('submit', function(e){
                e.preventDefault();
                let task = $('#task').val();
                $.ajax({
                    url: 'create_task.php',
                    type: 'POST',
                    data: {task: task},
                    success: function(response){
                        // load tasks again
                        loadTasks();
                        // clear the input field
                        $('#task').val('');
                    }
                });
            });

            // delete task
            $(document).on('click', '.delete-task', function(){
                let id = $(this).attr('id');
                $.ajax({
                    url: 'delete_task.php',
                    type: 'POST',
                    data: {id: id},
                    success: function(response){
                        // load tasks again
                        loadTasks();
                    }
                });
            });

            // update task status
            $(document).on('change', '.task-checkbox', function(){
                let id = $(this).attr('id');
                let isChecked = $(this).is(':checked');
                $.ajax({
                    url: 'update_task_status.php',
                    type: 'POST',
                    data: {id: id, isChecked: isChecked},
                    success: function(response){
                        // load tasks again
                        loadTasks();
                    }
                });
            });

            function loadTasks(){
                $.ajax({
                    url: 'get_tasks.php',
                    type: 'GET',
                    success: function(response){
                        let tasks = JSON.parse(response);
                        let tasksHtml = '';
                        tasks.forEach(task => {
                            tasksHtml += '<tr>';
                            tasksHtml += '<td><input type="checkbox" class="task-checkbox" id="'+task.id+'" '+(task.is_completed ? 'checked' : '')+'></td>';
                            tasksHtml += '<td>'+task.name+'</td>';
                            tasksHtml += '<td><button class="delete-task" id="'+task.id+'">Delete</button></td>';
                            tasksHtml += '</tr>';
                        });
                        $('#tasks-table tbody').html(tasksHtml);
                    }
                });
            }
        });
    </script>
</head>
<body>
    <form id="create-task-form">
        <input type="text" id="task" name="task" placeholder="Enter task name">
        <button type="submit">Create Task</button>
    </form>
    <table id="tasks-table" border="1">
        <thead>
            <tr>
                <th>Completed</th>
                <th>Task</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</body>
</html>