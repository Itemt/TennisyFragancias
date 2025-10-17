# Dockerfile para Tennis y Fragancias en Coolify
FROM php:8.1-apache

# Instalar extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install zip

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Configurar Apache
RUN echo '<Directory /var/www/html>' >> /etc/apache2/apache2.conf \
    && echo '    AllowOverride All' >> /etc/apache2/apache2.conf \
    && echo '    Require all granted' >> /etc/apache2/apache2.conf \
    && echo '</Directory>' >> /etc/apache2/apache2.conf

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de la aplicación
COPY . /var/www/html/

# Crear directorios necesarios
RUN mkdir -p public/imagenes/productos \
    && mkdir -p public/imagenes/categorias \
    && mkdir -p database/backups \
    && mkdir -p tmp

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 public/imagenes \
    && chmod -R 777 database/backups \
    && chmod -R 777 tmp \
    && chmod -R 777 app/config

# Exponer puerto 80
EXPOSE 80

# Script de inicio
COPY <<'EOF' /usr/local/bin/docker-entrypoint.sh
#!/bin/bash
set -e

# Crear archivo .env si no existe
if [ ! -f /var/www/html/app/config/.env ]; then
    echo "Creando archivo .env..."
    cat > /var/www/html/app/config/.env <<ENVEOF
DB_HOST=${DB_HOST}
DB_NOMBRE=${DB_NOMBRE}
DB_USUARIO=${DB_USUARIO}
DB_PASSWORD=${DB_PASSWORD}
DB_PUERTO=${DB_PUERTO}
URL_BASE=${URL_BASE}
EMPRESA_NOMBRE=${EMPRESA_NOMBRE}
EMPRESA_CIUDAD=${EMPRESA_CIUDAD}
EMPRESA_DEPARTAMENTO=${EMPRESA_DEPARTAMENTO}
EMPRESA_PAIS=${EMPRESA_PAIS}
EMPRESA_EMAIL=${EMPRESA_EMAIL}
EMPRESA_TELEFONO=${EMPRESA_TELEFONO}
APP_ENV=${APP_ENV}
DEBUG_MODE=${DEBUG_MODE}
ENVEOF
fi

# Iniciar Apache
exec apache2-foreground
EOF

RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Comando de inicio
CMD ["/usr/local/bin/docker-entrypoint.sh"]
