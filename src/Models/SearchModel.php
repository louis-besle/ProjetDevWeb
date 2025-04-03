<?php

namespace App\Models;

class SearchModel extends Model
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
    public function getEntreprise()
    {
        return $this->connection->getAllRecords('entreprise');
    }
    public function getVille()
    {
        return $this->connection->getAllRecords('ville');
    }
    public function getPageActuelle()
    {
        if (isset($_GET['p'])) {
            return $_GET['p'];
        } else {
            return 1;
        }
    }
    public function getOffreRecherche($page_actuelle,$ville,$entreprise)
    {
        if ($ville === 'Toutes' && $entreprise === 'Toutes') {
            $offres = $this->connection->getRecordBetweenTableOffreEntreprise('offre', 'entreprise');
            return [array_slice($offres, ($page_actuelle - 1) * 5, 5), count($offres)];
        } 
        else if ($ville === 'Toutes') {
            $options = "e.nom = '$entreprise'";
            $offres = $this->connection->getRecordBetweenTableOffreEntreprise('offre', 'entreprise',$options);
            return [array_slice($offres, ($page_actuelle - 1) * 5, 5), count($offres)];
        } 
        else if ($entreprise === 'Toutes') {
            $options = "v.nom_ville = '$ville'";
            $offres = $this->connection->getRecordBetweenTableOffreEntreprise('offre', 'entreprise',$options);
            return [array_slice($offres, ($page_actuelle - 1) * 5, 5), count($offres)];
        }
    }
    public function getVillesEntreprises($page_actuelle,$ville,$entreprise)
    {
        $start = (($page_actuelle - 1) * 5) + 1;
        $end = ($page_actuelle * 5);
        $options = "e.id_entreprise BETWEEN $start AND $end";
        if ($ville === 'Toutes' && $entreprise === 'Toutes') {
            return [$this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville', $options), count($this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville'))];
        } else if ($ville === 'Toutes') {
            $options = "e.nom = '$entreprise'";
            return [$this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville', $options), count($this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville',$options))];
        } else if ($entreprise === 'Toutes') {
            $options = "v.nom_ville = '$ville'";
            return [$this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville', $options), count($this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville',$options))];
        }
    }
    public function getNbPages($val1,$val2)
    {
        return max($val1,$val2);
    }
    public function nombre_offre(){
        return $this->connection->nbr_offre();
    }
    public function getEntrepriseClick(){
        if (isset($_GET['id'])) {
            $id_page = $_GET['id'];
        } else {
            $id_page = 1;
        }
        if (isset($_GET['id_ville'])) {
            $id_ville = $_GET['id_ville'];
        } else {
            $id_ville = 1;
        }
        return $this->connection->getRecordEntrepriseOnClick('entreprise', $id_page, $id_ville);
    }
    public function getCompetenceByOffer($id) {
        $competences = $this->connection->getAllCompetencesAssociees($id);
            if ($competences) {
                return $competences;
            } else {
                return [];
            }
    }
    public function getInfosOffres($id){
        $offres = $this->connection->getRecordInfoOffres($id);

        if ($offres && isset($offres['date_debut'], $offres['date_fin'])) {
            $dateDebut = new \DateTime($offres['date_debut']);
            $dateFin = new \DateTime($offres['date_fin']);
            $interval = $dateDebut->diff($dateFin);


            $mois = ceil($interval->y * 12 + $interval->m + ($interval->d / 30));

            return ['description_offre' => $offres['description_offre'], 'entreprise' => ['nom' => $offres['nom'],'description' => $offres['description_entreprise']], 'duree' => $mois];
        }

    }
    public function nombre_personne($id_offre){
        return $this->connection->nbr_personne($id_offre);
    }
    public function a_candidater($id_utilisateur,$id_offre) {
        return $this->connection->checkCandidature($id_utilisateur,$id_offre);
    }
    public function getOffreClick(){
        if (isset($_GET['id'])) {
            $id_page = $_GET['id'];
        } else {
            $id_page = 1;

        }
        return $this->connection->getRecordById('offre',$id_page);
    }
    public function recherche($rechercheGenerale, $ville){
        return $this->connection->rechercherOffres($rechercheGenerale, $ville);
    }
    public function ajout_wishlist($id_utilisateur,$id_offre) {
        return $this->connection->updateSouhaiter($id_utilisateur,$id_offre);
    }
}
?>