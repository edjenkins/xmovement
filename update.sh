while true
do 
    composer dump-autoload
    php artisan vendor:publish --force
    sleep 3
    php artisan vendor:publish --force
    sleep 3
done
