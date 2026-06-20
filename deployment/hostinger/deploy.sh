#!/usr/bin/env bash
#
# Elama Healthcare — Hostinger production deployment
# Run from the Laravel project root via ./deploy.sh
#
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
cd "$ROOT"

PUBLIC_HTML="${PUBLIC_HTML:-$ROOT/../../public_html}"
LARAVEL_RELATIVE="${LARAVEL_RELATIVE_FROM_PUBLIC_HTML:-../laravel/elamahealthcare}"
BACKUP_DIR=""
DEPLOY_LOG="$ROOT/storage/logs/deploy-$(date +%Y%m%d-%H%M%S).log"

mkdir -p "$ROOT/storage/logs"
exec > >(tee -a "$DEPLOY_LOG") 2>&1

log() {
  echo "==> $*"
}

fail() {
  printf 'ERROR: %s\n' "$*" >&2
  exit 1
}

on_error() {
  local exit_code=$?
  echo "DEPLOYMENT FAILED (exit ${exit_code})" >&2

  if [[ -n "$BACKUP_DIR" && -d "$BACKUP_DIR" ]]; then
    echo "Rolling back public_html from backup..." >&2
    rsync -a --delete "$BACKUP_DIR/" "$PUBLIC_HTML/" || true
  fi

  exit "$exit_code"
}

trap on_error ERR

require_cmd() {
  command -v "$1" >/dev/null 2>&1 || fail "Required command not found: $1"
}

require_cmd git
require_cmd composer
require_cmd php
require_cmd rsync

log "Deploying Elama Healthcare from $ROOT"
log "public_html target: $PUBLIC_HTML"

log "Pull latest code"
git pull

log "Install PHP dependencies"
composer install --no-dev --prefer-dist --optimize-autoloader

if command -v npm >/dev/null 2>&1; then
  if [[ ! -d node_modules ]] || [[ package-lock.json -nt node_modules ]]; then
    log "Install Node dependencies (package-lock changed)"
    npm ci
  else
    log "Node dependencies up to date"
  fi

  log "Build frontend assets"
  npm run build
else
  log "npm not available — expecting committed public/build assets"
fi

if [[ ! -f "$ROOT/public/build/manifest.json" ]]; then
  fail "public/build/manifest.json missing after build"
fi

log "Clear caches"
php artisan optimize:clear

log "Run migrations"
php artisan migrate --force

log "Refresh canonical settings"
php artisan db:seed --class=SettingSeeder --force

log "Ensure upload directories"
mkdir -p "$ROOT/public/uploads"
if [[ -d "$ROOT/storage/app/public" ]]; then
  cp -a "$ROOT/storage/app/public/." "$ROOT/public/uploads/" 2>/dev/null || true
fi

log "Cache configuration"
php artisan config:cache
php artisan route:cache
php artisan view:cache

log "Validate assets"
php artisan app:validate-assets

if [[ ! -d "$PUBLIC_HTML" ]]; then
  fail "public_html directory not found at $PUBLIC_HTML"
fi

log "Backup public_html before sync"
BACKUP_DIR="$ROOT/storage/app/deploy-backups/$(date +%Y%m%d-%H%M%S)"
mkdir -p "$BACKUP_DIR"
rsync -a "$PUBLIC_HTML/" "$BACKUP_DIR/"

log "Sync public/ to public_html (preserving uploads/)"
rsync -av --delete \
  --exclude 'uploads/' \
  "$ROOT/public/" "$PUBLIC_HTML/"

log "Install Hostinger bootstrap index.php"
sed "s|{{LARAVEL_RELATIVE}}|${LARAVEL_RELATIVE}|g" \
  "$ROOT/deployment/hostinger/index.php" > "$PUBLIC_HTML/index.php"

log "Install Hostinger .htaccess"
cp "$ROOT/deployment/hostinger/.htaccess" "$PUBLIC_HTML/.htaccess"

log "Ensure public_html/uploads exists"
mkdir -p "$PUBLIC_HTML/uploads"
if [[ -d "$ROOT/public/uploads" ]]; then
  rsync -av "$ROOT/public/uploads/" "$PUBLIC_HTML/uploads/"
fi

log "Post-deployment validation"
php artisan app:doctor --deploy

log "Deployment complete"
echo "Log saved to $DEPLOY_LOG"
