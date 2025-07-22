#!/bin/bash

# USA AS VARIÁVEIS DA RAILWAY PARA ESPERAR PELO BANCO DE DADOS
echo "Aguardando MySQL estar disponível na Railway..."
until mysqladmin ping -h$MYSQLHOST -P$MYSQLPORT -u$MYSQLUSER -p$MYSQLPASSWORD --silent; do
  echo "Ainda aguardando..."
  sleep 2
done

echo "Executando setup.php para criar tabelas..."
php /var/www/html/app/repository/create-table.php
php /var/www/html/app/repository/muscle-group/populate-muscle-groups.php

echo "Iniciando Apache..."
exec apache2-foreground