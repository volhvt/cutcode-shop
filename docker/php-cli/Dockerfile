FROM php:8.2.1-cli-alpine3.17

ARG ENVIRONMENT=production
ENV ENVIRONMENT=${ENVIRONMENT}

# Возможно пригодится
#    echo -e "nameserver 77.88.8.8\nnameserver 77.88.8.1" > "/etc/resolv.conf" && \
#    cat "/etc/resolv.conf" && \

RUN set -xe && \
    echo -e "https://mirror.yandex.ru/mirrors/alpine/v3.17/main\nhttps://mirror.yandex.ru/mirrors/alpine/v3.17/community" > "/etc/apk/repositories" && \
    cat "/etc/apk/repositories" && \
    apk update && apk upgrade && \
    pecl channel-update pear.php.net && \
    apk add --no-cache bash htop git iputils wget curl \
     linux-headers make cmake autoconf g++ gcc build-base libintl libuuid icu-data-full icu-dev musl-dev gettext-dev \
      openssl-dev openssl openssh openssh-client libssh2-dev libssh2 \
      libmcrypt-dev libmcrypt libxml2-dev libxml2 libxslt-dev libxslt \
      libpng-dev libpng freetype-dev libjpeg-turbo-dev libjpeg-turbo libltdl libwebp-dev libwebp libxpm-dev libxpm \
      jpegoptim optipng pngquant gifsicle \
      imagemagick-dev imagemagick \
      zlib-dev libzip-dev zip unzip zlib libzip \
      bzip2-dev bzip2 \
      ## libldap ldb-dev libldap openldap-dev\
      imap-dev krb5-dev \
      ## mariadb-client \
      libpq postgresql-dev \
      yaml-dev \
      oniguruma-dev \
      rabbitmq-c-dev rabbitmq-c \
      libmemcached-dev && \
      ## php exts
      docker-php-source extract

    # Install bz2
#RUN docker-php-ext-install bz2
    # Install the sockets extension
RUN docker-php-ext-install sockets
    # Install the amqp extension
    # RUN mkdir /usr/src/php/ext/amqp && curl -L https://github.com/php-amqp/php-amqp/archive/master.tar.gz | tar -xzC "/usr/src/php/ext/amqp" --strip-components=1 && docker-php-ext-install amqp && \
#RUN pecl install -o -f amqp-1.11.0
RUN pecl install -o -f http://pecl.php.net/get/amqp-1.11.0.tgz
RUN docker-php-ext-enable amqp
    # Install the mbstring extension
RUN docker-php-ext-configure mbstring --enable-mbstring && docker-php-ext-install mbstring
    # Install the bcmath extension
RUN docker-php-ext-configure bcmath --enable-bcmath && docker-php-ext-install bcmath
    # Install the zip extension
RUN docker-php-ext-configure zip && docker-php-ext-install zip
    #php -m | grep -q 'zip' && \
    # Install the gd extension
#RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && docker-php-ext-install gd
    #php -m | grep -q 'gd' &&\
    # Install the ssh2 extension
#RUN    mkdir -p /usr/src/php/ext/ssh2 && curl -fsSL https://github.com/php/pecl-networking-ssh2/archive/master.tar.gz | tar xvz -C "/usr/src/php/ext/ssh2" --strip 1 && docker-php-ext-install ssh2
#RUN pecl install -o -f ssh2-1.3.1
RUN pecl install -o -f http://pecl.php.net/get/ssh2-1.3.1.tgz
RUN docker-php-ext-enable ssh2
    # Install the xsl extension
RUN docker-php-ext-install xsl
    # Install Php Redis Extension
#RUN pecl install -o -f redis-5.3.7
RUN pecl install -o -f http://pecl.php.net/get/redis-5.3.7.tgz
RUN docker-php-ext-enable redis
    # Install the mongodb extension
    #pecl install mongodb; docker-php-ext-enable mongodb && \
    # opcache
RUN docker-php-ext-install opcache && docker-php-ext-enable opcache
    # intl intl and requirements Human Language and Character Encoding Support
    #docker-php-ext-configure intl && docker-php-ext-install intl && \
    # imagick
#RUN    mkdir -p /usr/src/php/ext/imagick && curl -fsSL https://github.com/Imagick/imagick/archive/06116aa24b76edaf6b1693198f79e6c295eda8a9.tar.gz | tar xvz -C "/usr/src/php/ext/imagick" --strip 1 && docker-php-ext-install imagick
#RUN pecl install -o -f imagick-3.7.0
RUN pecl install -o -f http://pecl.php.net/get/imagick-3.7.0.tgz
RUN docker-php-ext-enable imagick
    # imap
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl && docker-php-ext-install imap
    # calendar
RUN docker-php-ext-configure calendar && docker-php-ext-install calendar
    # apcu
#RUN    mkdir -p /usr/src/php/ext/apcu && curl -fsSL https://pecl.php.net/get/apcu | tar xvz -C "/usr/src/php/ext/apcu" --strip 1 && docker-php-ext-install apcu
#RUN pecl install apcu-5.1.21
RUN pecl install -o -f http://pecl.php.net/get/apcu-5.1.21.tgz
RUN docker-php-ext-enable apcu
    # yaml
#RUN pecl install yaml-2.2.2
RUN pecl install -o -f http://pecl.php.net/get/yaml-2.2.2.tgz
RUN docker-php-ext-enable yaml
    # Enable Exif PHP extentions requirements
RUN docker-php-ext-install exif
    # MySql
    # docker-php-ext-configure pdo_mysql --with-pdo-mysql && docker-php-ext-install pdo_mysql && \
    # PgSql
RUN docker-php-ext-configure pdo_pgsql --with-pdo-pgsql && docker-php-ext-install pdo pgsql pdo_pgsql
    # Memcached
#RUN pecl install memcached-3.1.5
RUN pecl install -o -f http://pecl.php.net/get/memcached-3.1.5.tgz
RUN docker-php-ext-enable memcached
RUN docker-php-ext-install pcntl
RUN docker-php-source delete

#RUN set -xe; \
#    docker-php-source extract && \
#    # ldap
#    docker-php-ext-configure ldap; docker-php-ext-install ldap && \
#    docker-php-source delete
#
# libfaketime
ARG INSTALL_FAKETIME=false
RUN if [ ${INSTALL_FAKETIME} = true ]; then \
    apk add --no-cache libfaketime \
;fi

# xDebug
# Copy xdebug configuration for remote debugging
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; then \
  pecl install xdebug; \
  docker-php-ext-enable xdebug && \
  sed -i "s/xdebug.remote_autostart=0/xdebug.remote_autostart=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
  sed -i "s/xdebug.remote_enable=0/xdebug.remote_enable=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
  sed -i "s/xdebug.cli_color=0/xdebug.cli_color=1/" /usr/local/etc/php/conf.d/xdebug.ini \
;fi

# Phpdbg
ARG INSTALL_PHPDBG=false
RUN if [ ${INSTALL_PHPDBG} = true ]; then \
    # Load the xdebug extension only with phpunit commands
    apk add --no-cache php-phpdbg \
;fi

# Xhprof
ARG INSTALL_XHPROF=false
RUN if [ ${INSTALL_XHPROF} = true ]; then \
    # Install the php xhprof extension
    curl -L -o /tmp/xhprof.tar.gz "https://github.com/tideways/php-xhprof-extension/archive/v4.1.6.tar.gz"; \
    mkdir -p xhprof && \
    tar -C xhprof -zxvf /tmp/xhprof.tar.gz --strip 1 && \
    ( \
        cd xhprof && \
        phpize && \
        ./configure && \
        make && \
        make install \
    ) && \
    rm -r xhprof && \
    rm /tmp/xhprof.tar.gz \
;fi

COPY ./xhprof.ini /usr/local/etc/php/conf.d

# Install additional locales:
ARG INSTALL_ADDITIONAL_LOCALES=false
ARG LOCALES_ADDITIONAL
ENV MUSL_LOCPATH /usr/share/i18n/locales/musl
RUN if [ ${INSTALL_ADDITIONAL_LOCALES} = true ]; then \
    wget https://gitlab.com/rilian-la-te/musl-locales/-/archive/master/musl-locales-master.zip \
    && unzip musl-locales-master.zip \
      && cd musl-locales-master \
      && cmake -DLOCALE_PROFILE=OFF -D CMAKE_INSTALL_PREFIX:PATH=/usr . && make && make install \
      && cd .. && rm -r musl-locales-master \
;fi

# Check PHP version:
RUN set -xe; php -v | head -n 1 | grep -q "PHP 8.2."

# Copy sendmail configuration
#COPY ./ssmtp/ssmtp.conf /etc/ssmtp/ssmtp.conf
# Copy opcache configration
COPY ./opcache.ini /usr/local/etc/php/conf.d/opcache.ini
## Copy php config
COPY ./php.ini /usr/local/etc/php/php.ini

USER root
# SET TIMEZONE
ARG TIMEZONE=UTC
ENV TIMEZONE ${TIMEZONE}
RUN ln -snf "/usr/share/zoneinfo/${TIMEZONE}" /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone \
    && sed -i "s/date.timezone=UTC/date.timezone=${TIMEZONE}/" "/usr/local/etc/php/php.ini"

# Clean up
RUN apk del make cmake autoconf g++ gcc build-base linux-headers \
    icu-dev musl-dev gettext-dev openssl-dev libssh2-dev libmcrypt-dev libxml2-dev libxslt-dev \
    libpng-dev freetype-dev libjpeg-turbo-dev libwebp-dev libxpm-dev imagemagick-dev zlib-dev libzip-dev bzip2-dev \
    imap-dev krb5-dev postgresql-dev yaml-dev oniguruma-dev rabbitmq-c-dev libmemcached-dev && \
    rm -rf /var/cache/apk/* && \
    rm -rf /tmp/pear && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Configure non-root user.
ARG PUID=1001
ENV PUID ${PUID}
ARG PGID=1001
ENV PGID ${PGID}

RUN deluser www-data ; \
    delgroup www-data ; \
    adduser -D -H -u ${PUID} -s /bin/bash www-data -G www-data ;\
    addgroup -g ${PGID} -S www-data ; \
    adduser -u ${PUID} -D -S -G www-data www-data && exit 0 ; exit 1

RUN if [ ${INSTALL_FAKETIME} = true ]; then \
    echo "/usr/lib/x86_64-linux-gnu/faketime/libfaketime.so.1" > /etc/ld.so.preload \
;fi

# Configure locale.
ARG LOCALE=POSIX
ENV LC_ALL ${LOCALE}

#ARG SSH_PRIVATE_KEY=""
#RUN mkdir -p -m 0600 ~/.ssh && ssh-keyscan mygenetics.gitlab.yandexcloud.net >> ~/.ssh/known_hosts && \
#    echo "${SSH_PRIVATE_KEY}" > ~/.ssh/id_rsa && chmod 600  ~/.ssh/id_rsa

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer


ADD ./startup.sh /opt/startup.sh

RUN sed -i 's/\r//g' /opt/startup.sh

WORKDIR /var/www/

CMD ["/bin/bash", "/opt/startup.sh"]
