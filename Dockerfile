# Dockerfile to deploy a XMovement

# Begin with a base Debian system (https://www.debian.org/), we are using the 'jessie' version
FROM debian:jessie

# Download the latest updates and
# install the packages we will need
RUN apt-get -y update \
 && apt-get -y upgrade -y \
 && DEBIAN_FRONTEND=noninteractive apt-get -y install \
        unzip zip \
        mysql-server \
        nginx-extras \
        php5-fpm \
        php5-mysql  \
        php5-mcrypt \
        php5-ldap \
        php5-gd \
        libssh2-php \
        php5-curl \
        curl \
        git \
		perl \
        vim \
        php-pear && rm -rf /var/lib/apt/lists/*

# Configure PHP FPM (http://php-fpm.org/)
RUN sed -i "s/cgi.fix_pathinfo.\+/cgi.fix_pathinfo = 0/" /etc/php5/fpm/php.ini
RUN echo "clear_env = no" >> /etc/php5/fpm/php-fpm.conf
RUN sed -i 's/upload_max_filesize.\+/upload_max_filesize = 200M/' /etc/php5/fpm/php.ini
RUN sed -i 's/post_max_size.\+/post_max_size = 200M/' /etc/php5/fpm/php.ini

# Allow fastcgi
RUN sed -i 's/listen = .\+/listen = 127.0.0.1:9000/' /etc/php5/fpm/pool.d/www.conf

# Create the empty directories we will use
RUN mkdir -p /var/www/html
RUN mkdir -p /app && rm -fr /var/www/html && ln -s /app /var/www/html

# Install node
RUN apt-get update -y && apt-get install --no-install-recommends -y -q curl python build-essential git ca-certificates
RUN mkdir /nodejs && curl http://nodejs.org/dist/v0.10.36/node-v0.10.36-linux-x64.tar.gz | tar xvzf - -C /nodejs --strip-components=1
ENV PATH $PATH:/nodejs/bin

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer

# Copy composer files
COPY composer.json ./
COPY composer.lock ./

# Install and run gulp
RUN npm -v
RUN npm install -g npm@latest
RUN npm config set prefix /usr/local

# Copy node files
COPY package.json /tmp/package.json
RUN cd /tmp && npm install
RUN mkdir -p /app && cp -a /tmp/node_modules /app/

RUN composer install --no-scripts --no-autoloader

WORKDIR /app
COPY . /app

RUN composer dump-autoload --optimize

###
RUN composer install
#RUN composer run-script post-install-cmd
###

RUN chown -R www-data:www-data /app

# Set the timezone for php
RUN echo 'date.timezone="Europe/London"' >> /etc/php5/fpm/php.ini

# Set permissions
RUN chown www-data:www-data -R bootstrap/cache
RUN chmod -R 775 bootstrap/cache

RUN chown www-data:www-data -R storage
RUN chmod -R 775 storage

RUN npm install
RUN npm install bower -g
RUN npm install gulp -g

# Setup MySQL server
RUN ln -s /var/lib/mysql/mysql.sock /tmp/mysql.sock

# Add our nginx config file to nginx's config folder
ADD nginx-default /etc/nginx/sites-available/default

# Declare /data & /assets as a persistent volume
# (so they don't get removed when the server restarts)
VOLUME /data
VOLUME /app

#RUN rm -fr /app
#RUN ln -s /app /data/app

RUN php artisan vendor:publish --force

#RUN perl -pi.bak -e 's/\/\/\*\*//g' config/app.php

# Declare the port we will use
EXPOSE 80

# Let our run script be run
#RUN chmod +x /app/run.sh
RUN chown www-data:www-data -R /app/run.sh
RUN chmod 777 /app/run.sh

#RUN rm -fr /app
#RUN ln -s /app /data/app

ARG deployment_name
ENV DEPLOYMENT_NAME $deployment_name

RUN mysql -u root --password -e "CREATE DATABASE $DEPLOYMENT_NAME";

# Start our application
CMD /app/run.sh
