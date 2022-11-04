<?php

namespace App\Databases;

class Nosql implements InterfaceAuthDB, InterfaceDB
{
    private string $dbUrl;

    public function __construct(string $dbUrl)
    {
        $this->dbUrl = $dbUrl;
    }

    public function insertGetModel($dataUser)
    {
        ['name' => $name,'number' => $number, 'email' => $email, 'password' => $password] = $dataUser;
        $db = $this->getDb();
        $db['users'][] = ['name' => $name, 'number' => $number, 'email' => $email, 'password' => $password, 'created_at' => date("Y-m-d H:i:s")];
        $lastUser = count($db['users']) - 1;

        $this->putDb($db);
        return $db['users'][$lastUser];
    }

    public function find($login, $password, $table)
    {
        $db = $this->getDb();
        $preparePassword = hash('md5', $password);
        foreach ($db[$table] as $user) {
            if (in_array($login, $user, true) && in_array($preparePassword, $user, true)) {
                return $user;
            }
        }
        return null;
    }

    private function getDb()
    {
        $content = file_get_contents($this->dbUrl);
        return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
    }

    private function putDb($db)
    {
        $content = json_encode($db, JSON_THROW_ON_ERROR);
        file_put_contents($this->dbUrl, $content);
    }

    public function search($key, $value)
    {
        $db = $this->getDb();
        if (str_contains('password', $key)) {
            $prepareValue = hash('md5', $value);
        } else {
            $prepareValue = $value;
        }
        foreach ($db['users'] as $user) {
            if (array_key_exists($key, $user) && $user[$key] === $prepareValue) {
                return $user;
            }
        }
        return null;
    }

    public function checkAuth($hash)
    {
        $db = $this->getDb();
        if (!array_key_exists('auth', $db)) {
            $db['auth'][] = ['hash' => null];
        }
        foreach ($db['auth'] as $item) {
            if ($item['hash'] === $hash) {
                return true;
            }
        }
        return false;
    }

    public function addAuth($name, $hash)
    {
        $db = $this->getDb();
        if (!array_key_exists('auth', $db)) {
            $db['auth'][] = ['hash' => null];
        }
        $db['auth'][$name] = ['hash' => $hash];

        $this->putDb($db);
    }

    public function findUserfromHash($hash)
    {
        $db = $this->getDb();
        if (!array_key_exists('auth', $db)) {
            $db['auth'][] = ['hash' => null];
        }
        $name = '';
        foreach ($db['auth'] as $key => $item) {
            if ($item['hash'] === $hash) {
                $name = $key;
            }
        }
        foreach ($db['users'] as $item) {
            if ($item['name'] === $name) {
                return $item;
            }
        }
        return [];
    }
}
