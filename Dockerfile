FROM php:5.6-apache

RUN apt-get update && \
    apt-get install -y --no-install-recommends git zip zlib1g-dev

RUN docker-php-ext-install pdo pdo_mysql zip
COPY php.ini /usr/local/etc/php/

WORKDIR /tmp
RUN curl --silent --show-error https://getcomposer.org/installer | php
RUN mv -f composer.phar /usr/local/bin/composer

ENV APP /var/www/html
RUN mkdir -p $APP
WORKDIR $APP

COPY . $APP
RUN mkdir -p $APP/var/cache $APP/var/logs
RUN rm -rf $APP/var/cache/* $APP/var/logs/*
RUN chmod -R 777 $APP/var/cache $APP/var/logs

RUN COMPOSER_ALLOW_SUPERUSER=1 php /usr/local/bin/composer -o install

ENV APACHE_DOCUMENT_ROOT $APP/web
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
