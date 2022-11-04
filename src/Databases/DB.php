<?php

namespace App\Databases;

class DB implements InterfaceDB
{
    private $connection;

    public function __construct($connection = 'nosql')
    {
        $this->connection = new Nosql(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Storage' . DIRECTORY_SEPARATOR . 'db');
    }

    public function insertGetModel($dataUser)
    {
        return $this->connection->insertGetModel($dataUser);
    }

    public function find($login, $password, $table)
    {
        return $this->connection->find($login, $password, $table);
    }

    public function search($key, $value)
    {
        return $this->connection->search($key, $value);
    }
}
