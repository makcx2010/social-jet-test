FROM php:7.3-fpm

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN chmod uga+x /usr/local/bin/install-php-extensions && sync \
    && install-php-extensions pdo_mysql pcntl xdebug zip intl imap \
    && curl -s http://getcomposer.org/installer | php \
    && echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc \
    && mv composer.phar /usr/local/bin/composer

# Copy xdebug configuration for remote debugging
COPY .docker/common/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

COPY .docker/common/php-fpm/app.ini /usr/local/etc/php/conf.d/app.ini

RUN usermod -u 29999 www-data

USER 29999

WORKDIR /var/www
