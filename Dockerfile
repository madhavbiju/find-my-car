# ============================================================
# Stage 1 — Build frontend assets + PHP dependencies
#           (needs both Node AND PHP — Wayfinder calls php artisan)
# ============================================================
FROM php:8.4-cli-alpine AS builder

# Install Node + runtime libs (keep libpq/libzip — extensions need them at runtime)
RUN apk add --no-cache nodejs npm libzip libpq libzip-dev libpq-dev \
    && docker-php-ext-install zip pdo pdo_pgsql \
    && apk del libzip-dev libpq-dev

# Install Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Composer dependencies (no-dev, cached layer)
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --ignore-platform-reqs \
    --prefer-dist

# Copy full app and dump optimised autoloader
COPY . .
RUN mkdir -p bootstrap/cache storage/logs storage/framework/cache storage/framework/sessions storage/framework/views \
    && chmod -R 775 bootstrap/cache storage \
    && composer dump-autoload --optimize --no-dev

# npm dependencies (cached layer)
COPY package.json package-lock.json ./
RUN npm ci

# Vite build — php is on PATH so Wayfinder plugin works
RUN npm run build

# ============================================================
# Stage 3 — Final production image
# ============================================================
FROM php:8.4-fpm-alpine

# System dependencies — keep libpq runtime lib for pdo_pgsql
RUN apk add --no-cache \
    nginx \
    supervisor \
    gettext \
    libpq \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apk del libpq-dev

WORKDIR /var/www/html

# Copy app + vendor from builder stage (includes public/build from Vite)
COPY --from=builder /app .

# Nginx and supervisor config
COPY docker/nginx.conf.template /etc/nginx/templates/default.conf.template
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /usr/local/bin/start.sh

RUN chmod +x /usr/local/bin/start.sh

# Storage permissions
RUN mkdir -p storage/logs \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Remove default nginx config
RUN rm -f /etc/nginx/http.d/default.conf

EXPOSE 10000

CMD ["/usr/local/bin/start.sh"]
