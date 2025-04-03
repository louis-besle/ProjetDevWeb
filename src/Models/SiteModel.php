<?php

namespace App\Models;

class SiteModel extends Model
{
    public function __construct($connection = null)
    {
        if (is_null($connection)) {
            $this->connection = new FileDatabase('172.201.220.97','stageup','azureuser','#Cesi2024');
            //$this->connection = new FileDatabase('localhost','stageup','root','');
        } else {
            $this->connection = $connection;
        }
    }

    public function getInfos()
    {
        return $_SESSION['user'];
    }

    

    
    

    
    

    public function getOffresAccueil()
    {
        return $this->connection->getLastRecord('offre', 8, 'mise_en_ligne');
    }

    public function getEntreprisesAccueil($offres)
    {
        $entreprises = [];
        foreach ($offres as $row) {
            $entreprises = $this->connection->getRecordById('entreprise', $row['id_entreprise']);
        }
        return $entreprises;
    }

    

    

    

    

    

    

    

    

    

    
    

    public function getVille()
    {
        return $this->connection->getAllRecords('ville');
    }

    

    

    

    
    
    

    

    

    

    
    

    

    

    

    public function ajout_candidater($id_utilisateur,$id_offre,$lettre_motivation,$message_recruteur) {
        return $this->connection->addCandidater($id_utilisateur,$id_offre,$lettre_motivation,$message_recruteur);
    }

    
}

