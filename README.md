# Restaurant API

This project is a Laravel API for a restaurant management system, built with PostgreSQL and JWT authentication.

## Requirements
- PHP 8.2
- Composer
- PostgreSQL
- Docker (optional)

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate
php artisan db:seed
php artisan serve
```

## API endpoints
- POST /api/register
- POST /api/login
- GET /api/me
- GET /api/branches
- GET /api/menu-items
- GET /api/orders
- PATCH /api/orders/{id}/status
- GET /api/dashboard/summary

## Swagger
Open:

```bash
http://localhost:8000/api/documentation
```

## Docker

```bash
docker-compose up --build
```
