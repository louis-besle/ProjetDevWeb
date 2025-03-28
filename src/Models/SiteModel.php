<?php

namespace App\Models;

class SiteModel extends Model
{
    public function __construct($connection = null)
    {
        if (is_null($connection)) {
            $this->connection = new FileDatabase('localhost','stageup','root','');
        } else {
            $this->connection = $connection;
        }
    }

    public function getInfos() {
        return $_SESSION['user'];
    }

    public function getEntreprise() {
        return $this->connection->getAllRecords('entreprises');
    }
    public function getVille() {
        return $this->connection->getAllRecords('ville');
    }
}
