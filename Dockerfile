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
	  supervisor
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN apt-get install supervisor
RUN apt-get install git -y
ADD . /var/www/html
WORKDIR /var/www/html
#RUN mkdir storage/logs
RUN touch storage/logs/laravel.log
RUN chmod 777 storage/logs/laravel.log
RUN composer install || echo 0 
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
COPY nginx.conf /etc/nginx/sites-available/laravel
RUN ln -s /etc/nginx/sites-available/laravel /etc/nginx/sites-enabled/laravel
RUN chown -R www-data:www-data /var/www/html
EXPOSE 80

RUN chmod +x /var/www/html/run.sh
CMD sh /var/www/html/run.sh
