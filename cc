php app/console --env=prod cache:clear
chown -R www-data app/cache
php app/console assets:install --env=prod
php app/console assetic:dump --env=prod

