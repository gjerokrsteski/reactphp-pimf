#!/usr/bin/env bash

# build image
docker build -t reactphp-pimf-api .
docker run -d -p 1337:1337 --name=reactphp-pimf-api reactphp-pimf-api
