#!/bin/bash

echo "Aguardando MySQL estar disponível..."

until mysqladmin ping -h mysql -u root --silent; do
  sleep 2
done

echo "Executando setup.php..."
php /var/www/html/setup.php

echo "Iniciando Apache..."
exec apache2-foreground