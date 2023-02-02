#!/bin/bash

set -e

for file in `ls /docker-entrypoint.d/`; do
  /docker-entrypoint.d/${file}
done

role=${CONTAINER_ROLE:-unknown}

if [ "$role" = "queue" ]; then
    php /var/www/artisan queue:work --tries=3 --timeout=90
elif [ "$role" = "scheduler" ]; then
    while [ true ]
    do
      php /var/www/artisan schedule:run --no-interaction & sleep 60
    done
else
    echo "role: \"$role\" are not supported"
    exit 1
fi
