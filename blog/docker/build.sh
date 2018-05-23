#!/bin/sh
set -e

export REGISTRY="registry.partnersquad.voiceworks.com"
export VERSION=$1
export VIRTUALHOST="blog.partnersquad.voiceworks.com"
export PORT="80"
docker build -t kt-dino-blog:scratch ./docker
docker build --build-arg VIRTUALHOST=$VIRTUALHOST --build-arg PORT=$PORT -t $REGISTRY/kt-dino-blog:$VERSION -f ./docker/Dockerfile.build .