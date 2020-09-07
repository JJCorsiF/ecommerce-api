FROM gitpod/workspace-mysql

USER gitpod

# FROM php:7.3-apache

# RUN apt-get update -y && apt-get install -y openssl zip unzip git
# RUN docker-php-ext-install pdo pdo_mysql mysqli
# RUN a2enmod rewrite
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# WORKDIR /app
# COPY . /app

# RUN composer install
# RUN php artisan migrate

#CMD php artisan migrate --seed && php artisan serve
#EXPOSE 8000
