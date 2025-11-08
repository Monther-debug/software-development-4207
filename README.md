## Software Development 4207 — School Management REST API

A Laravel-based REST API for managing Schools, Managers, Admins, Teachers, Grades, Fees, Ratings, and Comments. The API uses SQLite and provides role-based access control with JWT authentication for three user types: Admin, Manager, and User.

## Tech Stack

- **PHP 8.2+** with **Laravel 12**
- **SQLite** database (file at `database/database.sqlite`)
- **JWT Authentication** (`tymon/jwt-auth`) with three separate guards
- **Form Request Validation** for all inputs
- **API Resource Classes** for standardized JSON responses
- **PHPUnit** for testing

## Quick Start

**Prerequisites:** PHP 8.2+, Composer installed

### 1. Install Dependencies

```bash
composer install
```

### 2. Environment Setup

Copy the example environment file and generate application key:

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Configure JWT Authentication

Generate JWT secret key:

```bash
php artisan jwt:secret
```

This adds `JWT_SECRET` to your `.env` file for signing authentication tokens.

### 4. Database Setup

The SQLite file should already exist at `database/database.sqlite`. If missing, create it:

```bash
touch database/database.sqlite
```

Run migrations and seed the database:

```bash
php artisan migrate:fresh --seed
```

This creates all tables and adds sample data:
- 3 Schools with Managers and Admins
- 12 Grades (Grade 1-12)
- 3 Teachers
- 2 Users
- Sample Fees, Ratings, and Comments

### 5. Start the Server

```bash
php artisan serve --port=8001
```

The API will be available at **http://127.0.0.1:8001**

## API Overview

**Base URL:** `http://127.0.0.1:8001/api`

The API follows a role-based access control pattern with three distinct user types:

### 1. **Admin** (Super Admin)
- **Authentication:** phone_number + password
- **Permissions:** Full CRUD on Schools, Managers, Teachers; Read-only access to Success Ratings
- **Login:** `POST /api/admin/login`

### 2. **Manager** (School Manager)
- **Authentication:** phone_number + password
- **Permissions:** Manage Grades, Fees, School-Teacher assignments, Success Ratings (scoped to their school)
- **Login:** `POST /api/manager/login`

### 3. **User** (Public/Parent/Student)
- **Authentication:** email + password
- **Permissions:** Create and manage their own Ratings and Comments for schools
- **Registration:** `POST /api/user/register`
- **Login:** `POST /api/user/login`

## Authentication

All three user types use **JWT (JSON Web Token)** authentication with separate guards.

### Test Credentials

After running seeders, you can use these credentials:

**Admin:**
```json
{
  "phone_number": "0987654321",
  "password": "password"
}
```

**Manager:**
```json
{
  "phone_number": "1234567890",
  "password": "password"
}
```

**User:**
```json
{
  "email": "user@example.com",
  "password": "password"
}
```

### Authentication Flow

1. **Login** to your respective endpoint
2. **Receive JWT token** in response: `{ "access_token": "eyJ0...", ... }`
3. **Include token** in all subsequent requests:
   ```
   Authorization: Bearer {your-token}
   ```
4. **Logout** when done: `POST /api/{role}/logout`

## Data Model

The API manages the following entities:

### Core Entities

- **School** - Educational institutions
  - Fields: `name`, `address`, `status` (active|inactive), `type` (male|uni_gender), `level` (primary|secondary)
  - Has many: Managers, Teachers

- **Manager** - School administrators
  - Fields: `name`, `username`, `phone_number`, `password`, `schoolID`
  - Belongs to: School
  - Authentication: phone_number

- **Admin** - System administrators
  - Fields: `name`, `username`, `phone_number`, `password`
  - Authentication: phone_number

- **Grade** - Education levels (Grade 1-12)
  - Fields: `name`
  - Independent entity (no school relationship)

- **Teacher** - Teaching staff
  - Fields: `name`, `subject`, `experience`
  - Can be assigned to schools via pivot table

- **User** - Public users (parents/students)
  - Fields: `name`, `email`, `password`
  - Authentication: email

### Relationship Entities

- **Fee** - Tuition fees per school and grade
  - Fields: `schoolID`, `gradeID`, `amount`

- **SchoolTeacher** (Pivot) - Teacher assignments to schools
  - Fields: `schoolID`, `teacherID`, `gradeID`, `year`

- **Rating** - User ratings for schools
  - Fields: `schoolID`, `userID`, `rating` (enum: '1'-'5')
  - User can rate each school only once

- **Comment** - User comments about schools
  - Fields: `schoolID`, `userID`, `comment`

- **SuccessRating** - Academic performance metrics per school and grade
  - Fields: `schoolID`, `gradeID`, `total_students`, `A`, `B`, `C`, `D`

### Field Naming Convention

The API uses **camelCase suffixes** for foreign keys:
- `schoolID` (not school_id)
- `gradeID` (not grade_id)
- `teacherID` (not teacher_id)
- `userID` (not user_id)

## API Endpoints

All endpoints require JWT authentication except login and registration endpoints.

### Admin Endpoints (`/api/admin`)

**Authentication:**
- `POST /api/admin/login` - Login with phone_number and password
- `POST /api/admin/logout` - Logout and invalidate token

**Schools:**
- `GET /api/admin/schools` - List all schools
- `POST /api/admin/schools` - Create school
- `GET /api/admin/schools/{id}` - Get school details
- `PUT /api/admin/schools/{id}` - Update school
- `DELETE /api/admin/schools/{id}` - Delete school

**Managers:**
- `GET /api/admin/managers` - List all managers
- `POST /api/admin/managers` - Create manager
- `GET /api/admin/managers/{id}` - Get manager details
- `PUT /api/admin/managers/{id}` - Update manager
- `DELETE /api/admin/managers/{id}` - Delete manager

**Teachers:**
- `GET /api/admin/teachers` - List all teachers
- `POST /api/admin/teachers` - Create teacher
- `GET /api/admin/teachers/{id}` - Get teacher details
- `PUT /api/admin/teachers/{id}` - Update teacher
- `DELETE /api/admin/teachers/{id}` - Delete teacher

**Success Ratings (Read-Only):**
- `GET /api/admin/school-success-rate` - List all success ratings
- `GET /api/admin/school-success-rate/{schoolId}` - Get ratings for specific school

### Manager Endpoints (`/api/manager`)

**Authentication:**
- `POST /api/manager/login` - Login with phone_number and password
- `POST /api/manager/logout` - Logout and invalidate token

**Grades:**
- `GET /api/manager/grades` - List all grades
- `POST /api/manager/grades` - Create grade
- `GET /api/manager/grades/{id}` - Get grade details
- `PUT /api/manager/grades/{id}` - Update grade
- `DELETE /api/manager/grades/{id}` - Delete grade

**Fees:**
- `GET /api/manager/fees` - List fees for manager's school
- `POST /api/manager/fees` - Create fee
- `GET /api/manager/fees/{id}` - Get fee details
- `PUT /api/manager/fees/{id}` - Update fee
- `DELETE /api/manager/fees/{id}` - Delete fee

**School-Teacher Assignments:**
- `GET /api/manager/schools/{schoolId}/teachers` - List teachers in school
- `POST /api/manager/schools/{schoolId}/teachers` - Assign teacher to school
- `PUT /api/manager/schools/{schoolId}/teachers/{teacherId}` - Update assignment
- `DELETE /api/manager/schools/{schoolId}/teachers/{teacherId}` - Remove teacher

**Success Ratings:**
- `GET /api/manager/success-ratings` - List ratings for manager's school
- `POST /api/manager/success-ratings` - Create success rating
- `GET /api/manager/success-ratings/{id}` - Get rating details
- `PUT /api/manager/success-ratings/{id}` - Update rating
- `DELETE /api/manager/success-ratings/{id}` - Delete rating

### User Endpoints (`/api/user`)

**Authentication:**
- `POST /api/user/register` - Register new user account
- `POST /api/user/login` - Login with email and password
- `POST /api/user/logout` - Logout and invalidate token

**Ratings:**
- `GET /api/user/ratings` - List user's own ratings
- `POST /api/user/ratings` - Create rating for a school
- `GET /api/user/ratings/{id}` - Get rating details
- `PUT /api/user/ratings/{id}` - Update rating
- `DELETE /api/user/ratings/{id}` - Delete rating

**Comments:**
- `GET /api/user/comments` - List user's own comments
- `POST /api/user/comments` - Create comment for a school
- `GET /api/user/comments/{id}` - Get comment details
- `PUT /api/user/comments/{id}` - Update comment
- `DELETE /api/user/comments/{id}` - Delete comment

## Request/Response Examples

### Admin: Create School

**Request:**
```bash
curl -X POST http://127.0.0.1:8001/api/admin/schools \
  -H "Authorization: Bearer {admin-token}" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Central High School",
    "address": "123 Main Street",
    "status": "active",
    "type": "male",
    "level": "secondary"
  }'
```

**Response:**
```json
{
  "data": {
    "id": 1,
    "name": "Central High School",
    "address": "123 Main Street",
    "status": "active",
    "type": "male",
    "level": "secondary"
  }
}
```

### Manager: Create Fee

**Request:**
```bash
curl -X POST http://127.0.0.1:8001/api/manager/fees \
  -H "Authorization: Bearer {manager-token}" \
  -H "Content-Type: application/json" \
  -d '{
    "gradeID": 1,
    "amount": 750.00
  }'
```

**Response:**
```json
{
  "data": {
    "id": 1,
    "schoolID": 1,
    "gradeID": 1,
    "amount": 750.00
  }
}
```

### User: Create Rating

**Request:**
```bash
curl -X POST http://127.0.0.1:8001/api/user/ratings \
  -H "Authorization: Bearer {user-token}" \
  -H "Content-Type: application/json" \
  -d '{
    "schoolID": 1,
    "rating": "5"
  }'
```

**Response:**
```json
{
  "data": {
    "id": 1,
    "schoolID": 1,
    "userID": 1,
    "rating": "5"
  }
}
```

## Validation

All create and update operations use **Laravel Form Request** classes with comprehensive validation rules:

- **Required fields** are enforced
- **Unique constraints** on phone numbers and emails
- **Enum validation** for status, type, level, rating fields
- **Foreign key validation** ensures referenced records exist
- **Authorization policies** ensure users can only modify their own resources


## Postman Collection

Two Postman collections are available in the `postman/` directory:

### Updated Collection (Recommended)
**File:** `postman/software-development-4207-updated.postman_collection.json`

This collection includes:
- ✅ All 56 current API endpoints
- ✅ Correct base URL (port 8001)
- ✅ Separate folders for Admin, Manager, and User
- ✅ Auto-capture JWT tokens from login responses
- ✅ Updated field naming (schoolID, gradeID, etc.)
- ✅ Pre-configured test credentials
- ✅ Auto-capture resource IDs for request chaining

**To use:**
1. Import `postman/software-development-4207-updated.postman_collection.json` into Postman
2. Start with authentication endpoints (Admin/Manager/User Login)
3. Token will be automatically saved and used in subsequent requests
4. Created resource IDs are automatically captured for testing

### Legacy Collection
**File:** `postman/software-development-4207.postman_collection.json`

Contains the original structure with polymorphic relationships. Not compatible with current API.

## Testing

### PHPUnit Tests

Run the test suite:

```bash
php artisan test
```

Or using PHPUnit directly:

```bash
vendor/bin/phpunit
```

### Manual Endpoint Testing

A comprehensive testing guide is available in `API_TESTING_GUIDE.md` with curl commands for all 56 endpoints.

**Quick test script:**

```bash
# Make the script executable
chmod +x run_tests.sh

# Run tests (requires server running on port 8001)
./run_tests.sh
```

**Note:** Keep the Laravel server running in a separate terminal when testing:

```bash
php artisan serve --port=8001
```

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Admin role controllers
│   │   ├── Manager/        # Manager role controllers
│   │   └── User/           # User role controllers
│   ├── Requests/           # Form Request validation (14 classes)
│   └── Resources/          # API Resources for JSON responses
├── Models/                 # Eloquent models
└── Providers/

database/
├── migrations/             # Database schema
└── seeders/                # Sample data seeders (9 seeders)

postman/
├── software-development-4207-updated.postman_collection.json  # Current
└── software-development-4207.postman_collection.json          # Legacy

routes/
└── api.php                 # All API routes (56 endpoints)
```

## Code Architecture

The project follows Laravel best practices:

- **Thin Controllers:** Business logic in Form Requests and Models
- **Form Request Validation:** All inputs validated before reaching controllers
- **API Resources:** Standardized JSON response format
- **JWT Guards:** Separate authentication contexts for each role
- **Eloquent Relationships:** Proper model relationships with eager loading
- **Database Seeders:** Reproducible test data

## Troubleshooting

### Common Issues

**"JWT secret not set"**
- Run: `php artisan jwt:secret`
- Verify `JWT_SECRET` exists in `.env`

**"No such table" errors**
- Run: `php artisan migrate:fresh --seed`
- Verify `database/database.sqlite` exists

**Authentication fails with valid credentials**
- Check you're using the correct login endpoint for your role:
  - Admin: `/api/admin/login` with `phone_number`
  - Manager: `/api/manager/login` with `phone_number`
  - User: `/api/user/login` with `email`

**"Unauthenticated" on protected endpoints**
- Verify JWT token is included: `Authorization: Bearer {token}`
- Check token hasn't expired
- Ensure you're using the correct guard's token

**Server not responding**
- Confirm server is running: `php artisan serve --port=8001`
- Check correct port in requests (8001, not 8000)

**Validation errors**
- Check field names use camelCase suffixes: `schoolID`, `gradeID`, not `school_id`, `grade_id`
- Verify rating values are strings: `"1"` to `"5"`, not integers
- Ensure all required fields are provided

**Foreign key constraint errors**
- Verify referenced IDs exist (schoolID, gradeID, etc.)
- Check user has permission to access the resource

## Additional Documentation

- **API Testing Guide:** See `API_TESTING_GUIDE.md` for detailed endpoint documentation with curl examples
- **Endpoint Tests:** See `ENDPOINT_TESTS.md` for block-by-block testing commands
- **Test Script:** See `run_tests.sh` for automated testing

## Contributing

When making changes:
1. Update Form Request validation rules in `app/Http/Requests/`
2. Update API Resources in `app/Http/Resources/` for response formatting
3. Follow the thin controller pattern - keep controllers simple
4. Use camelCase for foreign key fields (schoolID, gradeID, etc.)
5. Update tests in `tests/` directory
6. Update this README and documentation files

## License

MIT
