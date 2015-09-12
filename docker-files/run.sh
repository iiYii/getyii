#!/bin/bash

set -e -x 

cd /app
composer install --prefer-dist --no-interaction --optimize-autoloader
./init --env=${APP_ENV:-Production} --overwrite=y
./yii migrate --interactive=0

function setEnvironmentVariable() {
    if [ -z "$2" ]; then
            echo "Environment variable '$1' not set."
            return
    fi
    echo "env[$1] = \"$2\" ; automatically add env" >> /usr/local/etc/php-fpm.conf
}

sed -i '/automatically add env/d' /usr/local/etc/php-fpm.conf

# Grep all ENV variables
for _curVar in `env | awk -F = '{print $1}'`;do
    # awk has split them by the equals sign
    # Pass the name and value to our function
    setEnvironmentVariable ${_curVar} ${!_curVar}
done

supervisord -n
# service supervisord start
