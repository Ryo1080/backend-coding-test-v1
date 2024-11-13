FROM php:8.2.19-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    make \
    zip \
    wget \
    libzip-dev \
    libnss3 \
    gnupg \
    libgconf-2-4 \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*\
    && docker-php-ext-install \
    pdo_mysql \
    sockets \
    bcmath \
    zip \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /bin/composer \
    && apt-get update -y \
    && apt-get clean \
    && apt-get install -y imagemagick libmagickwand-dev \
    && sed -i -e 's/domain="coder" rights="none"/domain="coder" rights="write|read"/g' /etc/ImageMagick-6/policy.xml \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

COPY laravel /var/www/project
COPY docker/laravel/php.ini /usr/local/etc/php/
