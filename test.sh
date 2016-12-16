#!/usr/bin/env bash

# run tests
docker exec -ti reactphp-pimf-api curl -LsS http://codeception.com/codecept.phar -o /usr/local/bin/codecept
docker exec -ti reactphp-pimf-api chmod a+x /usr/local/bin/codecept
test_ok=$(docker exec -ti reactphp-pimf-api codecept run | grep "OK" | wc -l)

if [[ ${test_ok} -ne "1" ]]; then
    exit 1
fi

echo 0