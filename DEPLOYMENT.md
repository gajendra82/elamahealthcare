# Elama Healthcare — Production Deployment (Hostinger)

This guide covers fully automated deployment to **Hostinger Shared Hosting** with zero manual steps after `git pull`.

---

## Server Structure

```
domains/elamahealthcare.com/
├── laravel/
│   └── elamahealthcare/          ← Laravel root (git repository)
│       ├── app/
│       ├── bootstrap/
│       ├── config/
│       ├── deployment/hostinger/   ← Hostinger templates & deploy script
│       ├── public/
│       ├── storage/
│       ├── vendor/
│       ├── artisan
│       └── deploy.sh               ← Wrapper → deployment/hostinger/deploy.sh
└── public_html/                    ← Web document root (NOT in git)
    ├── index.php                   ← Auto-generated every deploy
    ├── .htaccess                   ← Auto-copied every deploy
    ├── build/                      ← Synced from public/build
    ├── images/                     ← Static assets (synced)
    └── uploads/                    ← CMS uploads (preserved across deploys)
```

---

## Requirements

### Server (Hostinger SSH)

- PHP 8.2+
- Composer
- Git
- rsync
- Extensions: pdo, mbstring, openssl, tokenizer, xml, ctype, json, fileinfo

### Optional (for on-server builds)

- Node.js 18+ and npm (if not building assets locally)

### Hostinger Limitations

These PHP functions are **disabled** — the application never uses them:

- `exec()`, `shell_exec()`, `system()`
- `symlink()`, `link()`

Therefore:

- ❌ Never run `php artisan storage:link`
- ❌ Never depend on `public/storage`
- ✅ Use `public/uploads/` for CMS uploads

---

## First Deployment

### 1. Clone repository on server

```bash
cd ~/domains/elamahealthcare.com/laravel
git clone <repository-url> elamahealthcare
cd elamahealthcare
```

### 2. Create `.env`

```bash
cp .env.example .env
nano .env
```

Production `.env` essentials:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://elamahealthcare.com
APP_KEY=base64:...   # php artisan key:generate

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

SESSION_DRIVER=file
CACHE_STORE=file
DEPLOYMENT_MODE=hostinger
SHARED_HOSTING=true

PUBLIC_HTML_PATH=/home/u977698748/domains/elamahealthcare.com/public_html
LARAVEL_RELATIVE_FROM_PUBLIC_HTML=../laravel/elamahealthcare
```

### 3. Generate APP_KEY

```bash
php artisan key:generate
```

### 4. Deploy

```bash
chmod +x deploy.sh
./deploy.sh
```

The script handles everything: dependencies, build, migrations, caching, rsync, bootstrap files, validation.

---

## Subsequent Deployment

Every update is identical:

```bash
cd ~/domains/elamahealthcare.com/laravel/elamahealthcare
git pull   # optional — deploy.sh also runs git pull
./deploy.sh
```

**Zero manual steps.**

---

## What `deploy.sh` Does

1. `git pull`
2. `composer install --no-dev --prefer-dist --optimize-autoloader`
3. `npm ci` (only if `package-lock.json` changed) + `npm run build`
4. Fails if `public/build/manifest.json` is missing
5. `php artisan optimize:clear`
6. `php artisan migrate --force`
7. `php artisan db:seed --class=SettingSeeder --force`
8. Creates `public/uploads/`, merges legacy `storage/app/public/` if present
9. `php artisan config:cache`, `route:cache`, `view:cache`
10. `php artisan app:validate-assets`
11. Backs up `public_html/` (for rollback)
12. `rsync -av --delete --exclude uploads/ public/ → public_html/`
13. Generates `public_html/index.php` from template
14. Copies `public_html/.htaccess` from template
15. Syncs `uploads/` separately (preserved)
16. `php artisan app:doctor --deploy`

---

## Rollback

If deployment fails, the script automatically restores `public_html/` from the backup in:

```
storage/app/deploy-backups/YYYYMMDD-HHMMSS/
```

To manually rollback code:

```bash
git log --oneline -5
git checkout <previous-commit>
./deploy.sh
```

---

## Diagnostic Commands

### Asset validation

```bash
php artisan app:validate-assets
```

### Full production doctor

```bash
php artisan app:doctor
```

### Post-deployment check

```bash
php artisan app:doctor --deploy
```

---

## Upload Handling

| Type | Path | Purpose |
|------|------|---------|
| Static images | `public/images/` | Logo, banners, CSR, leadership (committed to git) |
| CMS uploads | `public/uploads/` | Admin uploads (banners, products, media, resumes) |

`StorageService` automatically selects:

- **Local dev:** `storage/app/public` (disk: `public`)
- **Hostinger:** `public/uploads` (disk: `uploads`)

Database stores relative paths (e.g. `banners/abc.jpg`) — URLs resolve automatically.

---

## Build Process

### Option A: Build on server (if Node.js available)

`deploy.sh` runs `npm ci` + `npm run build` automatically.

### Option B: Build locally, commit assets

```bash
npm ci
npm run build
git add public/build
git commit -m "Build production assets"
git push
```

If npm is unavailable on server, committed `public/build/` is synced via rsync.

---

## Environment Variables

| Variable | Description |
|----------|-------------|
| `SHARED_HOSTING` | Force Hostinger upload mode (`true`/`false`) |
| `DEPLOYMENT_MODE` | `hostinger` or `local` |
| `PUBLIC_HTML_PATH` | Absolute path to web root |
| `LARAVEL_RELATIVE_FROM_PUBLIC_HTML` | Relative path in index.php (default: `../laravel/elamahealthcare`) |
| `SESSION_DRIVER` | Default `file` (no sessions table needed) |
| `CACHE_STORE` | Default `file` (no cache table needed) |

---

## Database Setup

```bash
# Create database in Hostinger hPanel first, then:
php artisan migrate --force
php artisan db:seed --force   # first deploy only
```

Products table supports long names:

- `product_name` → TEXT
- `slug` → VARCHAR(512) with safe truncation via `SlugHelper`

---

## Cron Setup (optional)

```cron
* * * * * cd /home/u977698748/domains/elamahealthcare.com/laravel/elamahealthcare && php artisan schedule:run >> /dev/null 2>&1
```

---

## Queue Setup (optional)

If using database queues:

```bash
php artisan queue:work --sleep=3 --tries=3
```

Or configure a Hostinger cron for queue processing.

---

## Permissions

Deploy script creates required directories. Ensure these are writable:

```
storage/
storage/framework/
storage/logs/
bootstrap/cache/
public/uploads/
```

```bash
chmod -R ug+rwx storage bootstrap/cache public/uploads
```

---

## Troubleshooting

### `public/build/manifest.json missing`

```bash
npm ci && npm run build
# or build locally and push public/build/
```

### `public_html/index.php` wrong paths

Re-run deploy — index.php is regenerated automatically from `deployment/hostinger/index.php`.

Verify `.env`:

```env
LARAVEL_RELATIVE_FROM_PUBLIC_HTML=../laravel/elamahealthcare
```

### Uploads not showing

Check files exist in `public_html/uploads/`. Re-deploy syncs uploads separately.

### Database connection failed

Verify `.env` DB credentials match Hostinger MySQL settings (host is usually `localhost`).

### `slug too long` / `product_name too long`

```bash
php artisan migrate --force
```

Migration `2026_06_20_140000_extend_products_slug_and_text_columns` expands columns.

### Validation fails on `public/storage`

This is expected on Hostinger. Run:

```bash
php artisan app:validate-assets
```

Should show Hostinger upload checks — not storage symlink errors.

---

## Recovery Process

1. Check deploy log: `storage/logs/deploy-*.log`
2. Run doctor: `php artisan app:doctor --deploy`
3. Rollback git: `git checkout <commit> && ./deploy.sh`
4. Restore public_html backup from `storage/app/deploy-backups/`

---

## File Reference

| File | Purpose |
|------|---------|
| `deploy.sh` | Root wrapper |
| `deployment/hostinger/deploy.sh` | Full deployment script |
| `deployment/hostinger/index.php` | Bootstrap template |
| `deployment/hostinger/.htaccess` | Apache/LiteSpeed rules |
| `config/deployment.php` | Paths, requirements, writable dirs |
| `app/Services/StorageService.php` | Upload abstraction |
| `app/Services/HostingerService.php` | Hostinger detection |
| `app/Console/Commands/DoctorCommand.php` | `app:doctor` |
| `app/Console/Commands/ValidateAssetsCommand.php` | `app:validate-assets` |
