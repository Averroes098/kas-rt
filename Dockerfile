# ============================================================
# Dockerfile untuk Laravel 12 — Railway / Render / VPS
# Stack: PHP 8.2 + Nginx + Node.js 20 (untuk Vite build)
# ============================================================

# ─── Stage 1: Build Vite/Node.js assets ─────────────────────
FROM node:20-alpine AS node-builder

WORKDIR /app

# Copy package files first (layer caching)
COPY package.json package-lock.json ./
RUN npm ci --prefer-offline

# Copy source dan build
COPY resources/ ./resources/
COPY vite.config.js ./
COPY tailwind.config.js ./
COPY postcss.config.js ./
COPY public/ ./public/

RUN npm run build


# ─── Stage 2: PHP application ───────────────────────────────
FROM php:8.2-fpm-alpine AS php-app

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    bash \
    git \
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

# Copy composer files first (layer caching)
COPY composer.json composer.lock ./

# Install PHP dependencies (no dev, no scripts yet)
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --optimize-autoloader

# Copy seluruh project
COPY . .

# Copy built assets dari stage 1
COPY --from=node-builder /app/public/build ./public/build

# Generate autoloader production & run post-install scripts
RUN composer dump-autoload --optimize

# Create storage symlink & set permissions
RUN php artisan storage:link || true

RUN mkdir -p \
    storage/app/public \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# ─── Nginx configuration ─────────────────────────────────────
RUN mkdir -p /run/nginx

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/http.d/default.conf

# ─── Supervisor configuration ────────────────────────────────
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ─── PHP OPcache configuration ───────────────────────────────
COPY docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Health check
HEALTHCHECK --interval=30s --timeout=5s --retries=3 \
    CMD curl -f http://localhost/up || exit 1

EXPOSE 80

# Start via supervisor (manages nginx + php-fpm)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
