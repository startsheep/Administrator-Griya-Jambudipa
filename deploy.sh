#!/bin/sh
set -e

git pull origin Develop

php artisan migrate
php artisan optimize

cd public
rm -rf build
unzip build.php
