composer dump-autoload
php artisan storage:link
mkdir -p ./storage/app/public/covers
mkdir -p ./storage/app/public/photos
cp -R ./.config/covers ./storage/app/public
ls ./storage/app/public/covers -al
