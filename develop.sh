#!/usr/bin/env bash

# build image
docker build -t reactphp-pimf-api .
docker run -d -p 1337:1337 --name=reactphp-pimf-api reactphp-pimf-api

# run test
docker exec -ti reactphp-pimf-api curl -LsS http://codeception.com/codecept.phar -o /usr/local/bin/codecept
docker exec -ti reactphp-pimf-api chmod a+x /usr/local/bin/codecept
docker exec -ti reactphp-pimf-api codecept run --colors
