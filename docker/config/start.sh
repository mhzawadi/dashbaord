#!/bin/sh

ln -s /dev/stdout /var/log/fpm-php.www.log
ln -s /dev/stdout /var/log/nginx/access.log

if [ "$TZ" != "" ]
then
  sed -i "s!US/Central!$TZ!" /etc/php81/php.ini
fi

php-fpm81 -R

exec "$@"
