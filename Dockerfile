FROM php:7.0-fpm

MAINTAINER doberbeatz

RUN mkdir /project
WORKDIR /project

RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update
RUN apt-get install -y cron

ADD . /project
ADD ./crontab /etc/cron.d/crontab
RUN chmod 0644 /etc/cron.d/crontab

EXPOSE 9000