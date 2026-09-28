#!/bin/bash
set -e

# Make sure storage and bootstrap directories exist
mkdir -p /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/logs \
         /var/www/html/storage/app/public \
         /var/www/html/bootstrap/cache

# Fix permissions
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Generate temporary APP_KEY if missing so app does not crash 500
if [ -z "$APP_KEY" ]; then
    echo "==> WARNING: APP_KEY is empty! Generating a temporary key..."
    export APP_KEY=$(php artisan key:generate --show)
fi

# Run storage symlink
php artisan storage:link || true

# Run database migrations and seeders
echo "==> Running database migrations and seeders..."
php artisan migrate --seed --force || echo "==> Migration warning: check DB credentials or connection"

# Re-ensure permissions after artisan runs as root
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "==> Starting Apache web server..."
exec apache2-foreground
