FROM php:8.1-fpm

ARG SSH_PRIVATE_KEY
ARG SSH_PUBLIC_KEY
RUN echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt update \
    && apt install -y git zip unzip libzip-dev openssl libpq-dev symfony-cli \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql pdo pgsql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN usermod -u 1000 www-data
USER www-data
WORKDIR /var/www

EXPOSE 9000
