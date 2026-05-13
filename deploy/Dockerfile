# ==========================================
# Stage 1: Build PHP dependencies
# ==========================================
FROM php:8.4-cli-alpine AS php-builder

RUN apk add --no-cache git unzip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# ==========================================
# Stage 2: Build frontend assets
# ==========================================
FROM node:22-alpine AS node-builder

WORKDIR /app

COPY package.json .npmrc ./
RUN npm install

COPY vite.config.js ./
COPY resources/css/ resources/css/
COPY resources/js/ resources/js/
RUN npm run build

# ==========================================
# Stage 3: Runtime
# ==========================================
FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    nginx \
    supervisor \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql \
    && rm -rf /var/cache/apk/*

WORKDIR /app

# Copy PHP vendor from builder
COPY --from=php-builder /app/vendor /app/vendor

# Copy application code
COPY . .

# Copy built frontend assets
COPY --from=node-builder /app/public/build /app/public/build

# Ensure storage directories are writable
RUN chmod -R 775 /app/storage /app/bootstrap/cache \
    && chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Laravel optimization
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Nginx config
COPY deploy/nginx.conf /etc/nginx/http.d/default.conf

# Supervisor config
COPY deploy/supervisor.conf /etc/supervisor.d/app.ini

EXPOSE 80

CMD ["supervisord", "-c", "/etc/supervisord.conf"]
