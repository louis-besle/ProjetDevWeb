<?php

namespace App\Models;

class SearchModel extends Model
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
     * Permet d'obtenir toutes les entreprises
     * @return array
     */
    public function getEntreprise()
    {
        return $this->connection->getAllRecords('entreprise');
    }
    /**
     * Permet d'obtenir toutes les villes
     * @return array
     */
    public function getVille()
    {
        return $this->connection->getAllRecords('ville');
    }
    /**
     * Permet d'obtenir la page actuelle
     * @return int
     */
    public function getPageActuelle()
    {
        if (isset($_GET['p'])) {
            return $_GET['p'];
        } else {
            return 1;
        }
    }
    /**
     * Permet d'obtenir les offres à afficher dans la page de recherche
     * @param mixed $page_actuelle
     * @param mixed $ville
     * @param mixed $entreprise
     * @return array<array|int>
     */
    public function getOffreRecherche($page_actuelle, $ville, $entreprise)
    {
        if ($ville === 'Toutes' && $entreprise === 'Toutes') {
            $offres = $this->connection->getRecordBetweenTableOffreEntreprise('offre', 'entreprise');
            return [array_slice($offres, ($page_actuelle - 1) * 5, 5), count($offres)];
        } else if ($ville === 'Toutes') {
            $options = "e.nom = '$entreprise'";
            $offres = $this->connection->getRecordBetweenTableOffreEntreprise('offre', 'entreprise', $options);
            return [array_slice($offres, ($page_actuelle - 1) * 5, 5), count($offres)];
        } else if ($entreprise === 'Toutes') {
            $options = "v.nom_ville = '$ville'";
            $offres = $this->connection->getRecordBetweenTableOffreEntreprise('offre', 'entreprise', $options);
            return [array_slice($offres, ($page_actuelle - 1) * 5, 5), count($offres)];
        } else {
            $options = "v.nom_ville = '$ville' AND e.nom = '$entreprise'";
            $offres = $this->connection->getRecordBetweenTableOffreEntreprise('offre', 'entreprise', $options);
            return [array_slice($offres, ($page_actuelle -1) * 5, 5), count($offres)];
        }
    }
    /**
     * Permet d'obtenir les villes et entreprises à afficher dans la page de recherche
     * @param mixed $page_actuelle
     * @param mixed $ville
     * @param mixed $entreprise
     * @return array<array|int>
     */
    public function getVillesEntreprises($page_actuelle, $ville, $entreprise)
    {
        $start = (($page_actuelle - 1) * 5) + 1;
        $end = ($page_actuelle * 5);
        $options = "e.id_entreprise BETWEEN $start AND $end";
        if ($ville === 'Toutes' && $entreprise === 'Toutes') {
            return [$this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville', $options), count($this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville'))];
        } else if ($ville === 'Toutes') {
            $options = "e.nom = '$entreprise'";
            return [$this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville', $options), count($this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville', $options))];
        } else if ($entreprise === 'Toutes') {
            $options = "v.nom_ville = '$ville'";
            return [$this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville', $options), count($this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville', $options))];
        } else {
            $options = "v.nom_ville = '$ville' AND e.nom = '$entreprise'";
            return [$this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville', $options), count($this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville', $options))];
        }
    }
    /**
     * Obtenir le nombre de pages
     * @param mixed $val1
     * @param mixed $val2
     */
    public function getNbPages($val1, $val2)
    {
        return max($val1, $val2);
    }
    /**
     * Renvoie le nombre d'offres
     */
    public function nombre_offre()
    {
        return $this->connection->nbr_offre();
    }
    /**
     * Permet d'obtenir les entreprises à afficher dans la page de recherche
     */
    public function getEntrepriseClick()
    {
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
    /**
     * Obtenir les compétences associées à une offre
     * @param mixed $id
     * @return array
     */
    public function getCompetenceByOffer($id)
    {
        $competences = $this->connection->getAllCompetencesAssociees($id);
        if ($competences) {
            return $competences;
        } else {
            return [];
        }
    }
    /**
     * Permet d'obtenir les informations d'une offre
     * @param mixed $id
     * @return array{description_offre: mixed, duree: float, entreprise: array{description: mixed, nom: mixed}}
     */
    public function getInfosOffres($id)
    {
        $offres = $this->connection->getRecordInfoOffres($id);

        if ($offres && isset($offres['date_debut'], $offres['date_fin'])) {
            $dateDebut = new \DateTime($offres['date_debut']);
            $dateFin = new \DateTime($offres['date_fin']);
            $interval = $dateDebut->diff($dateFin);


            $mois = ceil($interval->y * 12 + $interval->m + ($interval->d / 30));

            return ['description_offre' => $offres['description_offre'], 'entreprise' => ['nom' => $offres['nom'], 'description' => $offres['description_entreprise']], 'duree' => $mois];
        }
    }
    /**
     * Permet d'obtenir le nombre de personnes ayant postulé à une offre
     * @param mixed $id_offre
     */
    public function nombre_personne($id_offre)
    {
        return $this->connection->nbr_personne($id_offre);
    }
    /**
     * Permet de savoir si l'utilisateur a déjà postulé à une offre
     * @param mixed $id_utilisateur
     * @param mixed $id_offre
     * @return bool
     */
    public function a_candidater($id_utilisateur, $id_offre)
    {
        return $this->connection->checkCandidature($id_utilisateur, $id_offre);
    }
    /**
     * Permet d'obtenir les informations d'une offre
     * @return array{description_offre: mixed, duree: float, entreprise: array{description: mixed, nom: mixed}}
     */
    public function getOffreClick()
    {
        if (isset($_GET['id'])) {
            $id_page = $_GET['id'];
        } else {
            $id_page = 1;
        }
        return $this->connection->getRecordById('offre', $id_page);
    }
    /**
     * Permet de pouvoir rechercher des offres
     * @param mixed $rechercheGenerale
     * @param mixed $ville
     * @return array
     */
    public function recherche($rechercheGenerale, $ville)
    {
        return $this->connection->rechercherOffres($rechercheGenerale, $ville);
    }
    /**
     * Permet de mettre à jour les offres souhaitees par un utilisateur
     * @param mixed $id_utilisateur
     * @param mixed $id_offre
     * @return bool
     */
    public function ajout_wishlist($id_utilisateur, $id_offre)
    {
        return $this->connection->updateSouhaiter($id_utilisateur, $id_offre);
    }
    /**
     * Renvoie les derniers commentaires ajouter à une entreprise
     * @param mixed $idEntreprise
     * @return array
     */
    public function lastcom($idEntreprise)
    {
        return $this->connection->getDerniersCommentaires($idEntreprise);
    }
    /**
     * Permet d'obtenir la moyenne des notes d'une entreprise
     * @param mixed $idEntreprise
     */
    public function moynote($idEntreprise)
    {
        return $this->connection->getmoynote($idEntreprise);
    }
    /**
     * Permet d'ajouter une note à une entreprise
     * @param mixed $idUtilisateur
     * @param mixed $idEntreprise
     * @param mixed $note
     * @param mixed $commentaire
     * @return bool
     */
    public function noter($idUtilisateur,  $idEntreprise,  $note,  $commentaire)
    {
        return $this->connection->insertNote($idUtilisateur,  $idEntreprise,  $note, $commentaire);
    }
}
