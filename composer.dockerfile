FROM composer:2

ENV PHPGROUP=laravel
ENV PHPUSER=laravel

RUN addgroup --system ${PHPGROUP}; exit 0
RUN adduser --system -G ${PHPGROUP} -s /bin/sh -D ${PHPUSER}; exit 0

WORKDIR /var/www/html