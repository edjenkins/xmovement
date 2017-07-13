#/bin/sh

composer install

php artisan migrate --force
php artisan db:seed --force --class=DynamicConfigSeeder
php artisan db:seed --force --class=DesignModulesTableSeeder

vendor/phpunit/phpunit/phpunit --debug
