FROM ubuntu:18.04
# Update packages and install composer and PHP dependencies.
MAINTAINER Vilas Bhumare 

RUN apt-get update && \
	  DEBIAN_FRONTEND=noninteractive apt-get install -y \
	  php-pear \
          php7.2-curl \ 
	  php7.2-dev \
          php7.2-gd \
	  php7.2-mbstring \
	  php7.2-zip \
	  php7.2-mysql \
	  php7.2-xml \
          cron \
	  nginx \
	  supervisor \
	  unzip \
	  php7.2-fpm
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get install git -y
ADD . /var/www/html
WORKDIR /var/www/html
RUN touch storage/logs/laravel.log
RUN chmod 777 storage/logs/laravel.log
RUN composer config --global --auth github-oauth.github.com github_token
RUN composer update 
RUN composer install 
RUN chmod -R 777 /var/www/html/storage
RUN echo "* * * * * cd /var/www/html && php /var/www/html/artisan schedule:run >> /dev/null 2>&1" > /etc/cron.d/artisan-schedule-run
# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/artisan-schedule-run
RUN chmod +x /etc/cron.d/artisan-schedule-run
# Apply cron job
RUN crontab /etc/cron.d/artisan-schedule-run
# Create the log file to be able to run tail
RUN touch /var/log/cron.log
RUN mkdir -p /var/log/laravel/
COPY supervisor-worker.conf /etc/supervisor/conf.d/supervisor-worker.conf
# Add Nginx Configuration
RUN rm -f /etc/nginx/sites-enabled/default
RUN rm -f /etc/nginx/nginx.conf
COPY nginx.conf /etc/nginx/nginx.conf
RUN chown -R www-data:www-data /var/www/html
EXPOSE 80

RUN chmod +x /var/www/html/run.sh
ENTRYPOINT ["/var/www/html/run.sh"]
CMD ["nginx", "-g", "daemon off;"]
