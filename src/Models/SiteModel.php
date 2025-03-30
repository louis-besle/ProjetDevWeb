<?php

namespace App\Models;

class SiteModel extends Model
{
    public function __construct($connection = null)
    {
        if (is_null($connection)) {
            $this->connection = new FileDatabase('172.201.220.97','stageup','azureuser','#Cesi2024');
        } else {
            $this->connection = $connection;
        }
    }

    public function getInfos() {
        return $_SESSION['user'];
    }

    public function getOffresAccueil() {
        return $this->connection->getLastRecord('Offres',8,'date_debut');
    }

    public function getEntreprises($offres) {
        $entreprises = [];
        foreach ($offres as $row) {
            $entreprises = $this->connection->getRecordById('Entreprises',$row['id_entreprises']);
        }
        return $entreprises;
    }
}
