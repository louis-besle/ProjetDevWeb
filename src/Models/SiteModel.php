<?php

namespace App\Models;

class SiteModel extends Model
{
    public function __construct($connection = null)
    {
        if (is_null($connection)) {
            $this->connection = new FileDatabase('127.0.0.1','dev-web','root','nouveaumdp');
        } else {
            $this->connection = $connection;
        }
    }

    public function getInfos()
    {
        return $_SESSION['user'];
    }

    public function getEntreprise()
    {
        return $this->connection->getAllRecords('entreprise');
    }
    public function getVille()
    {
        return $this->connection->getAllRecords('ville');
    }

    public function getEntrepriseByVille()
    {
        return $this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville');
    }

    public function getCompetence()
    {
        return $this->connection->getAllRecords('competence');
    }
    public function getNiveau()
    {
        return $this->connection->getRecordCompetence('competence', 'Bac');
    }

        public function insertoffer($offer_title, $entreprise, $data, $start, $end, $remuneration, $job_description)
        {
            $this->connection->InsertRecordIntoOffre($offer_title, $entreprise, $data, $start, $end, $remuneration, $job_description);
        }
    public function getOffresAccueil() {
        return $this->connection->getLastRecord('offre',8,'mise_en_ligne');
    }

    public function getEntreprisesAccueil($offres) {
        $entreprises = [];
        foreach ($offres as $row) {
            $entreprises = $this->connection->getRecordById('entreprise',$row['id_entreprise']);
        }
        return $entreprises;
    }

    public function getPageActuelle(){
        if (isset($_GET['p'])) {
            return $_GET['p'];
        } else {
            return 1;
        }
    }

    public function getOffreRecherche($page_actuelle) {        
        $offres = $this->connection->getRecordBetweenTableOffreEntreprise('offre', 'entreprise');
        $output = array_slice($offres, ($page_actuelle - 1)*5, 5);
        return $output;
    }

    public function getEntreprisesRecherche($page_actuelle) {
        $entreprises = $this->connection->getAllRecords('entreprise');
        $output = array_slice($entreprises, ($page_actuelle - 1)*5, 5);
        return $output;
    }

    public function getVillesEntreprises($page_actuelle) {
        $start = (($page_actuelle - 1) * 5) + 1;
        $end = ($page_actuelle * 5);
        $options = "e.id_entreprise BETWEEN $start AND $end";
        return $this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville', $options);
    }

    public function getNbPages(){
        return max(count($this->connection->getAllRecords('entreprise')), count($this->connection->getAllRecords('offre')));
    }
}
