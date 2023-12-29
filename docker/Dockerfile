FROM alpine:3.19
MAINTAINER Matthew Horwood <matt@horwood.biz>

# Install required deb packages
RUN apk update && apk upgrade && \
    apk add nginx php82-fpm php82-pdo_mysql php82-sockets php82-gd php82-ldap \
    php82-gettext php82-pcntl php82-mysqlnd php82-session php82-gmp php82-json \
    php82-mbstring php82-iconv php82-ctype php82-curl php82-pear php82-simplexml \
    php82-dom php82-xmlwriter php82-tokenizer php82 php82-phar php82-sqlite3 curl git \
    && mkdir -p /var/www/html/ \
    && mkdir -p /run/nginx \
    && rm -f /var/cache/apk/*; \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer;

COPY docker/config /config

RUN cp /config/php.ini /etc/php82/php.ini && \
    cp /config/php_fpm_site.conf /etc/php82/php-fpm.d/www.conf && \
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
