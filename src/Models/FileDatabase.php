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
                INNER JOIN `$table2` ON `$table1`.id_{$table2} = `$table2`.id_{$table2} WHERE cacher_offre = 0";

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
        INNER JOIN role ON utilisateur.id_role = role.id_role 
        WHERE utilisateur.cacher_utilisateur = 0 AND (role.nom_role = 'etudiant'";

        if ($role === 'administrateur') {
            $sql .= " OR role.nom_role = 'pilote'";
        }

        $sql .= ")";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUtilisateur($id, $nom, $prenom, $email, $motDePasse, $hidden)
    {
        $sql = "UPDATE utilisateur 
                SET nom_utilisateur = :nom, 
                    prenom_utilisateur = :prenom, 
                    email = :email, 
                    mot_de_passe = :pass,
                    cacher_utilisateur = :cacher_utilisateur
                WHERE id_utilisateur = :id";

        $requete = $this->pdo->prepare($sql);
        return $requete->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':pass' => $motDePasse,
            ':cacher_utilisateur' => $hidden,
            ':id' => $id
        ]);
    }

    public function updateOffre($id, $titre, $description, $remuneration, $date_debut, $date_fin, $id_entreprise, $competences)
    {
        $sql = "UPDATE offre SET titre = ?, description = ?, remuneration = ?, date_debut = ?, date_fin = ?, mise_en_ligne = NOW(), id_entreprise = ? WHERE id_offre = ?";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([$titre, $description, $remuneration, $date_debut, $date_fin, $id_entreprise, $id]);

        if ($result) {
            // Suppression des anciennes compétences associées à l'offre
            $deleteSql = "DELETE FROM associer WHERE id_offre = ?";
            $deleteStmt = $this->pdo->prepare($deleteSql);
            $deleteStmt->execute([$id]);

            // Ajout des nouvelles compétences (avec vérification des valeurs)
            $insertSql = "INSERT INTO associer (id_offre, id_competence) VALUES (?, ?)";
            $insertStmt = $this->pdo->prepare($insertSql);
            foreach ($competences as $competence) {
                if (!empty($competence) && is_numeric($competence)) {
                    $insertStmt->execute([$id, $competence]);
                }
            }
        }

        return $result;
    }

    public function recupinfoOffre($id)
    {
        $sql = "SELECT DISTINCT
            e.id_entreprise,
            e.nom AS nom_entreprise,
            o.id_offre,
            o.titre AS titre_offre,
            o.description AS description_offre,
            o.remuneration,
            o.date_debut,
            o.date_fin,
            o.mise_en_ligne,
            v.nom_ville,
            c.competence
        FROM entreprise e
        INNER JOIN offre o ON e.id_entreprise = o.id_entreprise
        LEFT JOIN situer s ON e.id_entreprise = s.id_entreprise
        LEFT JOIN ville v ON s.id_ville = v.id_ville
        LEFT JOIN associer a ON o.id_offre = a.id_offre
        LEFT JOIN competence c ON a.id_competence = c.id_competence
        WHERE e.cacher_entreprise = 0
        AND o.cacher_offre = 0
        AND o.id_offre = :id
        ORDER BY e.nom, o.titre, 
        CASE 
            WHEN c.competence LIKE 'Bac%' THEN 1
            ELSE 0
        END, c.competence";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$resultats) {
            return null;
        }

        $offre = [
            'id_entreprise' => $resultats[0]['id_entreprise'] ?? null,
            'nom_entreprise' => $resultats[0]['nom_entreprise'] ?? '',
            'id_offre' => $resultats[0]['id_offre'] ?? null,
            'titre_offre' => $resultats[0]['titre_offre'] ?? '',
            'description_offre' => $resultats[0]['description_offre'] ?? '',
            'remuneration' => $resultats[0]['remuneration'] ?? null,
            'date_debut' => $resultats[0]['date_debut'] ?? null,
            'date_fin' => $resultats[0]['date_fin'] ?? null,
            'mise_en_ligne' => $resultats[0]['mise_en_ligne'] ?? null,
            'nom_ville' => $resultats[0]['nom_ville'] ?? '',
            'competences' => []
        ];

        foreach ($resultats as $row) {
            if (!empty($row['competence']) && !in_array($row['competence'], $offre['competences'])) {
                $offre['competences'][] = $row['competence'];
            }
        }

        return $offre;
    }

    public function delOffre($id) {
        $sql = "UPDATE offre SET cacher_offre = 1 WHERE id_offre = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
}
