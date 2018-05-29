#!/bin/sh
set -e

export REGISTRY=$1
export VERSION=$2

docker build -t example-app:scratch ./app/docker
docker build -t $REGISTRY/termica:$VERSION -f ./app/docker/Dockerfile.build ./app
docker login --username=summalabs --password=topsecret
docker push $REGISTRY/termica:$VERSION