FROM php:7.2-fpm

RUN apt-get update

# Setup NodeJS
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -

# gosu, git client, redis, intl, zip, pdo, mcrypt, gd, iconv, gmp, bcmath, nodejs
RUN apt-get install -y --no-install-recommends \
    gosu git unzip zip libzip-dev zlib1g-dev libpq5 libpq-dev rsync \
    libicu57 libicu-dev g++ libxml2 libxml2-dev \
    libfreetype6 libfreetype6-dev libjpeg62-turbo libjpeg62-turbo-dev \
    libgmp10 libgmp-dev libmcrypt4 libmcrypt-dev libpng16-16 libpng-dev \
    libmagickwand-6.q16-3 libmagickwand-6.q16-dev nodejs \
    && docker-php-ext-configure zip --without-libzip \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install zip intl iconv gd gmp bcmath opcache \
    && pecl install mcrypt-1.0.2 && docker-php-ext-enable mcrypt \
    && pecl install xdebug-beta && docker-php-ext-enable xdebug \
    && pecl install apcu && docker-php-ext-enable apcu \
    && apt-get purge -y *-dev g++ && apt-get -y autoremove --purge \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && pecl clear-cache && rm -rf /usr/src/php.tar.xz*

# opcache.ini
COPY .docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# php.ini
COPY .docker/php/php.ini /usr/local/etc/php/

# install composer
COPY .docker/php/install-composer.sh /tmp/install-composer.sh
RUN sh /tmp/install-composer.sh && rm -f /tmp/install-composer.sh

ENV COMPOSER_HOME /var/www/.composer
VOLUME /var/www/.composer

WORKDIR /var/www/group_action

CMD ["php-fpm"]