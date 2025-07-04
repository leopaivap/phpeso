# Usa a imagem base oficial do PHP 7.4 com Apache
FROM php:7.4-apache

# HABILITA O MÓDULO DE REWRITING DO APACHE (A CAUSA DO ERRO)
RUN a2enmod rewrite

# Instala as extensões PHP necessárias para se conectar ao MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copia o arquivo de configuração do site para permitir que o .htaccess funcione
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Copia o script que prepara o banco de dados e inicia a aplicação
COPY setup.sh /setup.sh
RUN chmod +x /setup.sh

# Define o ponto de entrada do container para executar o script de setup
ENTRYPOINT ["/setup.sh"]