<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function index()
    {
        $tasks = Task::all();
        $this->responseRequestSuccess($tasks);
    }

    public function store(Request $request)
    {
        $data = $request->json()->get('task');
        $task = Task::create($data);
        $this->responseRequestSuccess($task);
    }

    public function show($id)
    {
        $task = Task::find($id);
        $this->responseRequestSuccess($task);
    }

    public function delete($id)
    {
        Task::find($id)->delete();
        $this->responseRequestSuccess("deleted");
    }

    public function update(Request $request, $id)
    {
        $data = $request->json()->get('task');
        $task = Task::find($id);
        $task->update($data);
        $this->responseRequestSuccess($task);
    }
}
