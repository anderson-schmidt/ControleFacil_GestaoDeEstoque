# Define a imagem base
FROM php:7.2-apache

# Instala a extensão mysqli e a habilita
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Instala as extensões pdo e pdo_mysql e as habilita
RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable pdo pdo_mysql
