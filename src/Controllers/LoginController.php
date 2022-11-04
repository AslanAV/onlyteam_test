<?php

namespace App\Controllers;

use App\Databases\AuthDB;
use App\Databases\DB;
use function App\Application\Renderer\render;

class LoginController
{
    public static function index()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        return render('login');
    }

    public static function auth($request)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $db = new DB();

        ['login' => $login, 'password' => $password] = $request;

        $user = $db->find($login, $password, 'users');
        if ($user) {
            $hash = hash('md5', $user['name']);
            $_SESSION['session'] = $hash;
            $authDB = new AuthDB();
            $authDB->addAuth($user['name'], $hash);
            return PagesController::show($user);
        }
        $message = 'Invalid login information. Please try again!';
        return render('login', ['message' => $message, 'login' => $login]);
    }

    public static function destroy()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (array_key_exists('session', $_SESSION)) {
            unset($_SESSION['session']);
        }
        session_destroy();
        return PagesController::index();

    }
}
