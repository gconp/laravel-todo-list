<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
		   $tasks = Task::all();

        // Pass the tasks to the view
        return view('tasks.index', compact('tasks'));
       // return view('tasks.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:tasks'
        ]);

        $task = Task::create([
            'title' => $request->title
        ]);

        return response()->json($task);
    }

    public function update(Task $task)
    {
        $task->completed = !$task->completed;
        $task->save();

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }

    public function showAll()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }
}
