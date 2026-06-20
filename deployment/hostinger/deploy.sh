#!/usr/bin/env bash
#
# Elama Healthcare — Hostinger production deployment
# Run from the Laravel project root via ./deploy.sh or bash deploy.sh
#
# Portable: no process substitution (>/dev/fd) — required on Hostinger shared hosting.
#
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
cd "$ROOT"

PUBLIC_HTML="${PUBLIC_HTML:-$ROOT/../../public_html}"
LARAVEL_RELATIVE="${LARAVEL_RELATIVE_FROM_PUBLIC_HTML:-../laravel/elamahealthcare}"
BACKUP_DIR=""
DEPLOY_LOG="$ROOT/storage/logs/deploy-$(date +%Y%m%d-%H%M%S).log"

mkdir -p "$ROOT/storage/logs"
: > "$DEPLOY_LOG"

log() {
  echo "==> $*" | tee -a "$DEPLOY_LOG"
}

fail() {
  printf 'ERROR: %s\n' "$*" | tee -a "$DEPLOY_LOG" >&2
  exit 1
}

run() {
  "$@" 2>&1 | tee -a "$DEPLOY_LOG"
  return "${PIPESTATUS[0]}"
}

on_error() {
  local exit_code=$?
  echo "DEPLOYMENT FAILED (exit ${exit_code})" | tee -a "$DEPLOY_LOG" >&2

  if [[ -n "$BACKUP_DIR" && -d "$BACKUP_DIR" ]]; then
    echo "Rolling back public_html from backup..." | tee -a "$DEPLOY_LOG" >&2
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
log "Log file: $DEPLOY_LOG"

log "Pull latest code"
run git pull

log "Install PHP dependencies"
run composer install --no-dev --prefer-dist --optimize-autoloader

if command -v npm >/dev/null 2>&1; then
  if [[ ! -d node_modules ]] || [[ package-lock.json -nt node_modules ]]; then
    log "Install Node dependencies (package-lock changed)"
    run npm ci
  else
    log "Node dependencies up to date"
  fi

  log "Build frontend assets"
  run npm run build
else
  log "npm not available — expecting committed public/build assets"
fi

if [[ ! -f "$ROOT/public/build/manifest.json" ]]; then
  fail "public/build/manifest.json missing after build"
fi

log "Clear caches"
run php artisan optimize:clear

log "Run migrations"
run php artisan migrate --force

log "Refresh canonical settings, banners, categories, products, and leadership"
run php artisan db:seed --class=SettingSeeder --force
run php artisan db:seed --class=CsrGallerySeeder --force
run php artisan db:seed --class=BannerSeeder --force
run php artisan db:seed --class=CategorySeeder --force
run php artisan db:seed --class=ProductSeeder --force
run php artisan db:seed --class=LeadershipSeeder --force

log "Ensure upload directories"
mkdir -p "$ROOT/public/uploads"
if [[ -d "$ROOT/storage/app/public" ]]; then
  cp -a "$ROOT/storage/app/public/." "$ROOT/public/uploads/" 2>/dev/null || true
fi

log "Cache configuration"
run php artisan config:cache
run php artisan route:cache
run php artisan view:cache

log "Validate assets"
run php artisan app:validate-assets

if [[ ! -d "$PUBLIC_HTML" ]]; then
  fail "public_html directory not found at $PUBLIC_HTML"
fi

log "Backup public_html before sync"
BACKUP_DIR="$ROOT/storage/app/deploy-backups/$(date +%Y%m%d-%H%M%S)"
mkdir -p "$BACKUP_DIR"
run rsync -a "$PUBLIC_HTML/" "$BACKUP_DIR/"

log "Sync public/ to public_html (preserving uploads/)"
run rsync -av --delete --exclude 'uploads/' "$ROOT/public/" "$PUBLIC_HTML/"

log "Install Hostinger bootstrap index.php"
sed "s|{{LARAVEL_RELATIVE}}|${LARAVEL_RELATIVE}|g" \
  "$ROOT/deployment/hostinger/index.php" > "$PUBLIC_HTML/index.php"

log "Install Hostinger .htaccess"
cp "$ROOT/deployment/hostinger/.htaccess" "$PUBLIC_HTML/.htaccess"

log "Ensure public_html/uploads exists"
mkdir -p "$PUBLIC_HTML/uploads"
if [[ -d "$ROOT/public/uploads" ]]; then
  run rsync -av "$ROOT/public/uploads/" "$PUBLIC_HTML/uploads/"
fi

log "Post-deployment validation"
run php artisan app:doctor --deploy

log "Deployment complete"
echo "Log saved to $DEPLOY_LOG" | tee -a "$DEPLOY_LOG"
