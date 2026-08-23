# Student Management API

A Laravel REST API for managing student records using a layered architecture consisting of Controllers, Form Requests, Services, Repository Interfaces, Repositories, Models, and API Resources.

## Technologies

* Laravel 12
* PHP
* MySQL
* Docker
* PHPUnit
* Postman

# Installation

## 1. Clone or Copy the Project

Open the project directory:

```bash
cd docker-laravel-template
```

## 2. Install Dependencies

Install the required PHP dependencies:

```bash
composer install
```

If the application is running inside Docker, make sure the Docker containers are running:

```bash
docker compose up -d
```

## 3. Configure `.env`

Copy the `.env.example` file and create the `.env` file.

For Windows:

```cmd
copy .env.example .env
```

Generate the Laravel application key:

```bash
docker compose exec app-new php artisan key:generate
```

Make sure the database settings in `.env` match the MySQL database configured in the Docker setup.

Example:

```env
DB_CONNECTION=mysql
DB_HOST=db-new
DB_PORT=3306
DB_DATABASE=student_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

Use the actual database name, username, password, and service name configured in your Docker Compose file.

## 4. Create the Database

Start the Docker containers:

```bash
docker compose up -d
```

The MySQL container provides the database used by the Laravel application.

Make sure the database configured in `.env` exists and matches the Docker MySQL configuration.

## 5. Run Migrations

Run the Laravel database migrations:

```bash
docker compose exec app-new php artisan migrate
```

This creates the required database tables, including the `students` table.

## 6. Run Tests

Run the PHPUnit test suite:

```bash
docker compose exec app-new php artisan test
```

The tests verify that the application's functionality works correctly.

## 7. Start the Laravel Application

Start the Docker containers:

```bash
docker compose up -d
```

The Laravel application can be accessed at:

```text
http://localhost:8000
```

The Student Management API is available at:

```text
http://localhost:8000/api/students
```

# API Documentation

The Student Management API provides CRUD operations for student records.

## Student Data Fields

| Field        | Type    | Description                            |
| ------------ | ------- | -------------------------------------- |
| `id`         | UUID    | Unique identifier of the student       |
| `first_name` | string  | Student's first name                   |
| `last_name`  | string  | Student's last name                    |
| `email`      | string  | Student's unique email address         |
| `age`        | integer | Student's age                          |
| `course`     | string  | Student's course                       |
| `year_level` | integer | Student's year level from 1 to 4       |
| `status`     | string  | Student status: `active` or `inactive` |

# 1. Get All Students

## Method

```http
GET
```

## URL

```text
/api/students
```

## Purpose

Retrieves a paginated list of all students.

## Query Parameters

The endpoint supports the following optional query parameters:

| Parameter    | Description                                 |
| ------------ | ------------------------------------------- |
| `search`     | Searches by first name, last name, or email |
| `course`     | Filters students by course                  |
| `status`     | Filters students by `active` or `inactive`  |
| `year_level` | Filters students by year level              |
| `per_page`   | Specifies the number of students per page   |

The default number of students per page is **10** when `per_page` is not provided.

## Example Request

```http
GET /api/students?search=maria&course=BSIT&status=active&year_level=2&per_page=10
```

## Example Response

```json
{
    "data": [
        {
            "id": "01a0290a-9d98-73be-94d4-8d2cbd1e4d36",
            "first_name": "Maria",
            "last_name": "Santos",
            "email": "maria@example.com",
            "age": 20,
            "course": "BSIT",
            "year_level": 2,
            "status": "active"
        }
    ]
}
```

Laravel also provides pagination information such as `links` and `meta` in the actual paginated response.

## Possible Errors

* `500 Internal Server Error` — Server or database error.

# 2. Create a Student

## Method

```http
POST
```

## URL

```text
/api/students
```

## Purpose

Creates a new student record in the database.

## Request Body

```json
{
    "first_name": "Maria",
    "last_name": "Santos",
    "email": "maria@example.com",
    "age": 20,
    "course": "BSIT",
    "year_level": 2,
    "status": "active"
}
```

## Validation Rules

| Field        | Validation Rules                                      |
| ------------ | ----------------------------------------------------- |
| `first_name` | Required, string, maximum 100 characters              |
| `last_name`  | Required, string, maximum 100 characters              |
| `email`      | Required, valid email, unique in the `students` table |
| `age`        | Required, integer, minimum 15                         |
| `course`     | Required, string, maximum 100 characters              |
| `year_level` | Required, integer, minimum 1, maximum 4               |
| `status`     | Required, must be `active` or `inactive`              |

## Example Response

**HTTP Status: 201 Created**

```json
{
    "message": "Created successfully.",
    "data": {
        "id": "01a0290a-9d98-73be-94d4-8d2cbd1e4d36",
        "first_name": "Maria",
        "last_name": "Santos",
        "email": "maria@example.com",
        "age": 20,
        "course": "BSIT",
        "year_level": 2,
        "status": "active"
    }
}
```

## Possible Errors

### 422 Unprocessable Content

Returned when the submitted data does not satisfy the validation rules.

Examples include:

* Missing required fields
* Invalid email format
* Duplicate email address
* Age below 15
* Year level below 1 or above 4
* Invalid student status

Example:

```json
{
    "message": "The email has already been taken.",
    "errors": {
        "email": [
            "The email has already been taken."
        ]
    }
}
```

# 3. Get Student by ID

## Method

```http
GET
```

## URL

```text
/api/students/{id}
```

## Purpose

Retrieves a specific student using their UUID.

## Example Request

```http
GET /api/students/01a0290a-9d98-73be-94d4-8d2cbd1e4d36
```

## Example Response

```json
{
    "data": {
        "id": "01a0290a-9d98-73be-94d4-8d2cbd1e4d36",
        "first_name": "Maria",
        "last_name": "Santos",
        "email": "maria@example.com",
        "age": 20,
        "course": "BSIT",
        "year_level": 2,
        "status": "active"
    }
}
```

## Possible Errors

### 404 Not Found

Returned when the specified student UUID does not exist.

---

# 4. Update Student

## Method

```http
PUT / PATCH
```

## URL

```text
/api/students/{id}
```

## Purpose

Updates an existing student record.

The endpoint supports partial updates because the update validation rules use `sometimes`.

## Example Request

```http
PUT /api/students/01a0290a-9d98-73be-94d4-8d2cbd1e4d36
```

## Request Body

Only the fields that need to be changed may be provided.

```json
{
    "first_name": "Maria",
    "course": "BSCS",
    "year_level": 3
}
```

## Validation Rules

| Field        | Validation Rules                                                    |
| ------------ | ------------------------------------------------------------------- |
| `first_name` | Optional; if provided, must be a string with maximum 100 characters |
| `last_name`  | Optional; if provided, must be a string with maximum 100 characters |
| `email`      | Optional; if provided, must be a valid and unique email             |
| `age`        | Optional; if provided, must be an integer with minimum 15           |
| `course`     | Optional; if provided, must be a string with maximum 100 characters |
| `year_level` | Optional; if provided, must be an integer between 1 and 4           |
| `status`     | Optional; if provided, must be `active` or `inactive`               |

## Example Response

```json
{
    "data": {
        "id": "01a0290a-9d98-73be-94d4-8d2cbd1e4d36",
        "first_name": "Maria",
        "last_name": "Santos",
        "email": "maria@example.com",
        "age": 20,
        "course": "BSCS",
        "year_level": 3,
        "status": "active"
    }
}
```

## Possible Errors

* `404 Not Found` — Student UUID does not exist.
* `422 Unprocessable Content` — Submitted data fails validation.

# 5. Delete Student

## Method

```http
DELETE
```

## URL

```text
/api/students/{id}
```

## Purpose

Deletes an existing student record from the database.

## Example Request

```http
DELETE /api/students/01a0290a-9d98-73be-94d4-8d2cbd1e4d36
```

## Example Response

**HTTP Status: 204 No Content**

The API returns an empty response body when the student is successfully deleted.

## Possible Errors

* `404 Not Found` — Student UUID does not exist.
* `500 Internal Server Error` — Server or database error.

# Architecture Explanation

The Student Management API uses a layered architecture. Each layer has a specific responsibility.

## Controller

The `StudentController` handles incoming HTTP requests.

It receives requests and communicates with the `StudentService`.

The controller provides the following operations:

* `index()` — retrieves students
* `store()` — creates a student
* `show()` — retrieves a student by ID
* `update()` — updates a student
* `destroy()` — deletes a student

The controller does not directly perform database operations.

## Form Request

The Form Request classes are responsible for validating incoming data before it reaches the service layer.

The project uses:

```text
StoreStudentRequest
UpdateStudentRequest
```

`StoreStudentRequest` validates data when creating a student.

`UpdateStudentRequest` validates data when updating a student.

This keeps validation logic separate from the controller.

## Service

The `StudentService` contains the application's student-related operations.

It communicates with the `StudentRepositoryInterface` to:

* Get all students
* Find a student
* Create a student
* Update a student
* Delete a student

The service acts as the business-logic layer between the controller and repository.

## Repository Interface

The `StudentRepositoryInterface` defines the operations that the student repository must provide.

It declares:

```text
getAll()
findById()
create()
update()
delete()
```

The interface separates the required repository operations from their implementation.

## Repository

The `StudentRepository` implements `StudentRepositoryInterface`.

It is responsible for database-related operations using the `Student` model.

It also handles:

* Student searching
* Course filtering
* Status filtering
* Year-level filtering
* Pagination

The `search` filter searches the student's:

* First name
* Last name
* Email

The default pagination size is 10 records per page.

## Model

The `Student` model represents student records in the database.

The model uses Laravel's `HasUuids` trait, allowing student records to use UUID identifiers.

The following fields are mass assignable:

```text
first_name
last_name
email
age
course
year_level
status
```

The model also casts:

```text
age
year_level
```

as integers.

## API Resource

The `StudentResource` controls the JSON representation of a student.

It returns the following fields:

```text
id
first_name
last_name
email
age
course
year_level
status
```

Using an API Resource provides a consistent response structure and controls which model attributes are exposed through the API.

# Data Flow

## POST `/api/students`

When a client sends a:

```http
POST /api/students
```

request, the data passes through several layers before it is stored in the database and returned to the client.

## Step 1 — HTTP Request

The client, such as Postman, sends the student's information:

```json
{
    "first_name": "Maria",
    "last_name": "Santos",
    "email": "maria@example.com",
    "age": 20,
    "course": "BSIT",
    "year_level": 2,
    "status": "active"
}
```

## Step 2 — Route

Laravel matches the request to the route generated by:

```php
Route::apiResource('students', StudentController::class);
```

The POST request is directed to:

```text
StudentController@store
```

## Step 3 — Form Request Validation

Before the controller processes the data, `StoreStudentRequest` validates the submitted information.

The request must satisfy the required validation rules.

For example:

* `first_name` must be provided and be a string.
* `email` must be a valid and unique email.
* `age` must be an integer of at least 15.
* `year_level` must be between 1 and 4.
* `status` must be `active` or `inactive`.

If validation fails, Laravel returns a `422` validation response and the data is not stored.

## Step 4 — Controller

After successful validation, `StudentController@store()` receives the validated data.

The controller calls:

```php
$this->studentService->createStudent(
    $request->validated()
);
```

The controller does not directly interact with the database.

## Step 5 — Service

The `StudentService` receives the validated student data.

It calls the repository:

```php
$this->studentRepository->create($data);
```

The service delegates the data operation to the repository layer.

## Step 6 — Repository Interface

The service communicates with the repository through:

```text
StudentRepositoryInterface
```

The interface defines the `create()` method that the repository must implement.

## Step 7 — Repository

The `StudentRepository` implements the repository interface.

Its `create()` method calls:

```php
Student::create($data);
```

This passes the validated student data to the Eloquent model.

## Step 8 — Model

The `Student` model handles the database record.

The model allows the following fields to be mass assigned:

```text
first_name
last_name
email
age
course
year_level
status
```

The `HasUuids` trait allows the student record to use a UUID.

## Step 9 — Database

Laravel Eloquent inserts the student record into the `students` table in MySQL.

The newly created student is then returned through the repository and service layers.

## Step 10 — API Resource

The controller receives the newly created student and wraps it using:

```php
new StudentResource($student)
```

The `StudentResource` formats the student into the API response structure.

## Step 11 — HTTP Response

The controller returns:

```php
return response()->json([
    'message' => 'Created successfully.',
    'data' => new StudentResource($student),
], Response::HTTP_CREATED);
```

The API sends an HTTP `201 Created` response to the client.

### Complete Data Flow

```text
Client / Postman
       ↓
POST /api/students
       ↓
Laravel Route
       ↓
StudentController
       ↓
StoreStudentRequest
       ↓
Validation
       ↓
StudentService
       ↓
StudentRepositoryInterface
       ↓
StudentRepository
       ↓
Student Model
       ↓
MySQL Database
       ↓
Created Student
       ↓
StudentResource
       ↓
JSON Response
       ↓
Client / Postman
```

# API Testing

The Student Management API was tested using Postman.

The following operations can be tested:

* View all students
* Search and filter students
* Create a student
* View a student by ID
* Update a student
* Delete a student

The main API endpoint is:

```text
http://localhost:8000/api/students
```

The API returns appropriate HTTP status codes for successful requests and validation or resource errors.
