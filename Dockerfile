# Base image
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    curl \
    nginx

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Copy Nginx config
COPY nginx.conf /etc/nginx/nginx.conf

# --- NEW: Copy startup script and make it executable ---
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Expose port (this is mainly for documentation, the Nginx config will bind to the actual port)
# EXPOSE 80 # You can keep this or remove it, it doesn't strictly affect runtime on Render.

# --- MODIFIED: Use the startup script as the main command ---
CMD ["/usr/local/bin/start.sh"]
