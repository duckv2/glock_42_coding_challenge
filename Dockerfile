FROM php:8-cli
ENV PORT=8000
WORKDIR /app
COPY . /app
RUN apt-get update; apt-get install -y libzip-dev unzip
RUN docker-php-ext-install zip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install
RUN touch /app/database/database.sqlite
RUN DB_CONNECTION=sqlite php artisan migrate
RUN echo "#!/bin/sh\n" \
  "php artisan migrate\n" \
  "php artisan serve --host 0.0.0.0 --port \$PORT" > /app/start.sh
RUN chmod +x /app/start.sh
CMD ["/app/start.sh"]
