#!/usr/bin/env bash

# run tests
docker exec -ti reactphp-pimf-api php composer.phar require "codeception/codeception"
tests_response=$(docker exec -ti reactphp-pimf-api vendor/codeception/codeception/codecept run --colors)
test_ok=$(echo "$tests_response" | grep "OK" | wc -l)

echo "$tests_response"

if [[ ${test_ok} -ne "1" ]]; then
    exit 1
fi

echo 0
