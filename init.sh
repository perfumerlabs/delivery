#!/usr/bin/env bash

set -x \
&& rm -rf /etc/nginx \
&& rm -rf /etc/supervisor \
&& mkdir /run/php

set -x \
&& cp -r "/usr/share/container_config/nginx" /etc/nginx \
&& cp -r "/usr/share/container_config/supervisor" /etc/supervisor

DELIVERY_QUEUE_URL_SED=${DELIVERY_QUEUE_URL//\//\\\/}
DELIVERY_QUEUE_URL_SED=${DELIVERY_QUEUE_URL_SED//\./\\\.}
DELIVERY_SMS_URL_SED=${DELIVERY_SMS_URL//\//\\\/}
DELIVERY_SMS_URL_SED=${DELIVERY_SMS_URL_SED//\./\\\.}
DELIVERY_EMAIL_URL_SED=${DELIVERY_EMAIL_URL//\//\\\/}
DELIVERY_EMAIL_URL_SED=${DELIVERY_EMAIL_URL_SED//\./\\\.}
DELIVERY_FEED_URL_SED=${DELIVERY_FEED_URL//\//\\\/}
DELIVERY_FEED_URL_SED=${DELIVERY_FEED_URL_SED//\./\\\.}
DELIVERY_URL_SED=${DELIVERY_URL//\//\\\/}
DELIVERY_URL_SED=${DELIVERY_URL_SED//\./\\\.}
DELIVERY_TIMEZONE_SED=${DELIVERY_TIMEZONE//\//\\\/}
DELIVERY_TIMEZONE_SED=${DELIVERY_TIMEZONE_SED//\./\\\.}
PG_HOST_SED=${PG_HOST//\//\\\/}
PG_HOST_SED=${PG_HOST_SED//\./\\\.}
PG_PASSWORD_SED=${PG_PASSWORD//\//\\\/}
PG_PASSWORD_SED=${PG_PASSWORD_SED//\./\\\.}

sed -i "s/error_log = \/var\/log\/php7.4-fpm.log/error_log = \/dev\/stdout/g" /etc/php/7.4/fpm/php-fpm.conf
sed -i "s/;error_log = syslog/error_log = \/dev\/stdout/g" /etc/php/7.4/fpm/php.ini
sed -i "s/;error_log = syslog/error_log = \/dev\/stdout/g" /etc/php/7.4/cli/php.ini
sed -i "s/log_errors = Off/log_errors = On/g" /etc/php/7.4/cli/php.ini
sed -i "s/log_errors = Off/log_errors = On/g" /etc/php/7.4/fpm/php.ini
sed -i "s/log_errors_max_len = 1024/log_errors_max_len = 0/g" /etc/php/7.4/cli/php.ini
sed -i "s/user = www-data/user = delivery/g" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/group = www-data/group = delivery/g" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/pm = dynamic/pm = static/g" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/pm.max_children = 5/pm.max_children = ${PHP_PM_MAX_CHILDREN}/g" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/;pm.max_requests = 500/pm.max_requests = ${PHP_PM_MAX_REQUESTS}/g" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/listen.owner = www-data/listen.owner = delivery/g" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/listen.group = www-data/listen.group = delivery/g" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/;catch_workers_output = yes/catch_workers_output = yes/g" /etc/php/7.4/fpm/pool.d/www.conf

if [ $DEV != 'true' ]; then
  sed -i "s/\$this->addResources(__DIR__ \. '\/\.\.\/env\.php');//g" /opt/delivery/src/Application.php
  sed -i "s/DELIVERY_QUEUE_URL/$DELIVERY_QUEUE_URL_SED/g" /opt/delivery/src/Resource/config/resources_shared.php
  sed -i "s/DELIVERY_SMS_URL/$DELIVERY_SMS_URL_SED/g" /opt/delivery/src/Resource/config/resources_shared.php
  sed -i "s/DELIVERY_SMS_WORKER/$DELIVERY_SMS_WORKER/g" /opt/delivery/src/Resource/config/resources_shared.php
  sed -i "s/DELIVERY_EMAIL_URL/$DELIVERY_EMAIL_URL_SED/g" /opt/delivery/src/Resource/config/resources_shared.php
  sed -i "s/DELIVERY_EMAIL_WORKER/$DELIVERY_EMAIL_WORKER/g" /opt/delivery/src/Resource/config/resources_shared.php
  sed -i "s/DELIVERY_FEED_URL/$DELIVERY_FEED_URL_SED/g" /opt/delivery/src/Resource/config/resources_shared.php
  sed -i "s/DELIVERY_FEED_WORKER/$DELIVERY_FEED_WORKER/g" /opt/delivery/src/Resource/config/resources_shared.php
  sed -i "s/DELIVERY_URL/$DELIVERY_URL_SED/g" /opt/delivery/src/Resource/config/resources_shared.php
  sed -i "s/DELIVERY_WORKER/$DELIVERY_WORKER/g" /opt/delivery/src/Resource/config/resources_shared.php
  sed -i "s/DELIVERY_TIMEZONE/$DELIVERY_TIMEZONE_SED/g" /opt/delivery/src/Resource/config/resources_shared.php
  sed -i "s/PG_HOST/$PG_HOST_SED/g" /opt/delivery/src/Resource/config/resources_shared.php
  sed -i "s/PG_PORT/$PG_PORT/g" /opt/delivery/src/Resource/config/resources_shared.php
  sed -i "s/PG_DATABASE/$PG_DATABASE/g" /opt/delivery/src/Resource/config/resources_shared.php
  sed -i "s/PG_SCHEMA/$PG_SCHEMA/g" /opt/delivery/src/Resource/config/resources_shared.php
  sed -i "s/PG_USER/$PG_USER/g" /opt/delivery/src/Resource/config/resources_shared.php
  sed -i "s/PG_PASSWORD/$PG_PASSWORD_SED/g" /opt/delivery/src/Resource/config/resources_shared.php
  sed -i "s/PG_HOST/$PG_HOST_SED/g" /opt/delivery/src/Resource/propel/connection/propel.php
  sed -i "s/PG_PORT/$PG_PORT/g" /opt/delivery/src/Resource/propel/connection/propel.php
  sed -i "s/PG_DATABASE/$PG_DATABASE/g" /opt/delivery/src/Resource/propel/connection/propel.php
  sed -i "s/PG_SCHEMA/$PG_SCHEMA/g" /opt/delivery/src/Resource/propel/connection/propel.php
  sed -i "s/PG_USER/$PG_USER/g" /opt/delivery/src/Resource/propel/connection/propel.php
  sed -i "s/PG_PASSWORD/$PG_PASSWORD_SED/g" /opt/delivery/src/Resource/propel/connection/propel.php
fi

if [ $DEV = 'true' ]; then
  set -x \
  && cd /opt/delivery \
  && cp env.example.php env.php \
  && cp propel.example.php propel.php
fi

set -x \
&& cd /opt/delivery \
&& sudo -u delivery php cli framework propel/migrate

touch /node_status_inited
