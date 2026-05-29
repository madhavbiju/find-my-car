# ============================================================
# Stage 1 — Build frontend assets
# ============================================================
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts

COPY resources/ resources/
COPY public/ public/
COPY vite.config.ts tsconfig.json ./
COPY .npmrc ./

RUN npm run build

# ============================================================
# Stage 2 — Install PHP dependencies (no dev)
# ============================================================
FROM composer:2.8 AS composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --ignore-platform-reqs \
    --prefer-dist

COPY . .
RUN composer dump-autoload --optimize --no-dev

# ============================================================
# Stage 3 — Final production image
# ============================================================
FROM php:8.3-fpm-alpine

# System dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    gettext \
    libpq \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apk del libpq-dev

WORKDIR /var/www/html

# Copy app from stage 2
COPY --from=composer /app .

# Copy built frontend assets from stage 1
COPY --from=frontend /app/public/build public/build/

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
