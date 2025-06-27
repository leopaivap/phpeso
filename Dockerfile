FROM php:7.4-apache


RUN apt-get update && apt-get install -y default-mysql-client libpq-dev \
    && docker-php-ext-install pdo pdo_mysql


COPY setup.sh /setup.sh
RUN chmod +x /setup.sh


ENTRYPOINT ["/setup.sh"]