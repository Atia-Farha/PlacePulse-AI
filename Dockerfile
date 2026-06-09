FROM php:8.4-cli-alpine

# ✅ Required build tools (IMPORTANT on Alpine)
RUN apk add --no-cache \
    bash \
    git \
    curl \
    nodejs \
    npm \
    zip \
    unzip \
    sqlite-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libxml2-dev \
    oniguruma-dev \
    $PHPIZE_DEPS

# ✅ PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_sqlite \
        mbstring \
        xml \
        gd \
        bcmath \
        pcntl \
        fileinfo

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Dependencies first (better caching)
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