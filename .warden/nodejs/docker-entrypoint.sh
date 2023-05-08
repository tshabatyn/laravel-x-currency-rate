#!/usr/bin/env bash

if [ "$(command -v yarn)" == "" ]; then
    sudo npm install -g yarn
fi

if [ ! -d /var/www/html/node_modules ]; then
    yarn install --save-exact
fi

yarn dev
