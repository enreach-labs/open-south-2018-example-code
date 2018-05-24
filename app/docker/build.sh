#!/bin/sh
set -e

export REGISTRY=$1
export VERSION=$2

docker build -t example-app:scratch .
docker build -t $REGISTRY/app-example:$VERSION -f ./Dockerfile.build ../