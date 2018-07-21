#!/bin/sh

cd `dirname $0`

# Install Compoer Packages
composer install

# Install Node Packages
yarn install

# Build Modernizor
cd ./node_modules/modernizr
npm install
./bin/modernizr -c lib/config-all.json

