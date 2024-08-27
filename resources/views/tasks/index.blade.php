<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>PHP - Simple To Do List App</h3>
        </div>
        <div class="card-body">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="taskInput" placeholder="Enter task">
                <div class="input-group-append">
                    <button class="btn btn-primary" onclick="addTask()">Add Task</button>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Task</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="taskList">
                @foreach($tasks as $task)
                    <tr id="task-{{ $task->id }}">
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->completed ? 'Done' : '' }}</td>
                        <td>
                            <button class="btn btn-success btn-sm" onclick="toggleTask({{ $task->id }})">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteTask({{ $task->id }})">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>
    function addTask() {
        const taskInput = document.getElementById('taskInput').value;

        axios.post('/tasks', { title: taskInput })
            .then(response => {
                const task = response.data;
                renderTask(task);
                document.getElementById('taskInput').value = '';
            })
            .catch(error => {
                alert(error.response.data.message);
            });
    }

    function renderTask(task) {
        const taskList = document.getElementById('taskList');
        const taskItem = document.createElement('tr');
        taskItem.id = `task-${task.id}`;
        taskItem.innerHTML = `
            <td>${task.id}</td>
            <td>${task.title}</td>
            <td>${task.completed ? 'Done' : ''}</td>
            <td>
                <button class="btn btn-success btn-sm" onclick="toggleTask(${task.id})">
                    <i class="fas fa-check"></i>
                </button>
                <button class="btn btn-danger btn-sm" onclick="deleteTask(${task.id})">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        `;
        taskList.appendChild(taskItem);
    }

    function toggleTask(id) {
        axios.patch(`/tasks/${id}`)
            .then(response => {
                const task = response.data;
                document.getElementById(`task-${task.id}`).remove();
                renderTask(task);
            });
    }

    function deleteTask(id) {
        if (confirm('Are you sure to delete this task?')) {
            axios.delete(`/tasks/${id}`)
                .then(response => {
                    document.getElementById(`task-${id}`).remove();
                });
        }
    }
</script>
</body>
</html>
