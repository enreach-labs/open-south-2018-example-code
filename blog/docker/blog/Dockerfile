FROM ubuntu:16.04

LABEL maintainer="pedro.parraortega@voiceworks.com"

RUN apt-get update && \
	apt-get install -y software-properties-common && \
	LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/pkg-gearman && \
	LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php -y && \
	apt-get update && \
	apt-get -y dist-upgrade && \
	apt-get install -y curl \
	gettext \
	locales \
	sox \
	git \
	php7.1 \
	php7.1-cli \
	php7.1-apcu \
	php7.1-memcached \
	php7.1-mcrypt \
	php7.1-mysql \
	php7.1-sqlite \
	php7.1-curl \
	php7.1-gd \
	php7.1-soap \
	php-gearman \
	php7.1-json \
	php7.1-readline \
	php-xdebug \
	php7.1-xsl \
	php7.1-xml \
	php7.1-bcmath \
	php7.1-mbstring \
	php7.1-soap \
	php7.1-fpm \
	php-zip \
	php-imap \
	php7.1-dev \
	wget \
    apache2 \
    libapache2-mod-php7.1 \
    openssh-server \
    gearman-job-server \
    vim \
    ssh \
    sshpass \
    mysql-client \
    unzip && \
	a2enmod rewrite ssl actions headers &&\
	a2dissite 000-default.conf &&\
	phpenmod mcrypt bcmath && \
	curl -sS https://getcomposer.org/installer | php -- --install-dir=usr/bin  --filename=composer

WORKDIR /var/www
COPY blog.conf /etc/apache2/sites-available/blog.conf
RUN a2ensite blog.conf
EXPOSE 80
