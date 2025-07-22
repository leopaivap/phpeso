# Usa a imagem base oficial do PHP 7.4 com Apache
FROM php:7.4-apache

# Instala as dependências necessárias, incluindo o cliente MySQL
RUN apt-get update && apt-get install -y default-mysql-client libpq-dev \
    && docker-php-ext-install pdo pdo_mysql

# Habilita o módulo rewrite do Apache para o .htaccess funcionar
RUN a2enmod rewrite

# Copia o arquivo de configuração do Apache
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# --- A CORREÇÃO CRÍTICA ESTÁ AQUI ---
# Copia TODOS os arquivos da sua aplicação para o diretório do servidor web
COPY . /var/www/html

# Copia o script de inicialização para um local de fácil acesso
COPY setup.sh /setup.sh
RUN chmod +x /setup.sh

# Define o ponto de entrada do container para executar o script de setup
ENTRYPOINT ["/setup.sh"]