FROM composer:latest AS build

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction


FROM php:8.4-fpm-alpine

RUN apk add --no-cache nginx supervisor libpq-dev

RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql pdo_sqlite

COPY --from=build /app /var/www/html

COPY nginx.conf /etc/nginx/nginx.conf
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY deploy.sh /var/www/html/deploy.sh

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod +x /var/www/html/deploy.sh

WORKDIR /var/www/html

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
