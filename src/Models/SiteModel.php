<?php

namespace App\Models;

class SiteModel extends Model
{
    public function __construct($connection = null)
    {
        if (is_null($connection)) {
            $this->connection = new FileDatabase('172.201.220.97','stageup','azureuser','#Cesi2024');
            //$this->connection = new FileDatabase('localhost', 'stageup', 'root', '');
        } else {
            $this->connection = $connection;
        }
    }
    /**
     * Obtenir les informations de l'utilisateur connecté
     */
    public function getInfos()
    {
        return $_SESSION['user'];
    }
    /**
     * Obtenir les 8 dernieres offres mises en ligne
     * @return array
     */
    public function getOffresAccueil()
    {
        return $this->connection->getLastRecord('offre', 8, 'mise_en_ligne');
    }
    /**
     * Renvoie toutes les villes
     * @return array
     */
    public function getVille()
    {
        return $this->connection->getAllRecords('ville');
    }
    /**
     * Permet d'ajouter une candidature
     * @param mixed $id_utilisateur
     * @param mixed $id_offre
     * @param mixed $lettre_motivation
     * @param mixed $message_recruteur
     * @return bool|string
     */
    public function ajout_candidater($id_utilisateur, $id_offre, $lettre_motivation, $message_recruteur)
    {
        return $this->connection->addCandidater($id_utilisateur, $id_offre, $lettre_motivation, $message_recruteur);
    }
}
