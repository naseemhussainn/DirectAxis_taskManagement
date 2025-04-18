<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskAssigned extends Mailable
{
    use Queueable, SerializesModels;

    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Task Assigned to You',
        );
    }

    public function content(): Content
    {
    
        $view = view()->exists('emails.task-assigned') 
            ? 'emails.task-assigned' 
            : function ($message) {
                $message->text("A new task '{$this->task->title}' has been assigned to you.");
              };
        
        return new Content(
            view: $view,
            with: [
                'task' => $this->task,
            ],
        );
    }
}
