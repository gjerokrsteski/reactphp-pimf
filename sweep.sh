#!/usr/bin/env bash

docker stop reactphp-pimf-api-container
docker rm -f reactphp-pimf-api-container
docker rmi -f $(docker inspect --format="{{.Id}}" reactphp-pimf-api:latest)
