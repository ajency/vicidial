#PHP Dependencies
FROM composer:1.8 as vendor
MAINTAINER Vilas Bhumare
WORKDIR /app
COPY composer.json composer.lock package.json /app/
RUN set -x \
        && composer config --global --auth github-oauth.github.com github_token \
        && composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-autoloader \
    --no-dev

# Frontend
FROM node:10.15 as frontend
RUN npm install -g gulp
WORKDIR /root/build
COPY resources/assets ./resources/assets
COPY public ./public
COPY package.json package-lock.json gulpfile.js webpack.mix.js ./
RUN npm install
WORKDIR /root/build/
ADD . /root/build/
RUN npm run production
RUN gulp
# Download Base Image from AWS ECR
FROM 923266873336.dkr.ecr.ap-south-1.amazonaws.com/kss-nginx-php7.2:1.1
COPY . /var/www/html
COPY --from=vendor /app/vendor/ /var/www/html/vendor/
WORKDIR /var/www/html
RUN set -x \
        && composer config --global --auth github-oauth.github.com github_token \
        && composer install --no-dev \
        && touch storage/logs/laravel.log \
        && chmod 777 storage/logs/laravel.log \
        && chmod -R 777 /var/www/html/storage

COPY --from=frontend /root/build/public/js/ /var/www/html/public/js/
COPY --from=frontend /root/build/public/css/ /var/www/html/public/css/
COPY --from=frontend /root/build/public/fonts/ /var/www/html/public/fonts/
COPY --from=frontend /root/build/public/img/ /var/www/html/public/img/
COPY --from=frontend /root/build/public/mix-manifest.json /var/www/html/public/mix-manifest.json
COPY --from=frontend /root/build/public/views/ /var/www/html/public/views/
COPY --from=frontend /root/build/public/assets/ /var/www/html/public/assets/

RUN set -x \
        && echo "* * * * * cd /var/www/html && php /var/www/html/artisan schedule:run >> /dev/null 2>&1" > /etc/cron.d/artisan-schedule-run \
# Give execution rights on the cron job
        && chmod 0644 /etc/cron.d/artisan-schedule-run \
        && chmod +x /etc/cron.d/artisan-schedule-run \
# Apply cron job
        && crontab /etc/cron.d/artisan-schedule-run \
# Create the log file to be able to run tail
        && touch /var/log/cron.log \
        && rm -f /etc/nginx/nginx.conf \
        && rm -f /etc/nginx/sites-enabled/default \
        && chown -R www-data:www-data /var/www/html \
        && find /var/www/html -type f -exec chmod 644 {} \; \
        && find /var/www/html -type d -exec chmod 755 {} \; \
        && chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/wordpress/wp-content \
        && sed -i 's/memory_limit = .*/memory_limit = '2048M'/' /etc/php/7.2/fpm/php.ini \
        && sed -i 's/max_execution_time = .*/max_execution_time = '90'/' /etc/php/7.2/fpm/php.ini \
        && chmod +x /var/www/html/run.sh
	
COPY supervisor-worker.conf /etc/supervisor/conf.d/supervisor-worker.conf
RUN mkdir -p /var/log/laravel/
COPY nginx.conf /etc/nginx/nginx.conf        
EXPOSE 80
ENTRYPOINT ["/var/www/html/run.sh"]
CMD ["nginx", "-g", "daemon off;"]
