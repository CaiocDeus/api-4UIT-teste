#!/usr/bin/env bash
echo "Running composer"
composer global require hirak/prestissimoAdd commentMore actions
composer install --no-dev --working-dir=/var/www/html

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Droping all tables, views, and types..."
php artisan db:wipe

echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed
