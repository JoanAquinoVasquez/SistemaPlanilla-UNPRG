FROM php:8.2-cli

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Instala extensiones necesarias y Composer
RUN apt-get update && apt-get install -y libzip-dev\
    git \
    unzip \
    zip \
    libgd-dev \
    libpng-dev \
    && docker-php-ext-install gd pdo_mysql zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia el código fuente
COPY . .

# Ejecuta Composer
RUN composer install --no-dev --optimize-autoloader

# Expone el puerto 8000
EXPOSE 8000

# Comando predeterminado
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
