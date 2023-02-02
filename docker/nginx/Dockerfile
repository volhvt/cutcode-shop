FROM nginx:1.23.3-alpine-slim

ARG PUID=1000
ARG PGID=1000

#ARG PHP_UPSTREAM_CONTAINER=php-fpm
#ARG PHP_UPSTREAM_PORT=9000

# Возможно пригодится
#    echo -e "nameserver 77.88.8.8\nnameserver 77.88.8.1" > "/etc/resolv.conf" && \
#    cat "/etc/resolv.conf" && \

RUN set -xe && \
    echo -e "https://mirror.yandex.ru/mirrors/alpine/v3.15/main\nhttps://mirror.yandex.ru/mirrors/alpine/v3.15/community" > "/etc/apk/repositories" && \
    cat "/etc/apk/repositories" && \
    apk update && apk upgrade && \
    apk --update --no-cache add openssl bash htop curl

RUN set -x ; \
    addgroup -g ${PGID} -S www-data ; \
    adduser -u ${PUID} -D -S -G www-data www-data && exit 0 ; exit 1

RUN mkdir -p "/etc/nginx/ssl_tmp/" && \
    openssl dhparam -out "/etc/nginx/ssl_tmp/dhparam.pem" 2048 && \
    # Create 'messages' file used from 'logrotate'
    touch /var/log/messages && \
    # Set upstream conf and remove the default conf
    mkdir -p /etc/nginx/conf.d/ && \
    mkdir -p /var/cache/nginx/client_temp/
    #echo "upstream php-upstream { server ${PHP_UPSTREAM_CONTAINER}:${PHP_UPSTREAM_PORT}; }" > /etc/nginx/conf.d/01-upstream.conf

# Copy config file
COPY nginx.conf /etc/nginx/
COPY docker-entrypoint.d/* /docker-entrypoint.d/

WORKDIR /var/www

EXPOSE 80 443
