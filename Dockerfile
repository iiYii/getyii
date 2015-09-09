FROM dcb9/php-fpm:latest

MAINTAINER Bob <bob@phpor.me>

RUN apt-get update \
  && apt-get install -y --no-install-recommends git vim \
  && rm -rf /var/lib/apt/lists/*

# http://serverfault.com/questions/599103/make-a-docker-application-write-to-stdout
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
  && ln -sf /dev/stderr /var/log/nginx/error.log \
  && mkdir /app
WORKDIR /app

ENV COMPOSER_HOME /root/.composer
ENV PATH /root/.composer/vendor/bin:$PATH
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
  # add chinese image http://pkg.phpcomposer.com/
  && composer config -g repositories.packagist composer http://packagist.phpcomposer.com \
  && /usr/local/bin/composer global require --prefer-source --no-interaction "fxp/composer-asset-plugin"

COPY docker-files/getyii.com.conf /etc/nginx/conf.d/
RUN docker-php-ext-install mysqli pdo pdo_mysql \
  && rm -rf /etc/nginx/conf.d/default.conf /etc/nginx/conf.d/example_ssl.conf
COPY . /app/

RUN chmod 700 docker-files/run.sh init

VOLUME ["/root/.composer", "/app/vendor"]
CMD ["docker-files/run.sh"]
EXPOSE 80
