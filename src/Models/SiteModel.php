<?php

namespace App\Models;

class SiteModel extends Model
{
    public function __construct($connection = null)
    {
        if (is_null($connection)) {
            $this->connection = new FileDatabase('localhost', 'stageup', 'root', '');
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
}
