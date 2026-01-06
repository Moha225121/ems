# EMS

Modern equipment management with reservations, check-in/out tracking, and bilingual (EN/AR) UI built on Laravel + Tailwind + Breeze.

## Quick start

```bash
cp .env.example .env
php artisan key:generate

# configure DB in .env (MariaDB)
php artisan migrate --seed

npm install
npm run build   # or: npm run dev

php artisan serve
```

Default login (seeded): test@example.com / password

## Features
- Equipment CRUD with status badges (available/reserved/checked out)
- Reservation flow with date/time/note, cancellation, and detail pages
- Check-in/out transactions with notes
- Glassmorphism theme, RTL-aware layout, language switcher
- Usage reports scaffold

## Scripts
- php artisan test — run backend tests
- npm run dev / npm run build — asset pipeline

## Notes
- Keep vendor/, node_modules/, and public/build/ out of git (see .gitignore).
