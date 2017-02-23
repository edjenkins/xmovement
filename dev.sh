sudo rm -r resources/lang
git clone -b create4dementia ssh://git@openlab.ncl.ac.uk:17150/edjenkins/xmovement-translations.git resources/lang

sudo rm -r packages/deployment
git clone -b create4dementia ssh://git@openlab.ncl.ac.uk:17150/edjenkins/xmovement-deployments.git packages/deployment

php artisan vendor:publish
