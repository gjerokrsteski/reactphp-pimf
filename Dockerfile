FROM ubuntu:16.04

ENV TERM=linux
ENV APP_ENV=prod

COPY . /php-react
WORKDIR /php-react

RUN apt-get update -y \
     && apt-get upgrade -y \
     && apt-get install -y --no-install-recommends wget curl software-properties-common python-software-properties \
     && LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php \
     && apt-get update -y

RUN apt-get install -y php7.2 \
     && apt-get install -y php-pear php7.2-curl php7.2-dev php7.0-json php7.2-mbstring php7.2-zip php7.2-xml php7.2-pdo php7.2-sqlite3 php7.2-intl

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
     && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
     && composer update \
     && composer dump-autoload --optimize \
     && composer install

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN chmod +x create-table.php
RUN php create-table.php

EXPOSE 1337

VOLUME /php-react/app/Articles/_database

RUN chmod +x run-server.php

ENTRYPOINT php run-server.php

