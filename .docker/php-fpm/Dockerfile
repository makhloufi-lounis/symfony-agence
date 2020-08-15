FROM php:7.2-fpm

RUN pecl install apcu
RUN pecl install xdebug

RUN apt-get update && apt-get install -y --no-install-recommends \
    apt-utils \
    curl \
    git \
    zip unzip \
    vim \
    locales \
 && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-enable apcu

COPY symfony.ini    /usr/local/etc/php/conf.d/
COPY others.ini     /usr/local/etc/php/conf.d/
COPY memory_limit.ini     /usr/local/etc/php/conf.d/
#COPY symfony.pool.conf /usr/local/etc/php-fpm.d/

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set locales
RUN locale-gen en_US.UTF-8 en_GB.UTF-8 de_DE.UTF-8 es_ES.UTF-8 fr_FR.UTF-8 it_IT.UTF-8 km_KH sv_SE.UTF-8 fi_FI.UTF-8

WORKDIR /app

ADD composer.json .

RUN composer install

RUN  php bin/console cache:clear

