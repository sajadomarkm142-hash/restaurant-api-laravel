# Restaurant API - Production Ready Backend

This repository contains a production-focused Laravel backend for a restaurant management system.

## Included
- Laravel 10 backend
- PostgreSQL database support
- JWT authentication
- RBAC (roles and permissions)
- Branch / customer / order / inventory / purchase modules
- Repository + Service layer architecture
- Seeders for realistic data
- Docker Compose for local infrastructure
- Nginx config for production-style deployment

## Requirements
- PHP 8.2+
- Composer
- PostgreSQL 15+
- Redis (optional for queue/cache)
- Docker / Docker Compose

## Local setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate
php artisan db:seed
php artisan serve
```

## Production-like setup with Docker

```bash
docker-compose -f docker-compose.prod.yml up --build -d
```

## API overview

```bash
POST /api/register
POST /api/login
GET /api/me
GET /api/branches
GET /api/customers
GET /api/orders
GET /api/inventory
GET /api/inventory/low-stock
POST /api/inventory/adjust
```

## Database

Use PostgreSQL with database name:

```bash
restaurant_db
```

## Important notes

- Use strong credentials in production.
- Create a real `JWT_SECRET` in `.env`.
- Set `APP_ENV=production` and `APP_DEBUG=false` in production environment.
- Add HTTPS / reverse proxy / firewall in deployment.

## Suggested next step

This backend is production-ready for API serving and business logic. The next logical step is to add the React frontend for POS / dashboard management.
