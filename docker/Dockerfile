FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    default-mysql-client \
    libpq-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    locales \
    zip \
    libzip-dev \
    jpegoptim optipng pngquant gifsicle \
    vim \
    tmux \
    unzip \
    git \
    curl \
    libxml2-dev \
    ca-certificates \
    cron \
    supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -sL https://deb.nodesource.com/setup_18.x -o /tmp/nodesource_setup.sh
RUN bash /tmp/nodesource_setup.sh

RUN apt install nodejs

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user
