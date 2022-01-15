FROM php:8.0-cli-alpine
RUN set -eux \
  && apk add --no-cache \
    bash \
    git \
  && docker-php-ext-install pcntl
WORKDIR /app
COPY docker/.gitconfig /root/.gitconfig
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
