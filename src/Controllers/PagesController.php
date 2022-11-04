<?php

namespace App\Controllers;

use App\Databases\AuthDB;
use App\Databases\DB;
use function App\Application\Renderer\render;

class PagesController
{
    public static function index()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        return render('index');
    }

    public static function show($user = [])
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!array_key_exists("session", $_SESSION)) {
            header('Location: /login');
            return LoginController::index();
        }


        $hash = $_SESSION['session'];
        $authDB = new AuthDB();
        $isAuth = $authDB->checkAuth($hash);
        if (!$isAuth) {
            header('Location: /login');
            return LoginController::index();
        }

        if ($user === []) {
            $user = $authDB->findUserfromHash($hash);
        }

        if (array_key_exists('password', $user)) {
            unset($user['password']);
        }

        return render('show', ['user'=> $user]);
    }
}

