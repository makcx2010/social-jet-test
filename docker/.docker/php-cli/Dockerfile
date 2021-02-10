FROM php:7.3-cli

COPY .docker/common/php-cli/wait-for-it.sh /
COPY .docker/common/php-cli/docker-entrypoint.sh /

RUN apt-get update && apt-get install -y libmcrypt-dev cron libevent-dev supervisor libssl-dev \
    && docker-php-ext-install -j$(nproc) pdo_mysql pcntl sockets \
    && cd /root && echo "* * * * * /usr/local/bin/php /var/www/yii schedule/run --scheduleFile=@console/config/schedule.php >> /dev/null 2>&1" >> rootcron \
    && crontab rootcron && rm rootcron \
    && pecl install event-2.5.3 && docker-php-ext-enable event \
    && mkdir /var/log/telegram-bot \
    && chmod +x /wait-for-it.sh \
    && chmod +x /docker-entrypoint.sh

WORKDIR /var/www

ENTRYPOINT ["/docker-entrypoint.sh"]
