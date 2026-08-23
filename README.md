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

Clone the repository:

```bash
git clone https://github.com/KristinaPonteras/IM-LaravelAssessment.git
```

Open the project directory:

```bash
cd docker-laravel-template
```

## 2. Install dependencies

Install the project dependencies using Composer:

```bash
composer install
```

If using Docker, the application dependencies can be installed inside the application container:

```bash
docker compose exec app-new composer install
```

## 3. Configure .env

Copy the example environment file:

```cmd
copy .env.example .env
```

Generate the Laravel application key:

```bash
docker compose exec app-new php artisan key:generate
```

Configure the database settings in the `.env` file according to the Docker MySQL configuration.

## 4. Create the database

Start the Docker containers:

```bash
docker compose up -d
```

The MySQL database container will start together with the Laravel application.

## 5. Run migrations

Run the database migrations:

```bash
docker compose exec app-new php artisan migrate
```

## 6. Run tests

Run the PHPUnit test suite:

```bash
docker compose exec app-new php artisan test
```

## 7. Start the Laravel application

Start the Docker containers:

```bash
docker compose up -d
```

The Laravel application can be accessed at:

```text
http://localhost:8000
```

---

# Student API

The Student Management API provides CRUD operations for student records.

## API Endpoints

| Method | Endpoint             | Description          |
| ------ | -------------------- | -------------------- |
| GET    | `/api/students`      | Get all students     |
| POST   | `/api/students`      | Create a new student |
| GET    | `/api/students/{id}` | Get a student by ID  |
| PUT    | `/api/students/{id}` | Update a student     |
| PATCH  | `/api/students/{id}` | Update a student     |
| DELETE | `/api/students/{id}` | Delete a student     |

---

# Example: Create a Student

Send a `POST` request to:

```text
http://localhost:8000/api/students
```

Use `raw` → `JSON` in Postman and provide:

```json
{
    "first_name": "Rowena",
    "last_name": "Nunez",
    "email": "wenwenforthewin@gmail.com",
    "age": 42,
    "course": "House Burn",
    "year_level": 0,
    "status": "inactive"
}
```

A successful request returns a `201 Created` response with a success message and the newly created student information.

Example response:

```json
{
    "message": "Student created successfully.",
    "data": {
        "id": "student-id",
        "first_name": "Rowena",
        "last_name": "Nunez",
        "email": "wenwenforthewin@gmail.com",
        "age": 42,
        "course": "House Burn",
        "year_level": 0,
        "status": "inactive"
    }
}
```

---

# Example: Get All Students

Send a `GET` request to:

```text
http://localhost:8000/api/students
```

This returns the list of student records.

---

# Example: Get Student by ID

Send a `GET` request to:

```text
http://localhost:8000/api/students/{id}
```

Replace `{id}` with the actual student ID.

---

# Testing

The API was tested using Postman.

The implemented student API includes:

* Getting all students
* Creating a student
* Getting a student by ID
* Updating a student
* Deleting a student

The Laravel application also includes PHPUnit feature tests for the Student API.

---

# Project Structure

```text
app/
├── Http/
│   ├── Controllers/
│   │   └── StudentController.php
│   ├── Requests/
│   │   ├── StoreStudentRequest.php
│   │   └── UpdateStudentRequest.php
│   └── Resources/
│       └── StudentResource.php
├── Models/
│   └── Student.php
├── Repositories/
│   ├── Contracts/
│   │   └── StudentRepositoryInterface.php
│   └── StudentRepository.php
└── Services/
    └── StudentService.php

database/
└── migrations/

routes/
└── api.php

tests/
└── Feature/
    └── StudentTest.php
```

---

# Tools Used

* Laravel 12
* PHP
* MySQL
* Docker
* Postman
* PHPUnit
* GitHub
