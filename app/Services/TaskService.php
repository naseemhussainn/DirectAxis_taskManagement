<?php

namespace App\Services;

use App\Jobs\SendTaskAssignmentNotification;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    public function createTask(array $data): Task
    {
        return Task::create($data);
    }

    public function assignTask(Task $task, User $user): Task
    {
        
        $task->update(['assigned_to' => $user->id]);

        SendTaskAssignmentNotification::dispatch($task, $user);
        
        return $task;
    }
    
    public function completeTask(Task $task): Task
    {
        $task->update(['status' => 'completed']);

        event(new \App\Events\TaskCompleted($task));
        
        return $task;
    }
    
    public function getTasks(array $filters = []): LengthAwarePaginator
    {
        $query = Task::query();
        
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (isset($filters['assigned_to'])) {
            $query->where('assigned_to', $filters['assigned_to']);
        }
        
        return $query->with('assignedUser')->paginate(10);
    }
    
    public function markOverdueTasks(): int
    {
        return Task::where('status', 'pending')
            ->whereNotNull('due_date')
            ->where('due_date', '<', now())
            ->update(['status' => 'expired']);
    }
}