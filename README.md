## Software Development 4207 — REST API

A Laravel-based REST API for managing Schools, Managers, Admins, Grades, and Teachers. The API uses SQLite by default and exposes simple JSON CRUD endpoints without pagination. Validation is handled via Laravel Form Requests.

## Tech stack

- PHP 8.3 + Laravel 12
- SQLite (default) — file at `database/database.sqlite`
- PHPUnit for tests

## Quick start (Windows)

Prerequisites: PHP 8.3, Composer. Node.js is optional (not required for the API).

1) Install dependencies

```
composer install
```

2) App key and environment

- Ensure your `.env` is configured to use SQLite and points to `database/database.sqlite`.
- Generate an app key:

```
php artisan key:generate
```

3) Database

- The SQLite file exists at `database/database.sqlite`. If missing, create an empty file at that path.
- Run migrations:

```
php artisan migrate
```

4) Run the API server

```
php artisan serve
```

The server will start on http://127.0.0.1:8000. A project-level `server.php` router is included to support the built-in server.

## Base URL

- Local: `http://127.0.0.1:8000`
- API prefix: `/api`

## Authentication

No authentication is enabled. Password fields for Admins/Managers/Teachers are hashed automatically via Laravel casts.

## Entities and relationships

- School has many Managers, Grades, Teachers
- Manager belongs to School
- Admin belongs to Manager
- Grade belongs to School; has many Teachers
- Teacher belongs to School and (optionally) to a Grade

Soft deletes are enabled on core tables. Unique constraints include unique emails and per-school grade code uniqueness.

## Validation and conventions

- Validation is defined in Form Requests under `app/Http/Requests` (Store/Update per resource).
- Index endpoints return full collections (no pagination).
- Common enums:
	- School: `status` (active|inactive), `type`, `level`
	- Grade: `status` (active|inactive)

## Endpoints overview

Base path: `/api`

- Health
	- GET `/api/ping` → `{ "pong": true }`

- Schools
	- GET `/api/schools`
	- POST `/api/schools` — `{ name, address, status, type, level }`
	- GET `/api/schools/{id}`
	- PUT `/api/schools/{id}`
	- DELETE `/api/schools/{id}`

- Managers
	- GET `/api/managers` (eager-loads `school`)
	- POST `/api/managers` — `{ name, email, password, school_id }`
	- GET `/api/managers/{id}`
	- PUT `/api/managers/{id}`
	- DELETE `/api/managers/{id}`

- Admins
	- GET `/api/admins` (eager-loads `manager`)
	- POST `/api/admins` — `{ name, email, password, manager_id? }`
	- GET `/api/admins/{id}`
	- PUT `/api/admins/{id}`
	- DELETE `/api/admins/{id}`

- Grades
	- GET `/api/grades` (eager-loads `school`)
	- POST `/api/grades` — `{ school_id, name, code, status }`
	- GET `/api/grades/{id}`
	- PUT `/api/grades/{id}`
	- DELETE `/api/grades/{id}`

- Teachers
	- GET `/api/teachers` (eager-loads `school`, `grade`)
	- POST `/api/teachers` — `{ school_id, grade_id?, name, email, password }`
	- GET `/api/teachers/{id}`
	- PUT `/api/teachers/{id}`
	- DELETE `/api/teachers/{id}`

Notes

- Create a School first, then you can create Managers, Grades, and Teachers under it. Teachers may optionally reference a Grade.
- Email fields must be unique. Grade `code` is unique per school.

## Comments & Ratings (polymorphic)

This project supports polymorphic Comments and Ratings which can be attached to multiple entity types (currently Schools and Teachers).

- Comments (polymorphic)
	- CRUD endpoints: `/api/comments`
	- Create example body to attach to a school:

```json
{
	"commentable_type": "App\\Models\\School",
	"commentable_id": 1,
	"author": "Alice",
	"body": "Great school!"
}
```

- Ratings (polymorphic)
	- CRUD endpoints: `/api/ratings`
	- Average endpoint: POST `/api/ratings/average` with body `{ rateable_type, rateable_id }` returns `{ average }`.
	- Create example to attach to a teacher:

```json
{
	"rateable_type": "App\\Models\\Teacher",
	"rateable_id": 1,
	"author": "Parent",
	"score": 5,
	"note": "Very supportive"
}
```

Notes

- `*_type` expects the fully-qualified model class string (for example `App\\Models\\School` or `App\\Models\\Teacher`).
- You can query comments/ratings via the top-level endpoints and filter by `commentable_type/commentable_id` or `rateable_type/rateable_id` client-side.


## Postman collection

Import `postman/software-development-4207.postman_collection.json` into Postman.

- Variables: the collection captures created IDs (e.g., `schoolId`, `gradeId`) for chaining requests.
- Base URL: set to `http://127.0.0.1:8000` if not set automatically.

## Running tests

```
vendor\bin\phpunit.bat
```

There is a simple health check test for `/api/ping`. More tests can be added under `tests/`.

## Troubleshooting

- HTTP 500 "no such table": Run migrations — `php artisan migrate`.
- `php artisan serve` complains about router: This repo includes `server.php` at the project root for the built-in server.
- Empty lists: Newly created tables start empty; use the POST endpoints to create records.



## License

MIT
