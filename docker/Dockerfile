FROM alpine:3.21
LABEL org.opencontainers.image.authors="matt@horwood.biz"

# Install required deb packages
RUN apk update && apk upgrade && \
    apk add gnupg unit-php84 php84-pdo_mysql php84-sockets php84-gd php84-ldap \
    php84-gettext php84-pcntl php84-mysqlnd php84-session php84-gmp php84-json \
    php84-mbstring php84-iconv php84-ctype php84-curl php84-pear php84-simplexml \
    php84-dom php84-xmlwriter php84-tokenizer php84 php84-phar php84-sqlite3 curl git \
    && mkdir -p /var/www/html/ \
    && mkdir -p /run/nginx \
    && rm -f /var/cache/apk/*; \
    [ -f /usr/bin/php ] && rm -f /usr/bin/php; \
    ln -s /usr/bin/php84 /usr/bin/php; \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer;

COPY docker/config /config

WORKDIR /var/www/html
COPY . .
RUN cp /config/php.ini /etc/php84/php.ini \
  && composer install \
  && mkdir -p /var/www/html/user_data \
  && chown nobody:nobody * -R

VOLUME /var/www/html/user_data
EXPOSE 8080
ENTRYPOINT ["/config/start.sh"]
CMD ["unitd", "--no-daemon", "--control", "unix:/var/run/control.unit.sock"]

## Health Check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s \
  CMD curl -f http://127.0.0.1:8080 || exit 1
