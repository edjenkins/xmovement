while true
do 
    composer dump-autoload
    php artisan vendor:publish --force
    sleep 5
    php artisan vendor:publish --force
    sleep 5
done
