FROM node:19.5.0-alpine3.17

ARG ENVIRONMENT=production
ENV NODE_ENV=${ENVIRONMENT}

WORKDIR /var/www/

RUN apk update \
    && apk upgrade \
    && apk add --update --no-cache git nasm gcc g++ libtool make cmake pkgconfig autoconf build-base automake bash gettext \
    zlib zlib-dev libpng libpng-dev libwebp libwebp-dev libjpeg-turbo-dev giflib-dev tiff-dev lcms2-dev openssl \
    && npm install -g npm@9.4.0
#RUN apk del git nasm gcc g++ make cmake pkgconfig autoconf automake build-base zlib-dev libpng-dev libwebp-dev \
#    libjpeg-turbo-dev giflib-dev tiff-dev lcms2-dev \
#    && rm -rf /var/cache/apk/*

CMD ["npm", "run", "dev"]

EXPOSE 5006
