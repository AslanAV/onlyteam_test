<?php

namespace App\Controllers;

use App\Databases\DB;
use function App\Application\Renderer\render;

class MainPageController
{
    public static function index()
    {
        $users = new DB();
        $user = $users->query('name', 'users');
//        $user = [1,1,1,1, 2,2,2,2];
        return render('index', ['user' => $user]);
    }
}
