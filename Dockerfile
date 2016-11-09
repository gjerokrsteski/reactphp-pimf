## Base image
FROM alpine:3.3

## Copy modified PHP files into container
COPY . /php-react

## Set working directory
WORKDIR /php-react

# get packages
RUN apk update && \
    apk upgrade && \
    apk add tzdata && \
    apk add php-fpm && \
    apk add php-common && \
    apk add php-bcmath && \
    apk add php-ctype && \
    apk add php-curl && \
    apk add php-dom && \
    apk add php-json && \
    apk add php-openssl && \
    apk add php-pdo && \
    apk add php-pdo_sqlite && \
    apk add php-cli && \
    apk add php-mcrypt && \
    apk add php-phar && \
    apk add php-pcntl && \
    apk add php-intl && \
    apk add openssh && \
    apk add openssl && \
    apk add supervisor && \
    apk add git && \
    apk del tzdata && \
    rm -rf /var/cache/apk/*

## Install ReactPHP and PIMF micro frameworks
RUN curl -s http://getcomposer.org/installer | php
RUN php composer.phar update
RUN php composer.phar install
RUN php composer.phar dump-autoload --optimize

## Create SQLite table
RUN chmod +x create-table.php
RUN php create-table.php

## Expose port
EXPOSE 1337

## Set a volume for SQLite database
VOLUME /php-react/app/Articles/_database

RUN chmod +x run-server.php

## Run the reactive API server
ENTRYPOINT php run-server.php
