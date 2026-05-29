#!/bin/sh
set -e

# Inject the $PORT env var into the nginx config template
PORT="${PORT:-10000}"
export PORT
envsubst '${PORT}' < /etc/nginx/templates/default.conf.template > /etc/nginx/http.d/default.conf

# Bootstrap Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Run migrations
php artisan migrate --force

# Seed if the cars table is empty (safe for re-deploys)
CAR_COUNT=$(php artisan tinker --execute "echo App\Models\Car::count();" 2>/dev/null || echo "0")
if [ "$CAR_COUNT" -eq "0" ]; then
    echo "No cars found — seeding database..."
    php artisan db:seed --force
fi

# Start all processes via supervisor
exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
