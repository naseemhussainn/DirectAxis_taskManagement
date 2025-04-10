<?php

namespace App\Jobs;

use App\Mail\TaskAssigned;
use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTaskAssignmentNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;
    protected $user;

    public function __construct(Task $task, User $user)
    {
        $this->task = $task;
        $this->user = $user;
    }

    public function handle(): void
    {
        try {
            Mail::to($this->user->email)->send(new TaskAssigned($this->task));
        } catch (\Exception $e) {
            \Log::error("Failed to send email: {$e->getMessage()}", [
                'task_id' => $this->task->id,
                'user_id' => $this->user->id,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
