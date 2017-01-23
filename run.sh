#!/bin/bash

# copy env vars into www pool
echo -e "\n; Automatically added by /run.sh" >> /etc/php5/fpm/pool.d/www.conf
env | sed -E 's/^([^=]+)=/env[\1] = /' >> /etc/php5/fpm/pool.d/www.conf

# service mysql start
# service nginx start
# service php5-fpm start


echo "$USER"

npm install bower -g
npm install gulp -g
composer install
npm install
bower install --allow-root
gulp

##chown www-data:www-data -R resources/lang
##chmod -R 775 resources/lang

#mysql -u root --password < create-db.sql
php artisan migrate:install
php artisan migrate --seed

#tail -F /var/log/nginx/access.log /var/log/nginx/error.log
