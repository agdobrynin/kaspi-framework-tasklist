<?php

require_once __DIR__.'/../vendor/autoload.php';

$dotEnvFile = __DIR__.'/../.env';
if (is_file($dotEnvFile)) {
    $dotenv = new Symfony\Component\Dotenv\Dotenv();
    $dotenv->load(__DIR__.'/../.env');
}

// Загрузка конфигурации
$config = new Core\Config(require __DIR__.'/../config/config.php');

// Контейнеры
$container = new Core\Container();

$app = new Core\App($config, new Core\Request(), new Core\Response(), $container);
// Глобальные функции хэплеры
require_once __DIR__.'/../Framework/helpers.php';
// Установка локали
$app->setLocale();
// Установка таймзоны приложения
$app->setTimeZone();

// подключаемые зависимости приложения - контейнеры, базы данных и т.п.
$app_containers = __DIR__.'/../config/dependencies.php';
if (is_file($app_containers)) {
    require_once $app_containers;
}

// WEB роуты
$webRoutes = __DIR__ . '/../config/routes.php';
// Проверка на существоание роутов приложения
if (!is_file($webRoutes)) {
    require_once __DIR__.'/../Framework/routes_default.php';
} else {
    require_once __DIR__ . '/../config/routes.php';
}

session_start();
$app->run();
