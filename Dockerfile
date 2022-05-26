#
# PHP Dependencies
#
FROM composer:2.1.14 as vendor
COPY database/ database/
COPY composer.json composer.json
# COPY composer.lock composer.lock
RUN composer install \
	--ignore-platform-reqs \
	--no-interaction \
	--no-plugins \
	--no-scripts \
	--prefer-dist

#
# Frontend
#
FROM node:16.15.0 as frontend
RUN mkdir -p /app/public
COPY package.json webpack.mix.js /app/
# COPY yarn.lock /app/
COPY resources/ /app/resources/
WORKDIR /app
RUN yarn install && yarn production

#
# Application
#
FROM php:7.1.33-apache-buster

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
	install-php-extensions \
		gd \
		memcached \
		imagick \
		zip

COPY . /var/www/html
COPY --from=vendor /app/vendor/ /var/www/html/vendor/
COPY --from=frontend /app/public/js/ /var/www/html/public/js/
COPY --from=frontend /app/public/css/ /var/www/html/public/css/
COPY --from=frontend /app/mix-manifest.json /var/www/html/mix-manifest.json

RUN chown -R www-data:www-data /var/www/html/
