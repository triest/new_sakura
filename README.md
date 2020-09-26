апуск

Установить node;

    npm install;

Скомпилировать

    npm run watch
    
Установить компосер

    php composer.phar install    

Запуск приложения cd laradock

    docker-compose up -d nginx mysql workspace phpmyadmin

http://localhost/

PhpMyAdmin
http://127.0.0.1:8081/index.php

Сервер: mysql Пользователь: default Пароль: secret

Запуск контейнера с башем

    docker-compose exec workspace bash

Запуск миграций

    php artisan migrate

Устоновать composer в контейнер 

composer install

