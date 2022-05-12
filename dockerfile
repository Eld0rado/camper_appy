FROM php8.1-apache

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \ mv composer.phar /usr/local/bin/console

RUN apt update && apt install -yqq nodejs npm