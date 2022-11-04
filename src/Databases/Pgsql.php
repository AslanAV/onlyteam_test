<?php

namespace App\Databases;

class Pgsql implements InterfaceAuthDB, InterfaceDB
{
    private \PDO $pdo;

    public function __construct($dbUrl)
    {
        $this->pdo = new \PDO($dbUrl);
    }

    public function insertGetModel($dataUser)
    {
        // TODO: Implement insertGetModel() method.
    }

    public function find($login, $password, $table)
    {
        // TODO: Implement find() method.
    }

    public function search($key, $value)
    {
        // TODO: Implement search() method.
    }

    public function checkAuth($hash)
    {
        // TODO: Implement checkAuth() method.
    }

    public function addAuth($name, $hash)
    {
        // TODO: Implement addAuth() method.
    }

    public function findUserfromHash($hash)
    {
        // TODO: Implement findUserfromHash() method.
    }
}
