#!/bin/bash


set -e

echo "${NGINX_PHP_UPSTREAM}\n";

if [ ! -f /etc/nginx/ssl/default.crt ]; then
    openssl genrsa -out "/etc/nginx/ssl/default.key" 2048
    openssl req -new -key "/etc/nginx/ssl/default.key" -out "/etc/nginx/ssl/default.csr" -subj "/C=RU/ST=NSO/L=Novosibirsk/O=CUTCODE-SHOP/OU=Service Desk/CN=CUTCODE-SHOP/emailAddress=service-desk@shop.cutcode.ru"
    openssl x509 -req -days 365 -in "/etc/nginx/ssl/default.csr" -signkey "/etc/nginx/ssl/default.key" -out "/etc/nginx/ssl/default.crt"
fi

#if [ ! -f /etc/nginx/ssl/current.key ]; then
#    openssl rand 80 > "/etc/nginx/ssl/current.key"
#    openssl genrsa -out "/etc/nginx/ssl/current.key" 2048
#    cp "/etc/nginx/ssl/current.key" "/etc/nginx/ssl/prev.key"
#    cp "/etc/nginx/ssl/current.key" "/etc/nginx/ssl/prevprev.key"
#fi
# TODO - on cron generate current.key once in 28 hours and update prev.key and prevprev.key
#
#

# Start crond in background
#crond -l 2 -b
