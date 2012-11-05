php app/console --env=prod cache:clear
chown -R www-data app/cache
chown -R www-data app/logs
php app/console assets:install --env=prod
php app/console assetic:dump --env=prod

