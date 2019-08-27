<?php

// контейнеры и зависимости для приложения переменная $container определеная файле public/index.php
// Контейнер view
$container->set('view', static function () use ($config): \Core\View {
    return new Core\View($config);
});
