# Semicolon Task List

A small full-stack task manager built with **Laravel**, **MySQL**, Blade, and plain CSS/JavaScript (no Vite/npm build step). Branded with the Semicolon teal identity (`#019589`).

## Features

- Register, log in, and log out
- Create tasks and list them (newest first)
- Mark tasks completed by click or drag-and-drop
- Backend validation for task titles
- Per-user task ownership

## Requirements

- PHP 8.3+
- Composer
- MySQL 8+

## Setup

1. Install PHP dependencies:

```bash
composer install
```

2. Copy the environment file and set your MySQL credentials:

```bash
cp .env.example .env
php artisan key:generate
```

Update these values in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=semicolon_db
DB_USERNAME=root
DB_PASSWORD=
```

3. Create the MySQL database (example):

```sql
CREATE DATABASE semicolon_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

4. Run migrations and seed the default user:

```bash
php artisan migrate --seed
```

Alternatively, after Laravel’s default tables exist, you can create the tasks table with [`database/schema.sql`](database/schema.sql).

5. Start the app:

```bash
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000).

No `npm install` or frontend compile step is required. Static assets live in `public/css` and `public/js`.

## Default user

| Field    | Value             |
|----------|-------------------|
| Email    | `demo@example.com` |
| Password | `password`         |

## API endpoints

All task endpoints require an authenticated session.

| Method | Path           | Description                                      |
|--------|----------------|--------------------------------------------------|
| `GET`  | `/tasks`       | List current user’s tasks, newest first          |
| `POST` | `/tasks`       | Create a task (`title` required, max 100 chars)  |
| `PATCH`| `/tasks/{id}`  | Mark a task as completed                         |

Invalid titles return `422`. Missing or unauthorized tasks return `404`.

## Auth routes

| Method | Path        | Description        |
|--------|-------------|--------------------|
| `GET`  | `/register` | Registration form  |
| `POST` | `/register` | Create account     |
| `GET`  | `/login`    | Login form         |
| `POST` | `/login`    | Sign in            |
| `POST` | `/logout`   | Sign out           |

## Unfinished / out of scope

Per the assessment brief, the following were intentionally not built:

- Task deletion
- Search / filtering
- Automated tests
- Deployment configuration
- Marking a completed task as active again
