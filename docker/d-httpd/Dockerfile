FROM httpd:2.4

COPY conf/httpd.conf /usr/local/apache2/conf/httpd.conf
RUN mkdir /usr/local/apache2/sites-enabled
COPY conf/cinema.local.conf /usr/local/apache2/conf/sites-enabled/cinema.local.conf

RUN usermod -u 1000 www-data

WORKDIR /var/www/html

EXPOSE 80
