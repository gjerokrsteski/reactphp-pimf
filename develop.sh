#!/usr/bin/env bash

docker build -t reactphp-pimf-api .
docker run -d -p 1337:1337 reactphp-pimf-api
