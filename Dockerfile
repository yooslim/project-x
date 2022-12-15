FROM yooslim/php8-fpm:latest

LABEL maintainer="Slimani Youcef <slimani.youcef.09@gmail.com>"

RUN apt-get update -y

RUN mkdir app config bootstrap database public resources routes tests \
    && mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/testing storage/framework/views storage/app/public \
    && mkdir -p storage/logs

COPY ./.env ./composer.json ./composer.lock artisan phpunit.xml ./
COPY ./app/ app/
COPY ./config/ config/
COPY ./bootstrap/ bootstrap/
COPY ./database/ database/
COPY ./public/ public/
COPY ./resources/ resources/
COPY ./routes/ routes/
COPY ./tests/ tests/
COPY ./vendor/ vendor/

ENV TZ Africa/Algiers

EXPOSE 9000
