<?php

use App\Controllers\ProductsController;

$app->get('/', function(){
    echo '<h1>Main page</h1>';
    ?>
    <a href="/api/products">Все товары</a>
    <?php
});

//$app->get('/topics', ProductsController::class . ':index');
//$app->get('/topics/{id}', ProductsController::class . ':show')->setName('topic.show');

$app->group('/api/products', function() {
    $this->get('', ProductsController::class . ':index');
    $this->get('/{id}', ProductsController::class . ':show');
    $this->post('', ProductsController::class . ':create');
    $this->put('/{id}', ProductsController::class . ':update');
    $this->delete('/{id}', ProductsController::class . ':delete');
});
