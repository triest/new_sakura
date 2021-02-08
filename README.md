апуск

Установить node;

    npm install;


Установить компосер

    php composer.phar install    

Запуск приложения cd laradock

    docker-compose up -d nginx mysql workspace phpmyadmin

http://localhost/

PhpMyAdmin
composer require backpack/langfilemanager


Сервер: mysql Пользователь: default Пароль: secret

Запуск контейнера с башем

    docker-compose exec workspace bash

Запуск миграций

    php artisan migrate

Устоновать composer в контейнер 

composer install

Запуск сидера
composer dump-autoload
php artisan db:seed


Скомпилировать

    npm install

    npm run watch
    
Запуск очередей: 
php artisan queue:work 
