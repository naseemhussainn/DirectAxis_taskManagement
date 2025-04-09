<div>
    <h1>New Task Assigned</h1>
    <p>A new task has been assigned to you:</p>
    
    <h2>{{ $task->title }}</h2>
    <p><strong>Description:</strong> {{ $task->description ?? 'No description provided' }}</p>
    <p><strong>Due Date:</strong> {{ $task->due_date ? $task->due_date->format('Y-m-d H:i') : 'No due date set' }}</p>
    
    <p>Please complete this task before the due date.</p>
</div>