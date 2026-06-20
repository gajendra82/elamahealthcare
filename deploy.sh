#!/usr/bin/env bash
#
# Elama Healthcare — Hostinger deployment script
# Run from the Laravel project root (outside public_html).
#
# Optional environment variables:
#   PUBLIC_HTML  Path to web document root (default: ../public_html)
#
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$ROOT"

PUBLIC_HTML="${PUBLIC_HTML:-$ROOT/../public_html}"

echo "==> Deploying Elama Healthcare from $ROOT"

echo "==> git pull"
git pull

echo "==> composer install"
composer install --no-dev --optimize-autoloader

echo "==> migrations"
php artisan migrate --force

echo "==> refresh canonical settings (logo paths, SEO defaults)"
php artisan db:seed --class=SettingSeeder --force

echo "==> clear & rebuild caches"
php artisan optimize:clear
mkdir -p "$ROOT/public/uploads"
if [[ -d "$ROOT/storage/app/public" ]]; then
  cp -a "$ROOT/storage/app/public/." "$ROOT/public/uploads/" 2>/dev/null || true
  echo "    merged legacy storage/app/public into public/uploads"
fi
php artisan optimize

echo "==> validate assets"
php artisan app:validate-assets || true

if [[ -d "$PUBLIC_HTML" ]]; then
  echo "==> syncing public/ -> $PUBLIC_HTML"

  sync_dir() {
    local src="$1"
    local dest="$2"
    if [[ -d "$src" ]]; then
      mkdir -p "$dest"
      # Merge without deleting custom server files in destination
      cp -a "$src/." "$dest/"
      echo "    synced $(basename "$src")"
    fi
  }

  sync_dir "$ROOT/public/build" "$PUBLIC_HTML/build"
  sync_dir "$ROOT/public/images" "$PUBLIC_HTML/images"
  sync_dir "$ROOT/public/uploads" "$PUBLIC_HTML/uploads"
  sync_dir "$ROOT/public/css" "$PUBLIC_HTML/css"
  sync_dir "$ROOT/public/js" "$PUBLIC_HTML/js"
  sync_dir "$ROOT/public/fonts" "$PUBLIC_HTML/fonts"

  for file in favicon.ico apple-touch-icon.png icon-192.png robots.txt .htaccess index.php; do
    if [[ -f "$ROOT/public/$file" ]]; then
      cp -a "$ROOT/public/$file" "$PUBLIC_HTML/$file"
      echo "    synced $file"
    fi
  done
else
  echo "==> PUBLIC_HTML not found at $PUBLIC_HTML — skipping public sync"
  echo "    Set PUBLIC_HTML=/path/to/public_html if your layout differs"
fi

echo "==> Deployment complete"
