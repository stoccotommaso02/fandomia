FROM php:7.4-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN docker-php-ext-enable mysqli

RUN a2enmod rewrite

WORKDIR /var/www/html
