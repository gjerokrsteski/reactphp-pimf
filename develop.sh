#!/usr/bin/env bash

docker rm -f $(docker ps -a -q)
docker rmi -f $(docker images -q)
docker build -t reactphp-pimf-api .
docker run -d --name="reactphp-pimf-api" -p 1337:1337 reactphp-pimf-api

docker run -d --name sqlite-data --volumes-from reactphp-pimf-api ubuntu:latest