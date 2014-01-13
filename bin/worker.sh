#!/bin/bash

php /var/www/symfony/app/console rabbitmq:consumer -m 1 upload_picture
echo `date` >&2

sleep 1