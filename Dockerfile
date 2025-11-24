FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package*.json ./

RUN npm ci

COPY . .

RUN npm run build

FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    git \
    zip \
    unzip \
    curl \
    libpng \
    libjpeg-turbo \
    freetype \
    && apk add --no-cache --virtual .build-deps \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql \
    && apk del --no-cache .build-deps

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer*.json ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

COPY . .
COPY --from=node-builder /app/public/build ./public/build

RUN composer run-script post-autoload-dump

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

USER www-data

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
