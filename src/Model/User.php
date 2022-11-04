<?php

namespace App\Model;

use App\Databases\DB;
use App\Databases\InterfaceAuthDB;

class User
{
    public function insertGetModel($dataUser)
    {
        $db = new DB();
        return $db->insertGetModel($dataUser);
    }
}
