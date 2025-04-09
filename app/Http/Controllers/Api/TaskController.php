<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    protected TaskService $taskService;
    
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'assigned_to']);
        $tasks = $this->taskService->getTasks($filters);
        
        return TaskResource::collection($tasks);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date|after:now',
        ]);
        
        $task = $this->taskService->createTask($validated);
        
        return new TaskResource($task);
    }
    
    public function assign(Request $request, $taskId)
    {

       
        $task = Task::find($taskId);
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        
        $user = User::findOrFail($request->user_id);
        $task = $this->taskService->assignTask($task, $user);
        $task->load('assignedUser');
        return new TaskResource($task);
    }
    
    public function complete($taskId)
    {
        $task = Task::find($taskId);
        $task = $this->taskService->completeTask($task);
        
        return new TaskResource($task);
    }
}