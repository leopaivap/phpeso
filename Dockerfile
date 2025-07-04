FROM php:7.4-apache


RUN apt-get update && apt-get install -y default-mysql-client libpq-dev \
    && docker-php-ext-install pdo pdo_mysql

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

COPY setup.sh /setup.sh
RUN chmod +x /setup.sh

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
ENTRYPOINT ["/setup.sh"]