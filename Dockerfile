FROM php:8.2-apache

# Cài các extension PHP cần thiết
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip libpng-dev libonig-dev curl \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy toàn bộ source code Laravel vào container
COPY . /var/www/html/

# Cài đặt thư viện Laravel
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Set quyền cho Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Expose port
EXPOSE 80

CMD ["apache2-foreground"]
