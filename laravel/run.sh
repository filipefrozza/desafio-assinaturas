#!/bin/sh

sleep 60
php artisan migrate
php artisan passport:install
php artisan permission:create-permission-routes
php artisan db:seed --class=UsersSeeder
php artisan serve --host=0.0.0.0 --port=8000