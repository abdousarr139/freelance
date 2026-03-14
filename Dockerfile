FROM php:8.4-cli

# Installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev \
    libonig-dev libxml2-dev nodejs npm \
    && docker-php-ext-install pdo pdo_mysql mbstring zip xml bcmath

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Dossier de travail
WORKDIR /var/www

# Copier les fichiers
COPY . .

# Installer les dépendances PHP
RUN composer install --optimize-autoloader --no-interaction --no-dev

# Installer et builder les assets
RUN npm install && npm run build

# Permissions storage
RUN mkdir -p storage/framework/{sessions,views,cache,testing} \
    storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Exposer le port
EXPOSE 8000

# Démarrer Laravel
CMD php artisan config:clear && \
    php artisan view:clear && \
    php artisan route:clear && \
    php artisan migrate --force && \
    php artisan storage:link && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}