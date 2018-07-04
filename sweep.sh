#!/usr/bin/env bash

docker stop reactphp-pimf-api:latest
docker rm -f reactphp-pimf-api:latest
image_id=$(docker inspect --format="{{.Id}}" reactphp-pimf-api:latest)
docker rmi -f ${image_id}
