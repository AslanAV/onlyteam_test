<?php

namespace App\Model;

class User
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO();
    }

    public function getName()
}
