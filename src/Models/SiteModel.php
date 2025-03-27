<?php

namespace App\Models;

class SiteModel extends Model
{
    public function __construct($connection = null)
    {
        if (is_null($connection)) {
            $this->connection = new FileDatabase('localhost', 'bddprosit7', 'root', '');
        } else {
            $this->connection = $connection;
        }
    }

}
