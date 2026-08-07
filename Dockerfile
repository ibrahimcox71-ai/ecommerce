# Base Image
FROM php:8.2-apache

# Install system dependencies & PHP extensions required for Laravel & SQLite
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libsqlite3-dev \
    sqlite3 \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite gd zip bcmath

# Install Composer directly inside Docker
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache Mod_Rewrite
RUN a2enmod rewrite

# Set Apache Document Root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Copy application files
COPY . .

# Unlimited memory limit for Composer during build
ENV COMPOSER_MEMORY_LIMIT=-1

# Fresh installation of production dependencies inside Docker container
RUN composer install --no-dev --optimize-autoloader --no-scripts --prefer-dist

# Ensure SQLite file exists and permissions are set
RUN mkdir -p /var/www/html/database \
    && touch /var/www/html/database/database.sqlite \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

EXPOSE 80

CMD ["apache2-foreground"]
