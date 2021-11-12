FROM php:7
RUN apt-get update -y && apt-get install -y openssl zip unzip git
COPY installer .
RUN php installer --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_mysql
ENV APP_DIR=/app
WORKDIR $APP_DIR
COPY . $APP_DIR
COPY .env $APP_DIR/.env 
# RUN composer install
RUN composer update
EXPOSE 8181

CMD ["bash", "-c", "php artisan key:generate && php artisan jwt:secret && php artisan migrate && php artisan serve  --host=0.0.0.0 --port=8181"]
