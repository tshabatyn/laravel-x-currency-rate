#!/usr/bin/env bash

if [ "$(npm -v)" != "9.6.4" ]; then
    sudo npm install -g npm@9.6.4
fi

if [ ! -d /var/www/html/node_modules ]; then
    npm install --dev
fi

npm run dev
