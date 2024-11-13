FROM php:8.2-fpm

# Установка необходимых пакетов
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Дополнительные настройки, если они требуются...
WORKDIR /var/www/html
