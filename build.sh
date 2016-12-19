#!/usr/bin/env bash

# build image
docker stop reactphp-pimf-api
docker rm -f reactphp-pimf-api
docker rmi -f reactphp-pimf-api
docker build -t reactphp-pimf-api .
docker run -d -p 1337:1337 --name=reactphp-pimf-api reactphp-pimf-api
