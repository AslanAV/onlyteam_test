<?php

namespace App\Databases;

interface InterfaceDB
{
    public function query($sql);
    public function insertGetId($dataUser);
    public function create($table);
}
