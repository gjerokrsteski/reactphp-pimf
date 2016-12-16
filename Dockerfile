## Base image
FROM alpine:edge

## Copy modified PHP files into container
COPY . /php-react

## Set working directory
WORKDIR /php-react

# Add PHP 7
RUN apk add --update --no-cache curl bash && \
    apk upgrade -U && \
    apk --update --repository=http://dl-4.alpinelinux.org/alpine/edge/testing add \
    php7 \
    php7-pdo \
    php7-pdo_sqlite \
    php7-curl \
    php7-json \
    php7-fpm \
    php7-phar \
    php7-openssl \
    php7-ctype \
    php7-mbstring \
    php7-phar \
    php7-pcntl \
    php7-intl \
    php7-openssl

# Sweep unused data from the image
RUN apk del tzdata && \
    rm -rf /var/cache/apk/*

# Small fixes du we use alpine:edge
RUN ln -s /etc/php7 /etc/php && \
    ln -s /usr/bin/php7 /usr/bin/php && \
    ln -s /usr/sbin/php-fpm7 /usr/bin/php-fpm && \
    ln -s /usr/lib/php7 /usr/lib/php

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
