# Laravel Project: Core Models & Relations, EAV Implementation, API Endpoints, and Filtering

## Project Overview
Amer Reslan Technical Assessment

This project is a Laravel-based application that includes core models and relationships, an Entity-Attribute-Value (EAV) implementation for dynamic project attributes, RESTful API endpoints with authentication, and a flexible filtering system.


## The repository on github contains also a postman API collection

## Features

### Part 1: Core Models & Relations
- **User**: `first_name`, `last_name`, `email`, `password`
- **Project**: `name`, `status`
- **Timesheet**: `task_name`, `date`, `hours`
- Relationships:
  - A user can be assigned to multiple projects.
  - A project can have multiple users.
  - A user can log timesheets for multiple projects.
  - Each timesheet record is linked to one project and one user.

### Part 2: EAV (Entity-Attribute-Value) Implementation
- **Attribute**: `name`, `type` (text, date, number, select)
- **AttributeValue**: `attribute_id`, `project_id`, `value`
- Projects support dynamic fields like `department`, `start_date`, `end_date` through EAV.
- API endpoints to:
  - Create/Update attributes
  - Set attribute values when creating/updating projects
  - Fetch projects with their dynamic attributes
  - Filter projects by dynamic attribute values

### Part 3: API Endpoints
- **Auth**: `/api/register`, `/api/login`, `/api/logout`
- Standard CRUD for each model:
  - `GET /api/{model}`
  - `GET /api/{model}/{id}`
  - `POST /api/{model}`
  - `PUT /api/{model}/{id}`
  - `DELETE /api/{model}/{id}`

### Part 4: Filtering
- Support filtering on both regular and EAV attributes.
- Example: `GET /api/projects?filters[name]=ProjectA&filters[department]=IT`
- Support basic operators (`=`, `>`, `<`, `LIKE`).


## Setup Instructions


1. Clone the repository:
   ```sh
git clone https://github.com/amerr000/Amer-Reslan-Assessment-Astudio-.git
cd Amer-Reslan-Assessment-Astudio-
   ```

2. Install dependencies:
   ```sh
   composer install
   ```

3. Copy the `.env.example` file to `.env` and update the environment variables:
   ```sh
   cp .env.example .env
   ```

4. Configure Environment in `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. Generate Application Key:
   ```sh
   php artisan key:generate
   ```

6. Install Passport:
   ```sh
   php artisan passport:install
   ```

7. Run the database migrations and seeders:
   ```sh
   php artisan migrate --seed
   ```

8. Start the development server:
   ```sh
   php artisan serve
   ```

## API Documentation

### Authentication
- **Register**: `POST /api/register`
- **Login**: `POST /api/login`
- **Logout**: `POST /api/logout`

### Users
- **Get all users**: `GET /api/users`
- **Get a user**: `GET /api/users/{id}`
- **Update a user**: `PUT /api/users/{id}`
- **Delete a user**: `DELETE /api/users/{id}`

### Projects
- **Get all projects**: `GET /api/projects`
- **Get a project**: `GET /api/projects/{id}`
- **Create a project**: `POST /api/projects`
- **Update a project**: `PUT /api/projects/{id}`
- **Delete a project**: `DELETE /api/projects/{id}`
- **Set project attributes**: `POST /api/projects/{project}/attributes`
- **Get project attributes**: `GET /api/projects/{project}/attributes`

### Timesheets
- **Get all timesheets**: `GET /api/timesheets`
- **Get a timesheet**: `GET /api/timesheets/{id}`
- **Create a timesheet**: `POST /api/timesheets`
- **Update a timesheet**: `PUT /api/timesheets/{id}`
- **Delete a timesheet**: `DELETE /api/timesheets/{id}`

### Attributes
- **Get all attributes**: `GET /api/attributes`
- **Get an attribute**: `GET /api/attributes/{id}`
- **Create an attribute**: `POST /api/attributes`
- **Update an attribute**: `PUT /api/attributes/{id}`
- **Delete an attribute**: `DELETE /api/attributes/{id}`

### Attribute Values
- **Get all attribute values**: `GET /api/attribute-values`
- **Get an attribute value**: `GET /api/attribute-values/{id}`
- **Create an attribute value**: `POST /api/attribute-values`
- **Update an attribute value**: `PUT /api/attribute-values/{id}`
- **Delete an attribute value**: `DELETE /api/attribute-values/{id}`

### Filtering
Supports filtering by both standard and dynamic attributes:

- To get all projects with `status = active`:
  ```
  GET /api/projects?filters[status][operator]==&filters[status][value]=active
  ```

- To get projects where `start_date > 2024-01-01`:
  ```
  GET /api/projects?filters[start_date][operator]=>&filters[start_date][value]=2024-01-01
  ```

- Search projects where `name` contains "Alpha":
  ```
  GET /api/projects?filters[name][operator]=LIKE&filters[name][value]=Alpha
  ```

- Get projects where `department` is "IT" (EAV filtering):
  ```
  GET /api/projects?filters[department][operator]==&filters[department][value]=IT
  ```

## Example Requests/Responses

### Register

#### Request :
```json
POST /api/register
{
    "first_name": "John",
    "last_name": "Doe",
    "email": "john.doe@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

#### Response :
```json
{
    "message": "Registration successfully completed",
    "token": "access_token"
}
```

### Login

#### Request :
```json
POST /api/login
{
    "email": "john.doe@example.com",
    "password": "password"
}
```

#### Response :
```json
{
    "user": {
        "id": 1,
        "first_name": "John",
        "last_name": "Doe",
        "email": "john.doe@example.com"
    },
    "token": "access_token"
}

```


### search with filter status=active

#### Response
```json
[
    {
        "id": 1,
        "name": "Project Alpha",
        "status": "active",
        "created_at": "2025-03-17T19:30:24.000000Z",
        "updated_at": "2025-03-17T19:30:24.000000Z",
        "attribute_values": [
            {
                "id": 1,
                "value": "IT Department",
                "attribute_id": 1,
                "project_id": 1,
                "created_at": "2025-03-17T19:30:24.000000Z",
                "updated_at": "2025-03-17T19:30:24.000000Z",
                "attribute": {
                    "id": 1,
                    "name": "department",
                    "data_type": "text",
                    "created_at": "2025-03-17T19:30:24.000000Z",
                    "updated_at": "2025-03-17T19:30:24.000000Z"
                }
            },
            {
                "id": 2,
                "value": "2024-01-01",
                "attribute_id": 2,
                "project_id": 1,
                "created_at": "2025-03-17T19:30:24.000000Z",
                "updated_at": "2025-03-17T19:30:24.000000Z",
                "attribute": {
                    "id": 2,
                    "name": "start_date",
                    "data_type": "date",
                    "created_at": "2025-03-17T19:30:24.000000Z",
                    "updated_at": "2025-03-17T19:30:24.000000Z"
                }
            },
            {
                "id": 3,
                "value": "2024-12-31",
                "attribute_id": 3,
                "project_id": 1,
                "created_at": "2025-03-17T19:30:24.000000Z",
                "updated_at": "2025-03-17T19:30:24.000000Z",
                "attribute": {
                    "id": 3,
                    "name": "end_date",
                    "data_type": "date",
                    "created_at": "2025-03-17T19:30:24.000000Z",
                    "updated_at": "2025-03-17T19:30:24.000000Z"
                }
            }
        ]
    },
    {
        "id": 3,
        "name": "Project Gamma",
        "status": "active",
        "created_at": "2025-03-17T19:30:24.000000Z",
        "updated_at": "2025-03-17T19:30:24.000000Z",
        "attribute_values": []
    }
]

```



### Test credentials

#### Request
```json
{
    "email":"amerreslan13@gmail.com",
    "password":"123456"
}

```