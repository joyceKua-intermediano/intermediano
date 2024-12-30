#!/bin/bash

# Read .env file and get APP_ENV variable value
source .env
app_env=$APP_ENV

APP_PORT=80
APP_SSL_PORT=443

# get the PUID and PGID
PUID=$(id -u)
PGID=$(id -g)

# exporting to use in docker-compose.yml (PHP_POOL_NAME)
export APP_ENV=$app_env

if [ "$app_env" == "production" ]; then
    export PUID=$PUID
    export PGID=$PGID
    file="./docker-compose.yml"
    name="intermediano-prod"
    APP_PORT=8300
    APP_SSL_PORT=8343
elif [ "$app_env" == "staging" ]; then
    export PUID=$PUID
    export PGID=$PGID
    file="./docker-compose.yml"
    name="intermediano-staging"
    APP_PORT=8300
    APP_SSL_PORT=8343
else
    export PUID=$PUID
    export PGID=$PGID
    file="./docker-compose.dev.yml"
    name="intermediano-dev"
fi

if [ "$1" == "bash" ] || [ "$1" == "shell" ]; then
    id=$(docker compose -p $name -f $file ps -q web)
    docker exec -it $id /bin/bash
elif [ "$1" == "cli" ]; then
    docker run --rm --name php -v .:/var/www/html -it serversideup/php:8.3-cli bash
elif [ "$1" == "up" ]; then
    export APP_PORT=$APP_PORT
    export APP_SSL_PORT=$APP_SSL_PORT
    docker compose -p $name -f $file $1 $2 $3 $4 $5 $6 $7 $8 $9
else
    docker compose -p $name -f $file $1 $2 $3 $4 $5 $6 $7 $8 $9
fi