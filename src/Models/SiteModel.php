<?php

namespace App\Models;

class SiteModel extends Model
{
    public function __construct($connection = null)
    {
        if (is_null($connection)) {
            //$this->connection = new FileDatabase('172.201.220.97','stageup','azureuser','#Cesi2024');
            $this->connection = new FileDatabase('localhost','stageup','root','');
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

    public function getEntrepriseByVille($options = null)
    {
        return $this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville',$options);
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
    public function insertentreprise($entreprise_titre, $ville, $image, $presentation, $tel, $mail)
    {
        $this->connection->InsertRecordIntoEntreprise($entreprise_titre, $ville, $image, $presentation, $tel, $mail);
    }

    public function insertutilisateur($nom, $prenom, $mail, $password, $role)
    {
        $this->connection->InsertRecordIntoUtilisateur($nom, $prenom, $mail, $password, $role);
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

    public function getPageActuelle()
    {
        if (isset($_GET['p'])) {
            return $_GET['p'];
        } else {
            return 1;
        }
    }

    public function getOffreRecherche($page_actuelle)
    {
        $offres = $this->connection->getRecordBetweenTableOffreEntreprise('offre', 'entreprise');
        $output = array_slice($offres, ($page_actuelle - 1) * 5, 5);
        return $output;
    }

    public function getEntreprisesRecherche($page_actuelle)
    {
        $entreprises = $this->connection->getAllRecords('entreprise');
        $output = array_slice($entreprises, ($page_actuelle - 1) * 5, 5);
        return $output;
    }

    public function getVillesEntreprises($page_actuelle)
    {
        $start = (($page_actuelle - 1) * 5) + 1;
        $end = ($page_actuelle * 5);
        $options = "e.id_entreprise BETWEEN $start AND $end";
        return $this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville', $options);
    }

    public function getNbPages()
    {
        return max(count($this->connection->getAllRecords('entreprise')), count($this->connection->getAllRecords('offre')));
    }

    public function getUtilisateurs($role)
    {
        return $this->connection->getRecordUtilisateur($role);
    }

    public function getUtilisateursById($table, $id)
    {
        return $this->connection->getRecordById($table, $id);
    }

    public function UpdateUser($id, $nom, $prenom, $email, $motDePasse, $hidden)
    {
        return $this->connection->updateUtilisateur($id, $nom, $prenom, $email, $motDePasse, $hidden);
    }

    public function UpdateOffre($id, $titre, $description, $remuneration, $date_debut, $date_fin, $id_entreprise, $competences)
    {
        return $this->connection->updateOffre($id, $titre, $description, $remuneration, $date_debut, $date_fin, $id_entreprise, $competences);
    }

    public function getOffreById($id)
    {
        return $this->connection->recupinfoOffre($id);
    }

    public function deleteOffre($id)
    {
        return $this->connection->delOffre($id);
    }

    public function updateEntreprise($id_entreprise, $entreprise_titre, $id_ville, $image, $presentation, $tel, $mail)
    {
        return $this->connection->update_entreprise($id_entreprise, $entreprise_titre, $id_ville, $image, $presentation, $tel, $mail);
    }

    public function deleteEntreprise($id)
    {
        return $this->connection->delEntreprise($id);
    }
}
