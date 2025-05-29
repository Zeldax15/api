# Usa una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Habilita mod_rewrite para Slim
RUN a2enmod rewrite

# Instala extensiones necesarias para MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copia el contenido de tu proyecto al contenedor
COPY . /var/www/html/

# Instala Composer y las dependencias
RUN apt-get update && apt-get install -y unzip \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer install --no-dev

# Cambia el directorio de trabajo
WORKDIR /var/www/html/

# Establece permisos
RUN chown -R www-data:www-data /var/www/html

# Configura Apache para usar /public como raíz
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Expone el puerto por defecto
EXPOSE 80
