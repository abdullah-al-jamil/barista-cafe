# Barista Cafe - Vue.js + Laravel Project

A modern coffee shop website with Vue.js SPA frontend and Laravel API backend.

## Project Structure

```
barista-cafe/
├── backend/          # Laravel 11 API
│   ├── app/
│   │   ├── Http/Controllers/Api/
│   │   └── Models/
│   ├── database/migrations/
│   └── routes/api.php
│
└── frontend/         # Vue 3 SPA
    └── src/
        ├── views/
        ├── stores/
        ├── services/
        └── router/
```

## Setup Instructions

### Backend (Laravel)

```bash
cd backend

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed initial data
php artisan db:seed

# Start server
php artisan serve
```

**Default Admin Credentials:**
- Email: admin@baristacafe.com
- Password: password123

### Frontend (Vue.js)

```bash
cd frontend

# Install dependencies
npm install

# Start development server
npm run dev
```

The frontend will run on `http://localhost:5173`

## Features

### Public Pages
- **Home**: Hero slider, about section, team showcase, menu preview, testimonials
- **Menu**: Full menu with category filtering
- **About**: Company story and team
- **Contact**: Reservation form

### Admin Dashboard
- **Hero Slides**: Manage homepage slider
- **Menu**: CRUD for categories and items
- **Team**: Manage team members
- **Reviews**: Approve/reject testimonials
- **Reservations**: View and manage bookings

## API Endpoints

See `routes/api.php` for complete endpoint documentation.

### Public
- `GET /api/public/hero-slides`
- `GET /api/public/about`
- `GET /api/public/team`
- `GET /api/public/menu`
- `GET /api/public/testimonials`
- `POST /api/public/reservations`

### Admin (Requires Auth)
- `POST /api/auth/login`
- `GET /api/admin/dashboard/stats`
- Full CRUD for hero slides, team, menu, testimonials, reservations

## Tech Stack

- **Frontend**: Vue 3, Vite, Pinia, Vue Router, Tailwind CSS, Axios
- **Backend**: Laravel 11, Sanctum, MySQL
- **Design**: Bootstrap 5 → Tailwind conversion

## Development Notes

1. The frontend proxies `/api` requests to `http://localhost:8000`
2. Run `php artisan serve` before starting the frontend
3. Admin routes are protected with Laravel Sanctum
4. Run seeders after fresh migration to populate sample data
