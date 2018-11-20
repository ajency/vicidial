
# KSS PRODUCT SITE

## Install the underlying software

### Install PHP 7.2 (dev and prod)
`sudo apt-get install software-properties-common`

`sudo add-apt-repository ppa:ondrej/php`

`sudo apt-get update`

`sudo apt-get install php7.2`

`sudo apt-get install php-pear php7.2-curl php7.2-dev php7.2-gd php7.2-mbstring php7.2-zip php7.2-mysql php7.2-xml php7.2-xmlrpc`

### Install NPM
`sudo apt-get install npm`

### Install MySQL 8 (only dev)
`cd /tmp/ && wget https://dev.mysql.com/get/mysql-apt-config_0.8.10-1_all.deb`

`sudo dpkg -i mysql-apt-config_0.8.10-1_all.deb`

`sudo apt update`

`sudo apt install mysql-server mysql-client`

Login into mysql

`mysql -u root -p`

In the MySQL prompt

`create database databasename;`

### Install Elasticsearch 6.4 (only dev)
`wget -qO - https://artifacts.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -`

`sudo apt-get install apt-transport-https`

`echo "deb https://artifacts.elastic.co/packages/6.x/apt stable main" | sudo tee -a` `/etc/apt/sources.list.d/elastic-6.x.list`

`sudo apt-get update && sudo apt-get install elasticsearch`

### Install git, supervisor and composer (dev and prod)
`sudo apt-get install git supervisor composer`

#### Setup the github oauth with composer
Head to https://github.com/settings/tokens/new?scopes=repo&description=Composer+on+<Servername>
to retrieve a token. It can be stored manually in  "/home/<username>/.composer/auth.json" for future use.

Alternatively you can also add it by using "composer config --global --auth github-oauth.github.com <token>"

#### Setup supervisor
`mkdir -p /var/log/laravel/`

`cat > /etc/supervisor/conf.d/newsite-worker.conf`

paste this

```
[program:newsite_product_sync]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/newsite/artisan queue:work --queue=update_inventory,process_move,process_product,process_product_images,create_jobs --sleep=3 --tries=3
autostart=true
autorestart=true
user=root
numprocs=1
redirect_stderr=true
stdout_logfile=/var/log/laravel/product_sync.log

[program:newsite_order_sync]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/newsite/artisan queue:work --queue=odoo_order --tries=5
autostart=true
autorestart=true
user=root
numprocs=1
redirect_stderr=true
stdout_logfile=/var/log/laravel/order_sync.log

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

### Setup crontab

Add the following to crontab

`* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`


## Deploy the application code

### Clone the repository
`git clone https://github.com/ajency/KSS.git`

### Install/update composer packages
`composer install`

### Install npm packages
`npm install`

### Build assets
`npm run production`

### Push Assets to CDN
`php artisan cdn:push`

### Deploy the changes to the database if any
`php artisan migrate`

### Restart the queues to pick up the new code changes
`php artisan queue:restart`



## Setup the project. (to be run only on the first deploy manually)

### Copy .env.example to .env and add all the keys to the file

`cp .env.example .env`

### Create an elastic index for products and product moves

`php artisan elastic:create_index products`
`php artisan elastic:create_index product_moves`

### Get all warehouses from odoo
`php artisan odoo:warehouses` 

### Get all locations from odoo
`php artisan odoo:locations` 

### Get all states from odoo
`php artisan odoo:states` 

### create passport keys for API to work
`php artisan passport:client --personal`

### Enter into laravel console
`php artisan tinker`

#### In the tinker console type (to create a user-role of type customer)

`Spatie\Permission\Models\Role::create(['name' => 'customer'])`

