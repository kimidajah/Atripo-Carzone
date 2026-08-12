FROM php:8.3-fpm-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-linux-headers --no-cache \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    sqlite-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite gd mbstring zip intl bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Set permissions for storage & bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache public/uploads

EXPOSE 9000

CMD ["php-fpm"]
