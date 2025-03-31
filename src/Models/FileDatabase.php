<?php

namespace App\Models;

use PDO;
use PDOException;

class FileDatabase implements Database
{
    private $pdo;

    public function __construct($host, $dbname, $username, $password)
    {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function getAllRecords($table) {
        $sql = $this->pdo->prepare("SELECT * FROM {$table}");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getRecordById($table,$id) {
        $sql = $this->pdo->prepare("SELECT * FROM {$table} WHERE id_{$table} = {$id}");
        $sql->execute();
        return $sql->fetch();
    }

    public function getLastRecord($table,$limite,$ordre) {
        $sql = $this->pdo->prepare("SELECT * FROM {$table} ORDER BY {$ordre} DESC LIMIT {$limite}");
        $sql->execute();
        return $sql->fetchAll();
    }

}
