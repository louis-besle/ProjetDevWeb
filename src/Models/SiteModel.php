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

    public function getNbPages($val1,$val2)
    {
        return max($val1,$val2);
    }

    public function getUtilisateurs($role)
    {
        return $this->connection->getRecordUtilisateur($role);
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

    public function getOffreById($id)
    {
        return $this->connection->recupinfoOffre($id);
    }

    public function deleteOffre($id)
    {
        return $this->connection->delOffre($id);
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
    public function getOffreClick(){
        if (isset($_GET['id'])) {
            $id_page = $_GET['id'];
        } else {
            $id_page = 1;

        }
        return $this->connection->getRecordById('offre',$id_page);
    }

    public function deleteEntreprise($id)
    {
        return $this->connection->delEntreprise($id);
    }

    public function updateentreprise($id_entreprise, $entreprise_titre, $id_ville, $presentation, $tel, $mail, $image){
        return $this->connection->updateEntreprise($id_entreprise, $entreprise_titre, $id_ville, $presentation, $tel, $mail, $image);
    }

    public function recherche($rechercheGenerale, $ville){
        return $this->connection->rechercherOffres($rechercheGenerale, $ville);
    }

    public function nombre_offre(){
        return $this->connection->nbr_offre();
    }

    public function nombre_personne($id_offre){
        return $this->connection->nbr_personne($id_offre);
    }
    public function nombre_utilisateur($role){
        return $this->connection->nbr_utilisateur($role);
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

    public function all_offre(){
        return $this->connection->getAllRecords('offre');
    }

    public function entrepriseVille(){
        return $this->connection->nombreEntreprisesParVille();
    }
    public function entreprisetotal(){
        return $this->connection->nombreEntreprises();
    }

    public function entreprise(){
        return $this->connection->getRecordEntreprise();
    public function getWishlistById($id){
        return $this->connection->getRecordOffresDashboard($id,'souhaiter');
    }

    public function getOffresPostuleesById($id){
        return $this->connection->getRecordOffresDashboard($id,'candidater');
    }

    public function getCVById($id){
        return $this->connection->getCV($id);
    }

    public function ajout_wishlist($id_utilisateur,$id_offre) {
        return $this->connection->updateSouhaiter($id_utilisateur,$id_offre);
    }

    public function ajout_candidater($id_utilisateur,$id_offre,$lettre_motivation,$message_recruteur) {
        return $this->connection->addCandidater($id_utilisateur,$id_offre,$lettre_motivation,$message_recruteur);
    }

    public function a_candidater($id_utilisateur,$id_offre) {
        return $this->connection->checkCandidature($id_utilisateur,$id_offre);
    }
}

