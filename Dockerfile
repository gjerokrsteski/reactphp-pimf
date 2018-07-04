## Base image
FROM ubuntu:16.04

# Fixes some weird terminal issues
ENV TERM=linux
ENV APP_ENV=prod

## Copy modified PHP files into container
COPY . /php-react

## Set working directory
WORKDIR /php-react

# Add PHP 7.0
RUN cat /etc/debian_version \
     && apt-get update -y \
     && apt-get install -y --no-install-recommends wget curl \
     && apt-get update -y \
     && apt-get install -y php7.0 php7.0-curl php7.0-json php7.0-mbstring php7.0-zip php7.0-intl php7.0-dom php7.0-phar php7.0-pdo php7.0-sqlite3 \
     && wget https://composer.github.io/installer.sig -O - -q | tr -d '\n' > installer.sig \
     && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
     && php -r "if (hash_file('SHA384', 'composer-setup.php') === file_get_contents('installer.sig')) { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
     && php composer-setup.php \
     && php -r "unlink('composer-setup.php'); unlink('installer.sig');" \
     && php composer.phar update \
     && php composer.phar require "codeception/codeception:*" \
     && php composer.phar dump-autoload --optimize \
     && php composer.phar install

# Sweep unused data from the image
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

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
