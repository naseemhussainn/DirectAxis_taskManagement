<?php

namespace App\Listeners;

use App\Events\TaskCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogTaskCompletion
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskCompleted $event): void
    {
        Log::info('Task completed', [
            'task_id' => $event->task->id,
            'title' => $event->task->title,
            'completed_at' => now()->format('Y-m-d H:i:s'),
            'completed_by' => auth()->id() ?? 'System',
        ]);
    }
}
