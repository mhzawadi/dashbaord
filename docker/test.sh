#!/bin/sh

docker-compose down;
docker image rm mhzawadi/dashbaord:dev && \
docker build -t mhzawadi/dashbaord:dev -f ./docker/Dockerfile-dev . && \
docker-compose -f docker/docker-compose.yml up
