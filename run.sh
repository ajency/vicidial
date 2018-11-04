#!/bin/bash
cron
service nginx start
service supervisor start
supervisorctl reread 
supervisorctl update 
supervisorctl start all 
php /var/www/html/artisan queue:restart
