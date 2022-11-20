#!/bin/sh
set -e

git pull origin develop

php artisan migrate
php artisan optimize
