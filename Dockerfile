FROM php:8.1-apache-buster

WORKDIR /laravel-example

ENV APACHE_DOCUMENT_ROOT /app/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf


RUN a2enmod rewrite && /etc/init.d/apache2 restart

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN sed -i 's/expose_php = On/expose_php = Off/' /usr/local/etc/php/php.ini
RUN sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 5M/' /usr/local/etc/php/php.ini


ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt-get install -y build-essential nodejs
RUN install-php-extensions @fix_letsencrypt gd bcmath redis pdo_mysql pcntl @composer zip

COPY package.json .
RUN npm i

COPY . .

RUN chmod -R 777 /laravel-example/storage
RUN chmod -R 777 /laravel-example/bootstrap/cache

RUN rm -rf composer.lock
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN composer dump-autoload --optimize
RUN npm run build
# RUN php artisan sail:install
# RUN ./vendor/bin/sail up
# RUN php artisan horizon
# RUN php artisan route:cache && php artisan view:cache


EXPOSE 80/tcp
# CMD ["php", "artisan", "octane:start", "--host=0.0.0.0"]
