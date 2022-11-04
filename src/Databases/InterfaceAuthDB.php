<?php

namespace App\Databases;

interface InterfaceAuthDB
{
    public function checkAuth($hash);
    public function addAuth($name, $hash);
    public function findUserfromHash($hash);
}
