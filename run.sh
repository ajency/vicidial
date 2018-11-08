#!/bin/bash
cron
service php7.2-fpm start
#service nginx start
service supervisor start
supervisorctl reread 
supervisorctl update 
supervisorctl start all 
#php /var/www/html/artisan migrate
php /var/www/html/artisan queue:restart
exec "$@"
