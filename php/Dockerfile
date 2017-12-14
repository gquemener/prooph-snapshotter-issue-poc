FROM php:7.1-cli

RUN apt-get update && apt-get install -y \
    git ssh libpq-dev\
    --no-install-recommends && \
    rm -r /var/lib/apt/lists/*

RUN docker-php-ext-configure pgsql --with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo_pgsql
RUN pecl install xdebug
RUN echo zend_extension=xdebug.so > /usr/local/etc/php/conf.d/debug.ini &&\
    echo xdebug.remote_enable=1 >> /usr/local/etc/php/conf.d/debug.ini &&\
    echo xdebug.remote_connect_back=1 >> /usr/local/etc/php/conf.d/debug.ini &&\
    echo xdebug.remote_autostart=1 >> /usr/local/etc/php/conf.d/debug.ini &&\
    echo xdebug.remote_port=9000 >> /usr/local/etc/php/conf.d/debug.ini &&\
    echo xdebug.remote_handler=dbgp >> /usr/local/etc/php/conf.d/debug.ini &&\
    echo xdebug.max_nesting_level=250 >> /usr/local/etc/php/conf.d/debug.ini &&\
    echo xdebug.cli_color=1 >> /usr/local/etc/php/conf.d/debug.ini &&\
    echo xdebug.idekey=vim >> /usr/local/etc/php/conf.d/debug.ini &&\
    echo xdebug.remote_host=172.24.0.1 >> /usr/local/etc/php/conf.d/debug.ini &&\
    echo xdebug.var_display_max_depth=10 >> /usr/local/etc/php/conf.d/debug.ini

WORKDIR /data
