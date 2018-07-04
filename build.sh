#!/usr/bin/env bash

docker build -t reactphp-pimf-api:latest .
docker run -d -p 1337:1337 --name=reactphp-pimf-api-container reactphp-pimf-api:latest
