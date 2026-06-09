#!/bin/sh
set -e

cd /var/www/html

# ── Guard: required env vars ──────────────────────────────────────────────────
if [ -z "$APP_KEY" ]; then
    echo "ERROR: APP_KEY is not set. Generate one with: php artisan key:generate --show"
    exit 1
fi

if [ -z "$OPENAI_API_KEY" ]; then
    echo "ERROR: OPENAI_API_KEY is not set."
    exit 1
fi

if [ -z "$UPSTASH_REDIS_URL" ]; then
    echo "ERROR: UPSTASH_REDIS_URL is not set. Add it in the Render dashboard."
    exit 1
fi

# ── SQLite: ensure the DB file exists on the persistent disk ──────────────────
# /var/data is mounted as a Render persistent disk (defined in render.yaml).
# On first deploy the file won't exist yet — touch creates it safely.
DB_FILE="${DB_DATABASE:-/var/data/database.sqlite}"
if [ ! -f "$DB_FILE" ]; then
    echo "Creating SQLite database at $DB_FILE ..."
    mkdir -p "$(dirname "$DB_FILE")"
    touch "$DB_FILE"
fi
chmod 664 "$DB_FILE"

# ── Laravel bootstrap ─────────────────────────────────────────────────────────
php artisan storage:link --force 2>/dev/null || true
php artisan migrate --force --no-interaction
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "PlacePulse AI starting on port ${PORT:-10000}..."
exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
