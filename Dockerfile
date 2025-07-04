# Usa a imagem base oficial do PHP 7.4 com Apache
FROM php:7.4-apache

# Atualiza os pacotes e instala o cliente MySQL e outras dependências
# ESTA LINHA CORRIGE O ERRO "mysqladmin: command not found"
RUN apt-get update && apt-get install -y default-mysql-client libpq-dev \
    && docker-php-ext-install pdo pdo_mysql

# Habilita o módulo rewrite do Apache (para o .htaccess funcionar)
RUN a2enmod rewrite

# Copia o arquivo de configuração do site para permitir o uso do .htaccess
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Copia o script que prepara o banco de dados e inicia a aplicação
COPY setup.sh /setup.sh
RUN chmod +x /setup.sh

# Define o ponto de entrada do container para executar o script de setup
ENTRYPOINT ["/setup.sh"]