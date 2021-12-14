FROM nginx:stable-alpine

ENV NGINXUSER=laravel
ENV NGINXGROUP=laravel

RUN mkdir -p /var/www/html/public

RUN sed -i "s/user www-data/user ${NGINXUSER}/g" /etc/nginx/nginx.conf

ADD nginx/default.conf /etc/nginx/conf.d/

RUN addgroup --system ${NGINXGROUP}; exit 0
RUN adduser --system -G ${NGINXGROUP} -s /bin/sh -D ${NGINXUSER}; exit 0