<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use App\Models\Task;


class TaskController extends Controller
{
    public function index() {
        return view('tasks.index', [
            'tasks' => Task::latest()->paginate()
        ]);
    } 
    
    public function redirect() {
        return redirect()->route('tasks.index');
    }

    public function create() {
        return view('tasks.form');
    }

    public function edit(Task $task) {
        return view('tasks.form', ['task' => $task]);
    }

    public function show(Task $task) {
        return view('tasks.show', ['task' => $task]);
    }
    
    public function store(TaskRequest $request) {

        $task = Task::create($request->validated());
      
        return redirect()->route('tasks.show', ['task' => $task->id])
          ->with('success', 'Task created successfully!');
    }

    public function update(Task $task, TaskRequest $request) {

        $task->update($request->validated());
      
        return redirect()->route('tasks.show', ['task' => $task->id])
        ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task) {
        $task->delete();
        return redirect()->route('tasks.index')
          ->with('success','Task deleted sucessfully');
    }

    public function toggle(Task $task) {
        $task->toggleComplete();
      
        return redirect()->back()->with('success', 'Task toggled');
    }

    public function fallback() {
        return "still got somewhere";
    }

}
