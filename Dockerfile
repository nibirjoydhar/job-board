# Use the official PHP image with Apache
FROM php:8.0-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite for clean URLs
RUN a2enmod rewrite

# Copy the application files to the container
COPY ./html /var/www/html/

# Set the working directory
WORKDIR /var/www/html/

# Install dependencies if composer.json exists
RUN if [ -f "composer.json" ]; then composer install; fi

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/

# Expose the port
EXPOSE 80
