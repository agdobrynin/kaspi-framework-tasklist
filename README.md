# test-mvc

## Установка
git clone https://github.com/agdobrynin/kaspi-framework.git my-project
### установить через composer заисимости
* cd my-project

для разрабоки включая dev зависимости
* composer install --dev

для продакшена
* composer install --no-dev

### настроить параметры окружения в .env: 
* cp .env.dist .env

выставить значения переменных:
* DB_PDO - PDO драйвер
* DB_USER - логин
* DB_PASS - пароль

## Запуск проекта
Локально можно с помощью встроенного web сервера в PHP

php -S 0.0.0.0:8080 -t public/

перейти в браузере на адрес http://localhost:8080/

## Структура фреймворка

````

Folders:
   * cache/                  - для файлов кэширования
   * config/config.php       - конфиг приложения
   * config/dependencies.php - зависимости приложения (контейнеры, бд и т.д.)
   * config/routes.php       - web (http) роутинг
   * Framework/              - ядро
   * logs/                   - для сбора лог файлов
   * public/                 - DOCUMENT_ROOT для web сервера
   * public/index.php        - точка входа в приложение
   * src/App/                - приложение (controllers, entity, middleware и т.д.)
   * store/                  - для хранения чего-либо (например sqLite базы)
   * View/                   - шаблоны (вьюхи)
   * .env                    - наскройки переменных окружения
````
  
###### Код стайл
Для приведения кода к стандартам используем php-cs-fixer который объявлен в dev зависимости composer-а
в корне проекта зарустить

``vendor/bin/php-cs-fixer fix `` 
