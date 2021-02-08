FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG gid
ARG uid

# Install system dependencies
RUN apt-get update \
    && apt-get install -y \
        git \
        curl \
        dpkg-dev \
        libpng-dev \
        libjpeg-dev \
        libonig-dev \
        libxml2-dev \
        libpq-dev \
        libzip-dev \
        zip \
        unzip \
        cron

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN docker-php-ext-configure gd \
  --enable-gd \
  --with-jpeg

ADD ./php.ini /usr/local/etc/php/php.ini

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd sockets zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/app

RUN usermod -u $uid www-data && groupmod -g $gid www-data
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]