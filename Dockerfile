FROM php:7.0-fpm

MAINTAINER doberbeatz

RUN mkdir /project
WORKDIR /project

RUN docker-php-ext-install pdo pdo_mysql

ADD . /project

# Install Cron
RUN apt-get update
RUN apt-get install -y cron
ADD ./crontab /etc/crontab
RUN chmod 0644 /etc/crontab
RUN touch /var/log/cron.log

EXPOSE 9000