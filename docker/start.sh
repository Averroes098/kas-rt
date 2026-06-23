#!/bin/sh
set -e

echo "=== KAS RT — Railway Startup ==="

# Run database migrations
echo "[1/3] Running database migrations..."
php artisan migrate --force

# Optimize Laravel for production
echo "[2/3] Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start supervisor (manages nginx + php-fpm)
echo "[3/3] Starting Nginx + PHP-FPM via Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
