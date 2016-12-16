#!/usr/bin/env bash

# run tests
docker exec -ti reactphp-pimf-api curl -LsS http://codeception.com/codecept.phar -o /usr/local/bin/codecept
docker exec -ti reactphp-pimf-api chmod a+x /usr/local/bin/codecept
docker exec -ti reactphp-pimf-api codecept run --colors
