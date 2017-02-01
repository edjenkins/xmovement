rm -r temp
mkdir temp

cd temp

git clone -b c4d --single-branch ssh://git@openlab.ncl.ac.uk:17150/edjenkins/xmovement-deployments.git xmovement-deployment
git clone -b c4d --single-branch ssh://git@openlab.ncl.ac.uk:17150/edjenkins/xmovement-translations.git xmovement-translation

cd ../

cp -R ./temp/xmovement-deployment/* ./packages/deployment
cp -R ./temp/xmovement-translation/* ./resources/lang

rm -R ./temp
