Publish assets
php artisan vendor:publish --force &&
php artisan migrate:refresh --seed &&
php artisan db:seed --class=XmovementPollsTableSeeder


composer dump-autoload && php artisan vendor:publish --force && php artisan migrate:refresh --seed