#!/bin/sh

if [ $# -lt 1 ]
then
  docker scout quickview fs://.
  docker scout cves fs://.
  docker run --rm -t -v "${PWD}":/workdir overtrue/phplint:latest ./ --exclude=vendor --no-configuration --no-cache && \
  docker compose -f docker-compose-dev.yml up foxess-mqtt
elif [ "$1" == "composer" ]
then
  docker image rm mhzawadi/dashbaord:dev;
  docker build -t mhzawadi/dashbaord:dev -f ./docker/Dockerfile-dev . && \
  docker run --rm -it -v '/Users/matt/git/dashbaord:/var/www/html' mhzawadi/dashbaord:dev /usr/local/bin/composer update
  docker compose -f docker-compose-dev.yml up -d
elif [ "$1" == "up" ]
then
  docker compose -f docker/docker-compose.yml down;
  docker image rm mhzawadi/dashbaord:dev;
  docker build -t mhzawadi/dashbaord:dev -f ./docker/Dockerfile-dev . && \
  docker compose -f docker/docker-compose.yml up
else
  docker compose -f docker-compose-dev.yml down
fi
