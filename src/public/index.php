<?php

namespace App\Public\Index;

use App\Application\Application;
use App\Controllers\LoginController;
use App\Controllers\PagesController;
use App\Controllers\RegistrationController;
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
    return PagesController::index();
});

$app->get('/show', function () {
    return PagesController::show();
});

$app->get('/login', function () {
    return LoginController::index();
});

$app->post('/login', function () {
    return LoginController::auth($_REQUEST);
});

$app->get('/logout', function () {
    return LoginController::destroy();
});

$app->get('/registration', function () {
    return RegistrationController::index();
});

$app->post('/registration', function () {
    return RegistrationController::registration($_POST);
});

$app->run();
