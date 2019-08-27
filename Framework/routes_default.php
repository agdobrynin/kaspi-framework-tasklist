<?php

$app->get('/', static function () {
    $today = (new DateTime())->format('l jS \of F Y h:i:s A');
    echo <<< HTML
<html>
    <head><title>Hellow World ;)</title></head>
    <body>
        <h1>Hello World</h1>
        <p>Today {$today}</p>
    </body>
</html>
HTML;
});
