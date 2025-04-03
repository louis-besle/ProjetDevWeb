<?php

namespace App\Models;

class DashboardModel extends Model
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
    public function nombre_utilisateur($role){
        return $this->connection->nbr_utilisateur($role);
    }
    public function getEntrepriseByVille($options = null)
    {
        return $this->connection->getRecordBetweenTableEntrepriseVille('entreprise', 'situer', 'ville',$options);
    }
    public function getCompetence()
    {
        return $this->connection->getAllRecords('competence');
    }
    public function getOffreById($id)
    {
        return $this->connection->recupinfoOffre($id);
    }
    public function deleteOffre($id)
    {
        return $this->connection->delOffre($id);
    }
    public function getNiveau()
    {
        return $this->connection->getRecordCompetence('competence', 'Bac');
    }
    public function all_offre(){
        return $this->connection->getAllRecords('offre');
    }
    public function getUtilisateurs($role)
    {
        return $this->connection->getRecordUtilisateur($role);
    }
    public function getVille()
    {
        return $this->connection->getAllRecords('ville');
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
    public function getUtilisateursById($table, $id)
    {
        return $this->connection->getRecordById($table, $id);
    }
    public function UpdateUser($id, $nom, $prenom, $email, $motDePasse, $hidden = 0)
    {
        return $this->connection->updateUtilisateur($id, $nom, $prenom, $email, $motDePasse, $hidden);
    }
    public function UpdateOffre($id, $titre, $description, $remuneration, $date_debut, $date_fin, $id_entreprise, $competences)
    {
        return $this->connection->updateOffre($id, $titre, $description, $remuneration, $date_debut, $date_fin, $id_entreprise, $competences);
    }
    public function deleteEntreprise($id)
    {
        return $this->connection->delEntreprise($id);
    }
    public function updateentreprise($id_entreprise, $entreprise_titre, $id_ville, $presentation, $tel, $mail, $image){
        return $this->connection->updateEntreprise($id_entreprise, $entreprise_titre, $id_ville, $presentation, $tel, $mail, $image);
    }
    public function getWishlistById($id){
        return $this->connection->getRecordOffresDashboard($id,'souhaiter');
    }
    public function getOffresPostuleesById($id){
        return $this->connection->getRecordOffresDashboard($id,'candidater');
    }
    public function getCVById($id){
        return $this->connection->getCV($id);
    }
}
?>