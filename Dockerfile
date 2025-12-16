FROM richarvey/nginx-php-fpm:latest

RUN apk add --no-cache \
    tesseract-ocr \
    tesseract-ocr-dev \
    tesseract-ocr-data-eng

COPY . .

ENV SKIP_COMPOSER=0
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
RUN chmod +x start.sh

ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1


ENV APP_ENV=production
ENV APP_DEBUG=true
ENV LOG_CHANNEL=stderr

ENV COMPOSER_ALLOW_SUPERUSER=1
