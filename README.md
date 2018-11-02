# KSS PRODUCT SITE

## Install PHP 7.2
`sudo apt-get install software-properties-common`

`sudo add-apt-repository ppa:ondrej/php`

`sudo apt-get update`

`sudo apt-get install php7.2`

`sudo apt-get install php-pear php7.2-curl php7.2-dev php7.2-gd php7.2-mbstring php7.2-zip php7.2-mysql php7.2-xml php7.2-xmlrpc`

## Install MySQL 8
`cd /tmp/ && wget https://dev.mysql.com/get/mysql-apt-config_0.8.10-1_all.deb`

`sudo dpkg -i mysql-apt-config_0.8.10-1_all.deb`

`sudo apt update`

`sudo apt install mysql-server mysql-client`

## Install Elasticsearch 6.4
`wget -qO - https://artifacts.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -`

`sudo apt-get install apt-transport-https`

`echo "deb https://artifacts.elastic.co/packages/6.x/apt stable main" | sudo tee -a` `/etc/apt/sources.list.d/elastic-6.x.list`

`sudo apt-get update && sudo apt-get install elasticsearch`

## Install Supervisor
`sudo apt-get install supervisor`

## KSS
`git clone https://github.com/ajency/KSS.git`

`cd KSS`

`sudo apt install composer`

`mkdir -p packages/ajency`

`cd packages/ajency`

`git clone  https://github.com/ajency/laravel-file-upload-package.git` 

`git clone https://github.com/ajency/laravel-comm-package.git comm`

`cd ../..`

`php artisan migrate`





`cat > /etc/supervisor/conf.d/newsite-worker.conf`
paste this
```
[program:newsite_product_sync]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/newsite/artisan queue:work --queue=process_product,create_jobs --sleep=3 --tries=3
autostart=true
autorestart=true
user=root
numprocs=1
redirect_stderr=true
stdout_logfile=/var/log/laravel/product_sync.log

[program:newsite_photo_sync]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/newsite/artisan queue:work --queue=process_product_images --tries=3
autostart=true
autorestart=true
user=root
numprocs=1
redirect_stderr=true
stdout_logfile=/var/log/laravel/photo_sync.log

[program:newsite_comm]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/newsite/artisan queue:work --queue=high,default,low --tries=3
autostart=true
autorestart=true
user=root
numprocs=1
redirect_stderr=true
stdout_logfile=/var/log/laravel/comm.log
```



`sudo supervisorctl reread` 

`sudo supervisorctl update` 

`sudo supervisorctl start all`

`php artisan queue:restart`
