<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\TaskCompleted;
use App\Listeners\LogTaskCompletion;
use Illuminate\Support\Facades\Event;
class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(
            TaskCompleted::class,
            LogTaskCompletion::class
        );
    }
}
