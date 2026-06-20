# Elama Healthcare Solutions — Corporate Website

Premium pharmaceutical corporate website built with **Laravel 12**, **Tailwind CSS 4**, **Alpine.js**, and **Vite**.

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 12, PHP 8.2+ |
| Frontend | Blade, Tailwind CSS 4, Alpine.js |
| Build | Vite, Node.js 22+ |
| Database | MySQL (recommended) / SQLite (dev) |
| Auth | Laravel Breeze (admin only) |
| Cache / Queue | Database driver (production-ready) |

## Features

- 14 public pages with premium corporate UI
- 338 products imported from Excel with search, filter, and detail pages
- Full CMS admin panel at `/admin`
- SEO (meta, Open Graph, Schema.org, sitemap, robots.txt)
- Contact form with email notifications
- Careers with resume upload
- CSR gallery with Lightbox
- Interactive global presence map

## Quick Start

### 1. Install dependencies

```bash
composer install
npm install
```

### 2. Environment

```bash
cp .env.example .env
php artisan key:generate
```

For **MySQL**, create database `elama_healthcare` and set credentials in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=elama_healthcare
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. Database & assets

```bash
php artisan migrate:fresh --seed
npm run build
```

### 4. Run

```bash
php artisan serve
npm run dev   # in another terminal for hot reload
```

Visit: **http://localhost:8000**

## Production deployment (Hostinger / shared hosting)

### 1. Build assets on your computer (required)

```bash
npm install
npm run build
```

This creates `public/build/` with `manifest.json` and CSS/JS files.

### 2. Upload to server

Upload these folders/files via FTP or File Manager:

- `public/build/` → entire folder (includes `manifest.json` + `assets/`)
- `public/images/` → logos and site images
- All Laravel app files + `vendor/` (or run `composer install` on server)

Server path example:

```
/home/u977698748/domains/elamahealthcare.com/laravel/elamahealthcare/public/build/manifest.json
```

### 3. Server commands

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Or use `./deploy.sh` from the Laravel project root (syncs `public/uploads/` to `public_html` automatically).

### 4. `.env` on production

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://elamahealthcare.com
```

**Important:** If you see `Vite manifest not found`, the `public/build/` folder was not uploaded. Run `npm run build` locally and upload it again.

## Admin Access

| | |
|---|---|
| URL | `/login` → redirects to `/admin` |
| Email | `admin@elamahealthcare.com` |
| Password | `password` |

Change the admin password immediately in production.

## Project Structure

```
app/
├── Http/Controllers/     # Frontend + Admin controllers
├── Models/                 # Eloquent models
├── Repositories/           # Data access layer
├── Services/               # Business logic
resources/views/
├── layouts/                # Main layout
├── components/             # Reusable Blade components
├── pages/                  # Public pages
└── admin/                  # Admin panel
public/images/              # Static assets
database/seeders/           # Content + product import
routes/
├── web.php                 # Public routes
└── admin.php               # Admin web + API routes
```

## Production Checklist

- [ ] Set `APP_ENV=production`, `APP_DEBUG=false`
- [ ] Configure MySQL and run migrations
- [ ] Set up SMTP mail in `.env`
- [ ] Run `php artisan config:cache && php artisan route:cache && php artisan view:cache`
- [ ] Configure queue worker: `php artisan queue:work`
- [ ] Set up cron for scheduler
- [ ] Change admin password
- [ ] Enable HTTPS

## Company Content Source

Content imported from company profile documents and product Excel list located in `_source/`.

---

© Elama Healthcare Solutions Pvt. Ltd.
