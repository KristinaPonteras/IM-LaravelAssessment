# Student Management API

A Laravel REST API for managing student records using a layered architecture consisting of Controllers, Form Requests, Services, Repository Interfaces, Repositories, Models, and API Resources.

## Technologies

* Laravel 12
* PHP
* MySQL
* Docker
* PHPUnit

---

# Installation

## 1. Clone or copy the project
Open the project directory:
```bash
cd docker-laravel-template
```

## 2. Install dependencies
Install the required PHP dependencies:
```bash
composer install
```

## 3. Configure .env
Copy the `.env.example` file and create the `.env` file:
```cmd
copy .env.example .env
```

Generate the application key:
```bash
php artisan key:generate
```

Make sure the database settings in `.env` match the MySQL database used by the Docker setup.

## 4. Create the database
Start the Docker containers:
```bash
docker compose up -d
```

## 5. Run migrations
Run the database migrations:
```bash
docker compose exec app-new php artisan migrate
```

## 6. Run tests
Run the tests using PHPUnit:
```bash
docker compose exec app-new php artisan test
```

## 7. Start the Laravel application
Start the Docker containers:
```bash
docker compose up -d
```

The application can be accessed at:
```text
http://localhost:8000
```

# Student API Endpoints

| Method    | Endpoint                | Description         |
| --------- | ------------------------| ------------------- |
| GET       | /api/students           | Get all students    |
| POST      | /api/students           | Create a student    |
| GET       | /api/students/{student} | Get a student by ID |
| PUT/PATCH | /api/students/{student} | Update a student    |
| DELETE    | /api/students/{student} | Delete a student    |

# API Testing

The Student API was tested using Postman.

The API can be used to:
- View all students
- Create a student
- View a student by ID
- Update a student
- Delete a student
