<?php

use Slim\App;

$app = new App([
    'settings' => [
        'displayErrorDetails' => true,
    ]
]);

$container = $app->getContainer();

require __DIR__ . '/../routes/web.php';
require __DIR__ . '/../routes/api.php';
