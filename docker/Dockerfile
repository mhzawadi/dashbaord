FROM alpine:3.18
MAINTAINER Matthew Horwood <matt@horwood.biz>

# Install required deb packages
RUN apk update && apk upgrade && \
    apk add nginx php81-fpm php81-pdo_mysql php81-sockets php81-gd php81-ldap \
    php81-gettext php81-pcntl php81-mysqlnd php81-session php81-gmp php81-json \
    php81-mbstring php81-iconv php81-ctype php81-curl php81-pear php81-simplexml \
    php81-dom php81-xmlwriter php81-tokenizer php81 php81-phar php81-sqlite3 curl git \
    && mkdir -p /var/www/html/ \
    && mkdir -p /run/nginx \
    && rm -f /var/cache/apk/*; \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer;

COPY docker/config /config

RUN cp /config/php.ini /etc/php81/php.ini && \
    cp /config/php_fpm_site.conf /etc/php81/php-fpm.d/www.conf && \
    cp /config/nginx_site.conf /etc/nginx/http.d/default.conf;

WORKDIR /var/www/html
COPY . .
RUN composer install \
  && mkdir -p /var/www/html/user_data \
  && chown nobody:nobody * -R

VOLUME /var/www/html/user_data
EXPOSE 8080
ENTRYPOINT ["/config/start.sh"]
CMD ["nginx", "-g", "daemon off;"]

## Health Check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s \
  CMD curl -f http://127.0.0.1:8080 || exit 1
