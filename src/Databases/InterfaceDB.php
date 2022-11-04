<?php

namespace App\Databases;

interface InterfaceDB
{
    public function insertGetModel($dataUser);
    public function find($login, $password, $table);
    public function search($key, $value);
}
