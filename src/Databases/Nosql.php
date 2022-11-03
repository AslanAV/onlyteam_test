<?php

namespace App\Databases;

class Nosql implements InterfaceDB
{
    private array $db;

    public function __construct(string $dbUrl)
    {
        $content = file_get_contents($dbUrl);
        $this->db = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
    }

    public function query($sql)
    {
        $content = $this->prepareSql($sql);
        ['contentsName' => $contentsName, 'tableName' => $tableName]= $content;

        if (count($contentsName) === 1 && in_array('*', $contentsName, true)) {
            return $this->db[$tableName];
        }

        return array_filter($this->db[$tableName], function ($column) use ($contentsName) {
            return in_array($column, $contentsName, true);
        });
    }

    private function prepareSql($sql)
    {
        $content = explode(' ', $sql);
        $len = count($content);
        $tableName = $content[$len - 1];

        $eraseContent = ['SELECT', 'FROM', $tableName];

        $contentsMap = array_map(fn ($name) => trim($name, ','), $content);
        $contentsName = array_filter($contentsMap, fn ($name) => !in_array($name, $eraseContent, true));

        $result = ['tableName' => $tableName, 'contentsName' => $contentsName];
        return ['tableName' => $tableName, 'contentsName' => $contentsName];
    }

    public function create($table)
    {
        $this->db = [$table => ['name' => '', 'number' => '', 'email' => '', 'password' => '', 'created_at' => '']];
    }

    public function insertGetId($dataUser)
    {
        [$name, $number, $email, $password] = $dataUser;
        $this->db['users'][] = [$name, $number, $email, $password, date("Y-m-d H:i:s")];

        return count($this->db['users']);
    }
}
