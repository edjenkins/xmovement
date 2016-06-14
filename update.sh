while true
do 
#    composer dump-autoload
    php artisan vendor:publish --tag=public --force
    sleep 10
done
