<?php

namespace App\Databases;

class Pgsql implements InterfaceDB
{
    private \PDO $pdo;

    public function __construct($dbUrl)
    {
        $this->pdo = new \PDO($dbUrl);
    }

    public function query($sql)
    {
        return $this->pdo->query($sql);
    }

    public function insertGetId($dataUser)
    {
        [$name, $number, $email, $password] = $dataUser;
        $stmt = $this->pdo->prepare("INSERT INTO 'users' (ID, NAME, NUMBER, EMAIL, PASSWORD) VALUES ($name, $number, $email, $password)");
        $stmt->execute();
        return $this->pdo->lastInsertId();

    }

    public function create($table)
    {
        $sql = "CREATE DATABASE only";
        $this->pdo->exec($sql);

        $tableSql = "CREATE TABLE Users (id INTEGER AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255), number VARCHAR(255) UNIQUE, email EMAIL UNIQUE, PASSWORD VARCHAR(255), created_at TIMESTAMP)";
        $this->pdo->exec($tableSql);
    }
}
