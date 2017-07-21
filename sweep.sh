#!/usr/bin/env bash

docker stop reactphp-pimf-api
docker rm -f reactphp-pimf-api
docker rmi -f reactphp-pimf-api
