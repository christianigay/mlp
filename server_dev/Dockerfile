FROM php:7.3.19-fpm-stretch

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update && apt-get install -y zlib1g-dev libicu-dev g++
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

RUN apt-get update && \
    apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install gd

RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip
RUN apt-get install poppler-utils -y
