## Base image
FROM alpine:latest

## Copy modified PHP files nto container
COPY . /php-react

## Set working directory
WORKDIR /php-react

## Install PHP
RUN apk apk update && \
    apk upgrade && \
    apk add --update tzdata && \
    apk add git && \
    apk add --update php-common php-json php-curl php-pdo php-pdo_sqlite php-phar php-cli php-openssl php-ctype php-mcrypt && \
    apk del tzdata && \
    rm -rf /var/cache/apk/*

## Install testing framework
RUN curl -s http://getcomposer.org/installer | php
RUN php composer.phar update
RUN php composer.phar install
RUN php composer.phar dump-autoload --optimize

## Create SQLite table
RUN php create-table.php

## Expose port
EXPOSE 666

## Set a volume for SQLite database
VOLUME /php-react/app/Articles/_database

## Run the reactive API server
ENTRYPOINT php run-server.php
