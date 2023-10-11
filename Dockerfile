# Usa la imagen base de Almalinux
FROM almalinux:latest

# Instala los paquetes necesarios
RUN dnf install -y epel-release
RUN dnf install -y https://rpms.remirepo.net/enterprise/remi-release-9.rpm
RUN dnf module enable -y php:remi-7.4
RUN dnf update -y
RUN dnf install -y php php-cli php-mbstring php-xml php-gd php-zip php-mysqlnd php-json

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Copia el código fuente de tu proyecto Laravel (incluyendo el archivo composer.json)
COPY . .

# Instala las dependencias de Composer
RUN composer install
RUN php artisan key:generate

# Copia la configuración del servidor web si es necesario (por ejemplo, nginx o Apache)

# Expon el puerto si es necesario (por ejemplo, para el servidor web)
EXPOSE 8000

# Comando para iniciar tu aplicación (por ejemplo, para un servidor web)
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
CMD sleep infinity
