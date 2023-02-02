#!/bin/sh
set -e

for file in `ls /docker-entrypoint.d/`; do
  /docker-entrypoint.d/${file}
done

php-fpm
