FROM dunglas/frankenphp:1.2-php8.3-alpine

WORKDIR /app

# Dépendances PHP pour MySQL et Composer
RUN apk add --no-cache \
        mysql-client \
        mariadb-dev \
        gcc g++ make autoconf libc-dev bash curl \
    && docker-php-ext-install pdo_mysql \
    && curl -sS https://getcomposer.org/installer \
        | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .
