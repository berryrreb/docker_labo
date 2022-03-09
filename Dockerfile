FROM php:7.4-apache

WORKDIR /var/www/html
COPY php/index.php ./
EXPOSE 80