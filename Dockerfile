FROM php:8.4-cli-alpine

RUN apk add --no-cache \
    bash \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    postgresql-dev \
    nodejs \
    npm

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        mbstring \
        xml \
        gd \
        bcmath \
        pcntl \
        fileinfo

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --no-interaction

COPY package.json package-lock.json ./
RUN npm ci

COPY . .

RUN composer dump-autoload --optimize \
    && npm run build \
    && mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache

COPY docker/render-start.sh /usr/local/bin/render-start.sh
RUN chmod +x /usr/local/bin/render-start.sh

EXPOSE 10000

CMD ["/usr/local/bin/render-start.sh"]
