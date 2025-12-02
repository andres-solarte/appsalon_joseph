# syntax=docker/dockerfile:1

# ---- Assets build stage (Node + Gulp) ----
FROM node:20-alpine AS assets
WORKDIR /app

# Install JS tooling
COPY package*.json ./
RUN npm ci

# Copy build config and sources
COPY gulpfile.js ./
COPY src ./src

# Build frontend assets into public/build
RUN npm run build


# ---- Composer dependencies stage ----
FROM composer:2 AS vendor
WORKDIR /app

COPY composer.json composer.lock* ./

RUN composer install \
    --no-interaction \
    --prefer-dist \
    --no-progress \
    --optimize-autoloader


# ---- Runtime stage (Apache + PHP) ----
FROM php:8.3-apache

RUN apt-get update && apt-get install -y unzip git

# Install PHP extensions needed by the app
RUN docker-php-ext-install mysqli zip

RUN docker-php-ext-enable mysqli

# Install Composer for running tests and managing dependencies
COPY --from=vendor /usr/bin/composer /usr/bin/composer

# Enable Apache modules and configure DocumentRoot to public/
RUN a2enmod rewrite \
    && sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#g' /etc/apache2/sites-available/000-default.conf \
    && printf "<Directory /var/www/html/public>\n\tAllowOverride All\n</Directory>\n" > /etc/apache2/conf-available/public.conf \
    && a2enconf public

WORKDIR /var/www/html

# Copy application source
COPY . /var/www/html

# Bring in Composer vendor deps and built assets
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

# Expose default Apache port
EXPOSE 80

# Default run command provided by the base image
CMD ["apache2-foreground"]
