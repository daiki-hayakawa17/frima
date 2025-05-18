FROM php:7.4.9-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update \
  && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
  && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update

RUN apt-get update && apt-get install -y \
  libjpeg-dev libpng-dev libwebp-dev libfreetype6-dev \
  && docker-php-ext-configure gd --with-jpeg --with-freetype --with-webp \
  && docker-php-ext-install gd


WORKDIR /var/www