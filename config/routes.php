<?php
$app->get('/(nikname/(?<nikname>\w+))?', function (?string $nickname = null) use ($app) {
    $xCsrf = $app->getResponse()->getHeader('xCsrf');
    $nickname = $nickname?:'Stranger';
    echo <<< HTML
    <html><head><title>Kaspi framework skeleton</title></head>
    <body>
        <p>Hello {$nickname}!</p>
        <ul>
            <li>route with parameter <a href="/nikname/Kaspi"><code>/nikname/</code>kaspi</a>
            <li>clean route <a href="/">root route</a>
        </ul>
        <p>CsrfGuard = {$xCsrf}</p> 
       
    </body>
    </html>
HTML;
});

// Защита POST формы через Csrf - по токену
$app->middleware(Core\Middleware\CsrfGuard::class);
