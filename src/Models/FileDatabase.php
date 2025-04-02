<?php

namespace App\Models;

use PDO;
use PDOException;

class FileDatabase implements Database
{
    private $pdo;

    public function __construct($host, $dbname, $username, $password)
    {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function getRecordCompetence($table, $start)
    {
        $sql = "SELECT * FROM $table WHERE competence LIKE :start";
        $requete = $this->pdo->prepare($sql);
        $requete->execute(['start' => $start . '%']);

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function InsertRecordIntoOffre($titre, $entreprise, $competence, $debut, $fin, $remu, $description)
    {
        $sql = "INSERT INTO offre (titre, description, remuneration, date_debut, date_fin, mise_en_ligne, id_entreprise)
                VALUES (:titre, :descr, :remu, :debut, :fin, NOW(), :entreprise)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
        $stmt->bindParam(':descr', $description, PDO::PARAM_STR);
        $stmt->bindParam(':remu', $remu, PDO::PARAM_STR);
        $stmt->bindParam(':debut', $debut, PDO::PARAM_STR);
        $stmt->bindParam(':fin', $fin, PDO::PARAM_STR);
        $stmt->bindParam(':entreprise', $entreprise, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $sql = "SELECT id_offre FROM offre ORDER BY id_offre DESC LIMIT 1";
            $requete = $this->pdo->prepare($sql);
            $requete->execute();
            $result = $requete->fetch();
            $id_offre = $result['id_offre'];

            if (!empty($competence)) {
                foreach ($competence as $competence_id) {
                    $check_sql = "SELECT COUNT(*) FROM competence WHERE id_competence = ?";
                    $check_stmt = $this->pdo->prepare($check_sql);
                    $check_stmt->execute([$competence_id]);

                    if ($check_stmt->fetchColumn() > 0) {
                        $sql_associer = "INSERT INTO associer (id_offre, id_competence) VALUES (:id_offre, :competence)";
                        $stmt_associer = $this->pdo->prepare($sql_associer);
                        $stmt_associer->bindParam(':id_offre', $id_offre, PDO::PARAM_INT);
                        $stmt_associer->bindParam(':competence', $competence_id, PDO::PARAM_INT);
                        $stmt_associer->execute();
                    }
                }
            }
        }
    }

    public function InsertRecordIntoEntreprise($entreprise_titre, $ville, $image, $presentation, $tel, $mail)
    {
        $sql = "INSERT INTO entreprise (nom, description, email_contact, telephone, image_illustration)
                VALUES (:nom, :description, :email_contact, :telephone, :image_illustration)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':nom', $entreprise_titre, PDO::PARAM_STR);
        $stmt->bindParam(':description', $presentation, PDO::PARAM_STR);
        $stmt->bindParam(':email_contact', $mail, PDO::PARAM_STR);
        $stmt->bindParam(':telephone', $tel, PDO::PARAM_STR);
        $stmt->bindParam(':image_illustration', $image, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $sql = "SELECT id_entreprise FROM entreprise ORDER BY id_entreprise DESC LIMIT 1";
            $requete = $this->pdo->prepare($sql);
            $requete->execute();
            $result = $requete->fetch();

            if ($result) {
                $id_entreprise = $result['id_entreprise'];

                if ($ville) {
                    $sql_situ = "INSERT INTO situer (id_ville, id_entreprise) VALUES (:id_ville, :id_entreprise)";
                    $stmt_situ = $this->pdo->prepare($sql_situ);
                    $stmt_situ->bindParam(':id_ville', $ville, PDO::PARAM_INT);
                    $stmt_situ->bindParam(':id_entreprise', $id_entreprise, PDO::PARAM_INT);
                    $stmt_situ->execute();
                }
            }
        }
    }

    public function InsertRecordIntoUtilisateur($nom, $prenom, $email, $password, $role)
    {
        $sql = "INSERT INTO utilisateur (nom_utilisateur, prenom_utilisateur, email, mot_de_passe, id_role)
                VALUES (:nom, :prenom, :email, :pass, :r)";
    
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $password, PDO::PARAM_STR);
        $stmt->bindParam(':r', $role, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
    


    public function getAllRecords($table)
    {
        $sql = $this->pdo->prepare("SELECT * FROM {$table}");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getRecordById($table, $id)
    {
        $sql = $this->pdo->prepare("SELECT * FROM {$table} WHERE id_{$table} = {$id}");
        $sql->execute();
        return $sql->fetch();
    }

    public function getLastRecord($table, $limite, $ordre)
    {
        $sql = $this->pdo->prepare("SELECT * FROM {$table} ORDER BY {$ordre} DESC LIMIT {$limite}");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getRecordBetweenTableOffreEntreprise($table1, $table2)
    {
        $sql = "SELECT offre.id_offre, offre.titre, offre.description, offre.mise_en_ligne, entreprise.nom
                FROM `$table1`
                INNER JOIN `$table2` ON `$table1`.id_{$table2} = `$table2`.id_{$table2}";

        $requete = $this->pdo->prepare($sql);
        $requete->execute();

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecordBetweenTableEntrepriseVille($table1, $relation, $table2, $options = null)
    {
        $sql = "SELECT e.id_entreprise, e.nom, v.nom_ville, e.image_illustration 
                FROM `$table1` e
                INNER JOIN `$relation` s ON e.id_{$table1} = s.id_{$table1}
                INNER JOIN `$table2` v ON s.id_{$table2} = v.id_{$table2}";
        if ($options) {
            $sql .= " WHERE $options";
        }

        $requete = $this->pdo->prepare($sql);
        $requete->execute();

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecordUtilisateur($role)
    { 
            $sql = "SELECT utilisateur.id_utilisateur, utilisateur.nom_utilisateur, utilisateur.prenom_utilisateur, utilisateur.email, role.nom_role 
                    FROM utilisateur
                    INNER JOIN role role ON utilisateur.id_role = role.id_role WHERE nom_role = 'etudiant'";
                    if($role ==='administrateur') {$sql .= "OR nom_role = 'pilote'";}

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRecordInfoOffres($id){
        $sql = "SELECT date_debut, date_fin, offre.description as description_offre, entreprise.description as description_entreprise
                FROM offre
                INNER JOIN entreprise ON offre.id_entreprise = entreprise.id_entreprise
                WHERE id_offre = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getAllCompetencesAssociees($idOffre) {
        $sql = "SELECT competence.id_competence, competence.competence
                FROM associer
                INNER JOIN competence ON associer.id_competence = competence.id_competence
                WHERE associer.id_offre = :idOffre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':idOffre', $idOffre, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }


    
}
