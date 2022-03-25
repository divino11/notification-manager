## About Project
Notification-manager
- All validations rules are in app/Http/Requests
- Notifications are in app/Http/Notifications
- All controllers are in app/Http/Controllers

For check email notification `http://localhost:8025`

Technologies stack:
- Laravel 9.*
- Laravel Sail
- PHP 8.0
- Postgresql 13
- Redis
- Mailhog
- Vonage (for SMS notification)

## How to start
- Clone from github `git clone git@github.com:divino11/notification-manager.git`
- `cp .env.example .env` copy environment file (I left all variables)
- `composer install` for install all packages
- `./vendor/bin/sail up -d` for build containers and run docker
- `docker compose exec laravel.test php artisan key:generate` generate new application key
- `docker compose exec laravel.test php artisan migrate` migrate database
- `docker compose exec laravel.test php artisan l5-swagger:generate` generate swagger documentation

## API Documentation

Read the API docs on the `http://localhost/api/documentation`
