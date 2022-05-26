#!/usr/bin/env sh

set -e

tag=${1:-latest}

# composer install \
#     --ignore-platform-reqs \
#     --no-interaction \
#     --no-plugins \
#     --no-scripts \
#     --prefer-dist

# npm install && npm run production

docker build -t laravel-x-layers:$tag .
