while true
do 
    composer dump-autoload
    php artisan vendor:publish --force
    sleep 10
    php artisan vendor:publish --force
    sleep 10
done
