php -v
composer dump-autoload
php artisan storage:link
mkdir -p ../storage/app/public/photos
mkdir -p ../storage/app/public/covers
cp -R ./.config/covers ../storage/app/public/covers
