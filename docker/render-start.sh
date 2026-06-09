#!/bin/sh
set -e

cd /var/www/html

if [ -z "$APP_KEY" ]; then
    echo "ERROR: APP_KEY is not set. Generate one with: php artisan key:generate --show"
    exit 1
fi

if [ -z "$OPENAI_API_KEY" ]; then
    echo "ERROR: OPENAI_API_KEY is not set."
    exit 1
fi

php artisan storage:link --force 2>/dev/null || true
php artisan migrate --force --no-interaction
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "PlacePulse AI starting on port ${PORT:-10000}..."
exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
