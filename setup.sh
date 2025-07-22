#!/bin/bash

# USA AS VARIÁVEIS CORRETAS (DB_*) PARA ESPERAR PELO BANCO DE DADOS
echo "Aguardando MySQL estar disponível na Railway..."
until mysqladmin ping -h$DB_SERVER -P$DB_PORT -u$DB_USER -p$DB_PASSWORD --silent; do
  echo "Ainda aguardando o banco de dados..."
  sleep 2
done

# O RESTO DO SCRIPT
echo "Executando setup.php..."
php /var/www/html/setup.php

# Inicia o servidor Apache.
echo "Iniciando Apache..."
exec apache2-foreground