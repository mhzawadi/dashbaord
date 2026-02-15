#!/bin/sh

docker compose -f docker/docker-compose.yml down;
docker image rm mhzawadi/dashbaord:dev;
docker build -t mhzawadi/dashbaord:dev -f ./docker/Dockerfile-dev . && \
docker run -it mhzawadi/dashbaord:dev /usr/local/bin/composer upgrade
