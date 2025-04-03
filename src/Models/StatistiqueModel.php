<?php

namespace App\Models;

class StatistiqueModel extends Model
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
    public function statistique_utilisateur($id_etudiant){
        return $this->connection->statistique($id_etudiant);
    }
    public function rep_competence(){
        return $this->connection->repartitionParCompetence();
    }
    public function rep_duree(){
        return $this->connection->repartitionParDuree();
    }
    public function rep_wishlist(){
        return $this->connection->topOffresWishlist();
    }
    public function nombre_offre(){
        return $this->connection->nbr_offre();
    }
    public function entrepriseVille(){
        return $this->connection->nombreEntreprisesParVille();
    }
    public function entreprisetotal(){
        return $this->connection->nombreEntreprises();
    }
    public function entreprise(){
        return $this->connection->getRecordEntreprise();
    }
}
?>