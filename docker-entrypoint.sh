#!/bin/bash
set -e

# Render-এর দেওয়া dynamic $PORT অনুযায়ী Apache কনফিগার করা
if [ -n "$PORT" ]; then
    sed -i "s/80/$PORT/g" /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf
fi

# SQLite ফাইল তৈরি ও পারমিশন নিশ্চিত করা
mkdir -p /var/www/html/database
touch /var/www/html/database/database.sqlite
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# ডাটাবেজ মাইগ্রেশন রান করা
php artisan migrate --force

# Apache সার্ভার চালু করা
exec "$@"