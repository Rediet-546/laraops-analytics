# LaraOps Analytics Hub

A complete blog platform with analytics, user profiles, and AJAX comments.

## Features

- ✅ Blog posts with CRUD operations
- ✅ User authentication (Laravel Breeze)
- ✅ Analytics tracking (page views)
- ✅ User profiles with avatars
- ✅ AJAX comments system
- ✅ Dashboard with statistics
- ✅ Responsive design with Tailwind CSS

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve