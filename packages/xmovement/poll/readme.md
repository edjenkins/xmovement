Publish assets
php artisan vendor:publish --force &&
php artisan migrate:refresh --seed &&
php artisan db:seed --class=XmovementPollsTableSeeder


composer dump-autoload && php artisan vendor:publish --force && php artisan migrate:refresh --seed && php artisan db:seed --class=XmovementPollsTableSeederYou are running composer with xdebug enabled. This has a major impact on runtime performance. See https://getcomposer.org/xdebug