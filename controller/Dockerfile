FROM php:8.0-apache
#default root folder of the server
WORKDIR /var/www/html/
#debian mysql driver, mysqli plugin
RUN apt-get update && apt-get install -y libaprutil1-dbd-mysql && \
    docker-php-ext-install mysqli && docker-php-ext-enable mysqli && \
    service apache2 restart