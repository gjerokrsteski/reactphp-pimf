#!/usr/bin/env bash

## Install ReactPHP and PIMF micro frameworks
curl -s http://getcomposer.org/installer | php
php composer.phar update
php composer.phar install
php composer.phar dump-autoload --optimize

## Create SQLite table
chmod +x create-table.php
php create-table.php

chmod +x run-server.php

