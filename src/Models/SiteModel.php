<?php

namespace App\Models;

class SiteModel extends Model
{
    public function __construct($connection = null)
    {
        if (is_null($connection)) {
            $this->connection = new FileDatabase('localhost','stageup','romain','@2005Eveal45');
        } else {
            $this->connection = $connection;
        }
    }

    public function getInfos() {
        return $_SESSION['user'];
    }
}
