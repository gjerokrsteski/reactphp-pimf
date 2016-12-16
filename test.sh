#!/usr/bin/env bash

# run tests
docker exec -ti reactphp-pimf-api curl -LsS http://codeception.com/codecept.phar -o /usr/local/bin/codecept
docker exec -ti reactphp-pimf-api chmod a+x /usr/local/bin/codecept
tests_response=$(docker exec -ti reactphp-pimf-api codecept run)
test_ok=$(echo "$tests_response" | grep "OK" | wc -l)

echo "$tests_response"

if [[ ${test_ok} -ne "1" ]]; then
    exit 1
fi

echo 0