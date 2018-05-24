#!/bin/sh
set -e
export REGISTRY="registry.partnersquad.voiceworks.com"
export VERSION=$1
docker push $REGISTRY/kt-dino-blog:$VERSION