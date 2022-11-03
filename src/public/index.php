<?php

namespace App\Public\Index;

use App\Application\Application;
use App\Controllers\LoginController;
use App\Controllers\MainPageController;
use http\Env\Request;
use function App\Application\Renderer\render;

$autoloadPath1 = __DIR__ . '/../../autoload.php';
$autoloadPath2 = __DIR__ . '/../../vendor/autoload.php';

if (file_exists($autoloadPath1)) {
    require_once $autoloadPath1;
} else {
    require_once $autoloadPath2;
}

$app = new Application();

$app->get('/', function () {
    return MainPageController::index();
});

$app->get('/login', function () {
    return LoginController::index();
});

$app->post('/login', function () {
    return LoginController::auth($_REQUEST);
});

$app->run();
