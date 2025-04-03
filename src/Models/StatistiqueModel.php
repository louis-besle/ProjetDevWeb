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
    /**
     * Obtenir les statistiques d'un utilisateur
     * @param mixed $id_etudiant
     * @return array
     */
    public function statistique_utilisateur($id_etudiant){
        return $this->connection->statistique($id_etudiant);
    }
    /**
     * Obtenir les compétences présentent dans les offres
     * @return array
     */
    public function rep_competence(){
        return $this->connection->repartitionParCompetence();
    }
    /**
     * Repartition des offres par durée
     * @return array
     */
    public function rep_duree(){
        return $this->connection->repartitionParDuree();
    }
    /**
     * Obtenir les offres souhaitées le plus par les utilisateurs
     * @return array
     */
    public function rep_wishlist(){
        return $this->connection->topOffresWishlist();
    }
    /**
     * Obtenir le nombre d'offres
     */
    public function nombre_offre(){
        return $this->connection->nbr_offre();
    }
    /**
     * Obtenir le nombre d'entreprises par ville
     * @return array
     */
    public function entrepriseVille(){
        return $this->connection->nombreEntreprisesParVille();
    }
    /**
     * Obtenir le nombre total d'entreprises
     * @return int
     */
    public function entreprisetotal(){
        return $this->connection->nombreEntreprises();
    }
    /**
     * Statistique des entreprises
     * @return array
     */
    public function entreprise(){
        return $this->connection->getRecordEntreprise();
    }
}
?>