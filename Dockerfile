# ================================================================
# Dockerfile — Kas RT (Laravel 12)
# Stack: PHP 8.2-FPM + Nginx + Supervisor + Node.js 20 (Vite)
# Target: Railway / Render / VPS
# ================================================================

# ─── Stage 1: Build Vite/Node.js assets ─────────────────────────
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci --prefer-offline

COPY resources/ ./resources/
COPY vite.config.js ./
COPY tailwind.config.js ./
COPY postcss.config.js ./
COPY public/ ./public/

RUN npm run build


# ─── Stage 2: PHP production application ────────────────────────
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    bash \
    curl \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    icu-dev

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    opcache

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first for layer caching
COPY composer.json composer.lock ./

# Install PHP dependencies (production only)
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --no-interaction

# Copy application source
COPY . .

# Overwrite public/build with freshly built assets from Stage 1
COPY --from=node-builder /app/public/build ./public/build

# Generate optimized autoloader
RUN composer dump-autoload --optimize --no-dev

# Create required directories and set permissions
RUN mkdir -p \
    storage/app/public \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    /run/nginx \
    /var/log/supervisor

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Make startup script executable
RUN chmod +x /var/www/html/docker/start.sh

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/http.d/default.conf

# Copy Supervisor configuration
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy PHP OPcache configuration
COPY docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

HEALTHCHECK --interval=30s --timeout=10s --retries=5 \
    CMD curl -f http://localhost/up || exit 1

EXPOSE 80

CMD ["/bin/sh", "/var/www/html/docker/start.sh"]
