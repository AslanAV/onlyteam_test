<?php

namespace App\Databases;

class DB
{
    private $connection;

    public function __construct($connection = 'nosql')
    {
//        $map = [
//            'nosql' => new \App\Databases\Nosql(__DIR__ . '/../Storage/db'),
//            'pgsql' => function ()  {
//                return new Pgsql('postgresql://test:test@pgsql:5432/data');
//            },
//        ];
//        $this->$connection = $map[$connection]();
//        var_dump(get_class($this->connection));
//        $this->$connection->create('users');
        $this->connection = new Nosql(__DIR__ . '/../Storage/db');
        $this->connection->create('users');
    }

    public function query(array|string $column, string $table)
    {
        if (is_array($column)) {
            $column = implode(', ', $column);
        }
        $sql = "SELECT {$column} FROM {$table}";

        return $this->connection->query($sql);
    }

    public function insertGetId(array $dataUser)
    {
        return $this->connection->insertGetId($dataUser);
    }
}
