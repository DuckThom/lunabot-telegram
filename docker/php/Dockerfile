FROM php:7.0-fpm

RUN apt update && apt install -y fortune-mod

ADD ./telegram.ini /usr/local/etc/php/conf.d
ADD ./telegram.pool.conf /usr/local/etc/php-fpm.d/

RUN usermod -u 1000 www-data

WORKDIR /var/www/telegram-bot

CMD ["php-fpm"]

EXPOSE 9000
