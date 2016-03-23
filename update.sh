while true
do 
    composer dump-autoload
    php artisan vendor:publish --force
    sleep 4
done
