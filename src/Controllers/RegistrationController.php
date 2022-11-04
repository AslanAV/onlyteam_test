<?php

namespace App\Controllers;

use App\Databases\AuthDB;
use App\Model\User;
use App\Validator\Validator;
use function App\Application\Renderer\render;

class RegistrationController
{
    public static function registration($post)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        [
            'name' => $name,
            'number' => $number,
            'email' => $email,
            'password' => $password,
            'password_duplicate' => $password_duplicate
        ] = $post;


        $validator = new Validator();
        $validator->setRules([
            'name' => 'require|unique',
            'number' => 'require|unique',
            'email' => 'require|unique',
            'password' => 'require|match:password_duplicate',
            'password_duplicate' => 'require'
        ]);

        $errors = $validator->validate($post);
        if ($errors !== []) {
            $data = ['name' => $name, 'number' => $number, 'email' => $email, 'error' => $errors];
            return RegistrationController::index($data);
        }

        $userModel = new User();
        $user = $userModel->insertGetModel(['name' => $name, 'number' => $number, 'email' => $email, 'password' => $password,]);
        $hash = hash('md5', $user['name']);

        $_SESSION['session'] = $hash;
        $authDB = new AuthDB();
        $authDB->addAuth($user['name'], $hash);
        return PagesController::show($user);
    }

    public static function index($data = [])
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        return render('register', ['data' => $data]);
    }
}
