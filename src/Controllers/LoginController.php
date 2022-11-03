<?php

namespace App\Controllers;

use App\Databases\DB;
use http\Env\Request;
use function App\Application\Renderer\render;

class LoginController
{
    public static function index()
    {
        return render('login');
    }

    public static function auth($request)
    {
        $db = new DB();

        var_dump($request);
        ['login' => $login, 'password' => $password] = $request;

        if (str_contains($login, '@')) {
            $result = $db->query(['email', 'password'], 'users');
        } else {
            $result = $db->query(['phone', 'password'], 'users');
        }

        $result = $db->query(['', $password], 'users');
        var_dump($result);
        return '';
    }
}
