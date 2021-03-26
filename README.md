What is it
==========

Installation
============

```bash
docker run \
-p 80:80/tcp \
-e DELIVERY_QUEUE_URL="http://queue" \
-e DELIVERY_SMS_URL="http://sms" \
-e DELIVERY_SMS_WORKER=sms \
-e DELIVERY_EMAIL_URL="http://email" \
-e DELIVERY_EMAIL_WORKER=email \
-e DELIVERY_FEED_URL="http://feed" \
-e DELIVERY_FEED_WORKER=feed \
-e DELIVERY_URL="http://delivery" \
-e DELIVERY_WORKER=delivery \
-e PG_HOST=db \
-e PG_PORT=5432 \
-e PG_DATABASE=delivery_db \
-e PG_USER=user \
-e PG_PASSWORD=password \
-d perfumerlabs/delivery:v1.0.0
```

Database must be created before container startup.

Environment variables
=====================

- DELIVERY_QUEUE_URL - [Queue](https://github.com/perfumerlabs/queue) service URL. Required.
- DELIVERY_SMS_URL [SMS](https://github.com/perfumerlabs/sms) service URL. Required.
- DELIVERY_SMS_WORKER - worker that handles sms queueing. Required.
- DELIVERY_EMAIL_URL [Email](https://github.com/perfumerlabs/email) service URL. Required.
- DELIVERY_EMAIL_WORKER - worker that handles email queueing. Required.
- DELIVERY_FEED_URL [Feed](https://github.com/perfumerlabs/feed) service URL. Required.
- DELIVERY_FEED_WORKER - worker that handles feed queueing. Required.
- DELIVERY_URL - this service URL. Required.
- DELIVERY_WORKER - worker that handles delivery queueing. Required.
- PHP_PM_MAX_CHILDREN - number of FPM workers. Default value is 10.
- PHP_PM_MAX_REQUESTS - number of FPM max requests. Default value is 500.
- PG_HOST - PostgreSQL host. Required.
- PG_PORT - PostgreSQL port. Default value is 5432.
- PG_DATABASE - PostgreSQL database name. Required.
- PG_USER - PostgreSQL user name. Required.
- PG_PASSWORD - PostgreSQL user password. Required.

Volumes
=======

This image has no volumes.

If you want to make any additional configuration of container, mount your bash script to /opt/setup.sh. This script will be executed on container setup.

# Контейнер рассылки email, feed, sms

Схема работы:

1. Для создания новой рассылки посылается запрос на `POST /delivery` с примерными параметрами

```json
{
  "min":1,
  "max":1000,
  "gap":100,
  "filters": {},
  "messages": {},
  "data_url": "/data/url"
}
```

- min, max, gap - это параметры для отправки на Queue на задачу /fraction.
- messages - текста для имейлов, смс, уведомлений
- data_url - URL на приложении куда будет кидаться раздробленные fraction-таски для получения реквизитов юзеров (имейлов, телефонов, идентификаторов для feed)
- filters - массив фильтров, кидаемый на data_url

2. Delivery сохранил рассылку и кидает на [Queue](https://github.com/perfumerlabs/queue#fraction-task) на fraction запрос.
3. Queue дробит запрос на маленькие таски.
4. каждый запрос по маленькому таску Queue делает на Delivery, а Delivery делает запрос на приложение на data_url. Delivery сохраняет факт получения маленького запроса. На основании этих данных затем будет строиться апишка для показа прогресса рассылки на приложении.
5. Delivery получает реквизиты юзеров по срезу и кидает запрос на отправу на email, sms или feed опять же на Queue.
