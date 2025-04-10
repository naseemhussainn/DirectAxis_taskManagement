# Task Management System API

A Laravel 11 based API for managing tasks with features like task assignment, completion, and automated status updates.

## Features

- User authentication using Laravel Sanctum
- CRUD operations for tasks
- Task assignment with email notifications via queue
- Request execution time logging
- Automated marking of overdue tasks as expired
- API resources for consistent response formatting

## Requirements

- PHP 8.3+
- Composer
- MySQL
- Laravel 11

## Installation and Setup

1. Clone the repository
```bash
git clone [repository-url]
cd task-management-system
```

2. Install dependencies
```bash
composer install
```

3. Set up environment file
```bash
cp .env.example .env
```

4. Configure your database and mail settings in the `.env` file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@taskmanagement.com"
MAIL_FROM_NAME="${APP_NAME}"
```

5. Generate application key
```bash
php artisan key:generate
```

6. Run migrations
```bash
php artisan migrate
```

7. Start the development server
```bash
php artisan serve
```

8. Start the queue worker
```bash
php artisan queue:work
```

## API Endpoints

### Authentication
- `POST /api/register` - Register a new user
- `POST /api/login` - Login a user
- `POST /api/logout` - Logout the authenticated user (requires authentication)

### Tasks
- `GET /api/tasks` - List all tasks (with optional filters)
- `POST /api/tasks` - Create a new task
- `PUT /api/tasks/{id}/assign` - Assign a task to a user
- `PUT /api/tasks/{id}/complete` - Mark a task as completed

## Testing the API

You can test the API using tools like Postman or cURL. Here are some examples:

### Register a User
```
POST /api/register
Content-Type: application/json

{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

### Login
```
POST /api/login
Content-Type: application/json

{
    "email": "test@example.com",
    "password": "password"
}
```

### Create a Task (requires authentication)
```
POST /api/tasks
Content-Type: application/json
Authorization: Bearer {your_token}

{
    "title": "Complete Project",
    "description": "Finish the Laravel task management project",
    "due_date": "2023-12-31 12:00:00"
}
```

### Assign a Task (requires authentication)
```
PUT /api/tasks/1/assign
Content-Type: application/json
Authorization: Bearer {your_token}

{
    "user_id": 2
}
```

### Complete a Task (requires authentication)
```
PUT /api/tasks/1/complete
Authorization: Bearer {your_token}
```

## Command for Expired Tasks

The system includes a scheduled command that runs every hour to mark overdue tasks as expired:

```bash
php artisan tasks:expire-overdue
```

To test this command manually, you can run it using the command above.

For the scheduler to work in production, add the following Cron entry to your server:

```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Additional Information

- The system uses a custom middleware to log request execution time in the Laravel log file
- Task assignment notifications are sent asynchronously using Laravel's queue system
- Dependency injection is used for the TaskService to keep the controllers clean