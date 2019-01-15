#!/bin/bash
cron
service php7.2-fpm start
#service nginx start
php /var/www/html/artisan config:cache
php /var/www/html/artisan route:cache
php /var/www/html/artisan view:cache
service supervisor start
supervisorctl reread 
supervisorctl update 
supervisorctl start all 
php /var/www/html/artisan migrate --force
php /var/www/html/artisan cdn:push
php /var/www/html/artisan queue:restart
chown -R www-data /var/www/html/
exec "$@"
