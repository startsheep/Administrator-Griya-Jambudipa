#!/bin/sh
set -e

git pull origin Develop

php artisan migrate
php artisan optimize
php artisan config:clear
