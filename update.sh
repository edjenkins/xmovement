while true
do 
#    composer dump-autoload
    php artisan vendor:publish --force
#    php artisan vendor:publish --tag=public --force
    sleep 5
done
