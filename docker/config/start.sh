#!/bin/sh

ln -s /dev/stdout /var/log/fpm-php.www.log
ln -s /dev/stdout /var/log/nginx/access.log

if [ "$TZ" != "" ]
then
  sed -i "s!Europe/London!$TZ!" /etc/php82/php.ini
fi

php-fpm82 -R

exec "$@"
