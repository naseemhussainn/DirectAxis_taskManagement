<?php

namespace App\Console\Commands;

use App\Services\TaskService;
use Illuminate\Console\Command;

class ExpireOverdueTasks extends Command
{
    protected $signature = 'tasks:expire-overdue';
    protected $description = 'Mark overdue tasks as expired';
    
    protected TaskService $taskService;
    
    public function __construct(TaskService $taskService)
    {
        parent::__construct();
        $this->taskService = $taskService;
    }
    
    public function handle(): int
    {
        $count = $this->taskService->markOverdueTasks();
        
        $this->info("Marked {$count} overdue tasks as expired");
        
        return Command::SUCCESS;
    }
}
