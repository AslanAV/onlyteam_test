<?php

namespace App\Model;

use App\Databases\DB;
use App\Databases\InterfaceDB;

class User
{
    public function createGetId($dataUser)
    {
        $id = DB::insertGetId($dataUser);
    }
}
