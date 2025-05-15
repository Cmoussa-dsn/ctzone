FROM php:8.1-apache as builder

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    curl \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install dependencies without running scripts or autoloader
RUN composer install --no-scripts --no-autoloader --ignore-platform-reqs

# Copy the rest of the application
COPY . .

# Generate optimized autoloader and run scripts
RUN composer dump-autoload --optimize --no-dev
RUN npm install && npm run build

# Generate key and optimize
RUN php artisan package:discover --ansi

# Second stage for a clean production image
FROM php:8.1-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files from builder
COPY --from=builder /app /var/www/html

# Copy environment file and set permissions
RUN cp .env.example .env
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Generate application key
RUN php artisan key:generate

# Configure Apache
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"] 