FROM dcb9/php-fpm:latest

MAINTAINER Bob <bob@phpor.me>

# http://serverfault.com/questions/599103/make-a-docker-application-write-to-stdout
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
  && ln -sf /dev/stderr /var/log/nginx/error.log

ENV COMPOSER_HOME /root/.composer
ENV PATH /root/.composer/vendor/bin:$PATH
COPY docker-files/root.composer.config.json /root/.composer/config.json
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
  && /usr/local/bin/composer global require "fxp/composer-asset-plugin" \
# add chinese image http://pkg.phpcomposer.com/
  && composer config -g repositories.packagist composer http://packagist.phpcomposer.com

COPY docker-files/getyii.com.conf /etc/nginx/conf.d/
RUN mkdir /app
WORKDIR /app
COPY . /app/

RUN composer install \
  && chmod 700 docker-files/run.sh init

CMD ["docker-files/run.sh"]
