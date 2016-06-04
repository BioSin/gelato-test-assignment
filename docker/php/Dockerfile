FROM php:5.6-fpm

RUN apt-get update && apt-get install -y --auto-remove \
    libpq-dev \
    php5-imagick \
    && docker-php-ext-install pdo pdo_mysql \
    && cp /usr/lib/php5/20131226/imagick.so /usr/local/lib/php/extensions/no-debug-non-zts-20131226/ \
    && cp /etc/php5/mods-available/imagick.ini /usr/local/etc/php/conf.d/ \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

ADD http://codeception.com/codecept.phar /usr/local/bin/codecept
RUN chmod +x /usr/local/bin/codecept
