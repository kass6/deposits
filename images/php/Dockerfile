FROM php:7.4-fpm-buster

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN apt-get update && apt-get install -y -qq --force-yes \
    git \
    libssl-dev \
    libcurl4-openssl-dev \
    libxslt-dev \
    curl \
    libfreetype6-dev \
    libgmp-dev \
    libldap2-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip

RUN docker-php-ext-install exif pcntl bcmath tokenizer curl fileinfo intl mbstring gettext pdo pdo_pgsql

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

ADD php.ini /usr/local/etc/php/php.ini
WORKDIR /var/www/html
