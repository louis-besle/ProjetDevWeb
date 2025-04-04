<?php

namespace App\Models;

class DashboardModel extends Model
{
    public function __construct($connection = null)
    {
        if (is_null($connection)) {
            $this->connection = new FileDatabase('172.201.220.97', 'stageup', 'azureuser', '#Cesi2024');
            //$this->connection = new FileDatabase('localhost','stageup','root','');
        } else {
            $this->connection = $connection;
        }
    }
    /**
     * Renvoie le nombre d'utilisateurs en fonction de leur rôle.
     * @param mixed $role
     */
    public function nombre_utilisateur($role)
    {
        return $this->connection->nbr_utilisateur($role);
    }
    /**
     * Renvoie les entreprises et leur ville.
     * @param mixed $options
     * @return array
     */
    public function getEntrepriseByVille($options = null)
    {
        return $this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville', $options);
    }
    /**
     * Renvoie toutes les compétences.
     * @return array
     */
    public function getCompetence()
    {
        return $this->connection->getAllRecords('competence');
    }
    /**
     * Renvoie les informations sur l'offre de stage en fonction de son ID.
     * @param mixed $id
     * @return array[]|array{cacher_offre: mixed, competences: array, date_debut: mixed, date_fin: mixed, description_offre: mixed, entreprise: array{id_entreprise: mixed, nom_entreprise: mixed, ville: mixed, id_offre: mixed, mise_en_ligne: mixed, remuneration: mixed, titre_offre: mixed}|null}
     */
    public function getOffreById($id)
    {
        return $this->connection->recupinfoOffre($id);
    }
    /**
     * Permet de supprimer une offre de stage en fonction de son ID.
     * @param mixed $id
     * @return bool
     */
    public function deleteOffre($id)
    {
        return $this->connection->delOffre($id);
    }
    /**
     * Renvoie le niveau d'étude.
     * @return array
     */
    public function getNiveau()
    {
        return $this->connection->getRecordCompetence('competence', 'Bac');
    }
    /**
     * Renvoie toutes les offres de stage.
     * @return array
     */
    public function all_offre()
    {
        return $this->connection->getAllRecords('offre');
    }
    /**
     * Renvoie les utilisateurs en fonction de leur rôle.
     * @param mixed $role
     * @return array
     */
    public function getUtilisateurs($role)
    {
        return $this->connection->getRecordUtilisateur($role);
    }
    /**
     * Renvoie toutes les villes.
     * @return array
     */
    public function getVille()
    {
        return $this->connection->getAllRecords('ville');
    }
    /**
     * Permet d'inserer une offre de stage dans la base de données.
     * @param mixed $offer_title
     * @param mixed $entreprise
     * @param mixed $data
     * @param mixed $start
     * @param mixed $end
     * @param mixed $remuneration
     * @param mixed $job_description
     * @return void
     */
    public function insertoffer($offer_title, $entreprise, $data, $start, $end, $remuneration, $job_description)
    {
        $this->connection->InsertRecordIntoOffre($offer_title, $entreprise, $data, $start, $end, $remuneration, $job_description);
    }
    /**
     * Permet d'insérer une entreprise dans la base de données.
     * @param mixed $entreprise_titre
     * @param mixed $ville
     * @param mixed $image
     * @param mixed $presentation
     * @param mixed $tel
     * @param mixed $mail
     * @return void
     */
    public function insertentreprise($entreprise_titre, $ville, $image, $presentation, $tel, $mail)
    {
        $this->connection->InsertRecordIntoEntreprise($entreprise_titre, $ville, $image, $presentation, $tel, $mail);
    }
    /**
     * Permet d'inserer un utilisateur dans la base de données.
     * @param mixed $nom
     * @param mixed $prenom
     * @param mixed $mail
     * @param mixed $password
     * @param mixed $role
     * @return void
     */
    public function insertutilisateur($nom, $prenom, $mail, $password, $role)
    {
        $this->connection->InsertRecordIntoUtilisateur($nom, $prenom, $mail, $password, $role);
    }
    /**
     * Permet d'obtenir les informations d'un utilisateur en fonction de son ID.
     * @param mixed $table
     * @param mixed $id
     */
    public function getUtilisateursById($table, $id)
    {
        return $this->connection->getRecordById($table, $id);
    }
    /**
     * Permet de mettre à jour les informations d'un utilisateur.
     * @param mixed $id
     * @param mixed $nom
     * @param mixed $prenom
     * @param mixed $email
     * @param mixed $motDePasse
     * @param mixed $hidden
     * @return bool
     */
    public function UpdateUser($id, $nom, $prenom, $email, $motDePasse, $hidden = 0)
    {
        return $this->connection->updateUtilisateur($id, $nom, $prenom, $email, $motDePasse, $hidden);
    }
    /**
     * Permet de mettre à jour une offre de stage.
     * @param mixed $id
     * @param mixed $titre
     * @param mixed $description
     * @param mixed $remuneration
     * @param mixed $date_debut
     * @param mixed $date_fin
     * @param mixed $id_entreprise
     * @param mixed $competences
     * @return bool
     */
    public function UpdateOffre($id, $titre, $description, $remuneration, $date_debut, $date_fin, $id_entreprise, $competences)
    {
        return $this->connection->updateOffre($id, $titre, $description, $remuneration, $date_debut, $date_fin, $id_entreprise, $competences);
    }
    /**
     * Permet de supprimer une entreprise en fonction de son ID.
     * @param mixed $id
     * @return bool
     */
    public function deleteEntreprise($id)
    {
        return $this->connection->delEntreprise($id);
    }
    /**
     * Permet de mettre à jour les informations d'une entreprise.
     * @param mixed $id_entreprise
     * @param mixed $entreprise_titre
     * @param mixed $id_ville
     * @param mixed $presentation
     * @param mixed $tel
     * @param mixed $mail
     * @param mixed $image
     */
    public function updateentreprise($id_entreprise, $entreprise_titre, $id_ville, $presentation, $tel, $mail, $image)
    {
        return $this->connection->updateEntreprise($id_entreprise, $entreprise_titre, $id_ville, $presentation, $tel, $mail, $image);
    }
    /**
     * Permet d'obtenir les offres souhaitées par un utilisateur en fonction de son ID.
     * @param mixed $id
     * @return array
     */
    public function getWishlistById($id)
    {
        return $this->connection->getRecordOffresDashboard($id, 'souhaiter');
    }
    /**
     * Permet d'obtenir les offres postulées par un utilisateur en fonction de son ID.
     * @param mixed $id
     * @return array
     */
    public function getOffresPostuleesById($id)
    {
        return $this->connection->getRecordOffresDashboard($id, 'candidater');
    }
    /**
     * Permet d'obtenir les CV d'un utilisateur en fonction de son ID.
     * @param mixed $id
     * @return array
     */
    public function getCVById($id)
    {
        return $this->connection->getCV($id);
    }
}
