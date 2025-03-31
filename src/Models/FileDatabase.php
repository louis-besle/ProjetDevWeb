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
        $sql = $this->pdo->query("SELECT * FROM {$table}");
        return $sql->fetchAll();
    }

    public function getRecordById($table,$id) {
        $sql = $this->pdo->query("SELECT * FROM {$table} WHERE id_{$table} = {$id}");
        return $sql->fetch();
    }

    public function getRecordBetween2Table($table1,$relation,$table2){
        $sql = $this->pdo->query("SELECT * FROM {$table1} inner join {$relation} on {$table1}.id_{$table1} = {$relation}.id_{$table1} INNER JOIN {$table2} on {$relation}.id_{$table2} = {$table2}.id_{$table2}");
        return $sql->fetch();
    }

}
