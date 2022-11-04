<?php

namespace App\Databases;

class AuthDB implements InterfaceAuthDB
{
    private $connection;

    public function __construct($connection = 'nosql')
    {
        $this->connection = new Nosql(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Storage' . DIRECTORY_SEPARATOR . 'db');
    }

    public function checkAuth($hash)
    {
        return $this->connection->checkAuth($hash);
    }
    public function addAuth($name, $hash)
    {
        $this->connection->addAuth($name, $hash);
    }

    public function findUserfromHash($hash)
    {
        return $this->connection->findUserfromHash($hash);
    }

}
