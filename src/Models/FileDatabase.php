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

    public function getRecordBetweenTableOffreEntreprise($table1, $table2, $options = null)
    {
        $sql = "SELECT offre.id_offre, offre.titre, offre.description, offre.mise_en_ligne, e.nom
                FROM `$table1`
                INNER JOIN `$table2`e ON `$table1`.id_{$table2} = e.id_{$table2}
                INNER JOIN situer s ON e.id_entreprise = s.id_entreprise
                INNER JOIN ville v ON s.id_ville = v.id_ville";
        if ($options) {
            $sql .= " WHERE $options";
        }

        $requete = $this->pdo->prepare($sql);
        $requete->execute();

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecordBetweenTableEntrepriseVille($table1, $relation, $table2, $options = null)
    {
        $sql = "SELECT e.id_entreprise, e.nom, v.id_ville, v.nom_ville, e.image_illustration , e.description, e.telephone, e.email_contact
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
        WHERE utilisateur.cacher_utilisateur = 0 AND (role.nom_role = 'Etudiant'";

        if ($role === 'Administrateur') {
            $sql .= " OR role.nom_role = 'Pilote'";
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
        // Mise à jour de l'offre
        $sql = "UPDATE offre SET titre = ?, description = ?, remuneration = ?, date_debut = ?, date_fin = ?, mise_en_ligne = NOW(), id_entreprise = ? WHERE id_offre = ?";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([$titre, $description, $remuneration, $date_debut, $date_fin, $id_entreprise, $id]);

        if ($result) {
            // Suppression des anciennes compétences associées
            $deleteSql = "DELETE FROM associer WHERE id_offre = ?";
            $deleteStmt = $this->pdo->prepare($deleteSql);
            $deleteStmt->execute([$id]);

            // Insertion des nouvelles compétences sans doublon
            $insertSql = "INSERT INTO associer (id_offre, id_competence) VALUES (?, ?)";
            $insertStmt = $this->pdo->prepare($insertSql);

            foreach ($competences as $competence) {
                if (!empty($competence) && is_numeric($competence)) {
                    // Vérification pour éviter les doublons dans la table 'associer'
                    $checkSql = "SELECT COUNT(*) FROM associer WHERE id_offre = ? AND id_competence = ?";
                    $checkStmt = $this->pdo->prepare($checkSql);
                    $checkStmt->execute([$id, $competence]);
                    $count = $checkStmt->fetchColumn();

                    // Si la compétence n'est pas déjà associée à l'offre, on l'insère
                    if ($count == 0) {
                        $insertStmt->execute([$id, $competence]);
                    }
                }
            }
        }

        return $result;
    }


    public function recupinfoOffre($id)
    {
        $sql = "SELECT 
                    o.*, 
                    e.id_entreprise, 
                    e.nom AS nom_entreprise, 
                    v.nom_ville, 
                    c.id_competence, 
                    c.competence AS nom_competence
                FROM offre o
                JOIN entreprise e ON o.id_entreprise = e.id_entreprise
                LEFT JOIN situer s ON e.id_entreprise = s.id_entreprise
                LEFT JOIN ville v ON s.id_ville = v.id_ville
                LEFT JOIN associer a ON o.id_offre = a.id_offre
                LEFT JOIN competence c ON a.id_competence = c.id_competence
                WHERE o.id_offre = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$resultats) {
            return null;
        }

        // Structuration des résultats pour éviter les doublons d'offres
        $offre = [
            'id_offre' => $resultats[0]['id_offre'],
            'titre_offre' => $resultats[0]['titre'],
            'description_offre' => $resultats[0]['description'],
            'remuneration' => $resultats[0]['remuneration'],
            'date_debut' => $resultats[0]['date_debut'],
            'date_fin' => $resultats[0]['date_fin'],
            'mise_en_ligne' => $resultats[0]['mise_en_ligne'],
            'cacher_offre' => $resultats[0]['cacher_offre'],
            'entreprise' => [
                'id_entreprise' => $resultats[0]['id_entreprise'],
                'nom_entreprise' => $resultats[0]['nom_entreprise'],
                'ville' => $resultats[0]['nom_ville'] ?? ''  // Ajout de la ville
            ],
            'competences' => []
        ];

        // Ajout des compétences à l'offre
        foreach ($resultats as $row) {
            if (!empty($row['id_competence'])) {
                $offre['competences'][] = [
                    'id_competence' => $row['id_competence'],
                    'nom_competence' => $row['nom_competence']
                ];
            }
        }

        return $offre;
    }



    public function delOffre($id)
    {
        $sql = "UPDATE offre SET cacher_offre = 1 WHERE id_offre = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function getRecordInfoOffres($id)
    {
        $sql = "SELECT date_debut, date_fin, offre.description as description_offre, entreprise.description as description_entreprise, entreprise.nom
                FROM offre
                INNER JOIN entreprise ON offre.id_entreprise = entreprise.id_entreprise
                WHERE id_offre = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllCompetencesAssociees($idOffre)
    {
        $sql = "SELECT competence.id_competence, competence.competence
                FROM associer
                INNER JOIN competence ON associer.id_competence = competence.id_competence
                WHERE associer.id_offre = :idOffre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':idOffre', $idOffre, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delEntreprise($id)
    {
        $sql = "UPDATE entreprise SET cacher_entreprise = 1 WHERE id_entreprise = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function getRecordEntrepriseOnClick($table, $id_ent, $id_ville)
    {
        $sql = "SELECT entreprise.id_entreprise, entreprise.nom, entreprise.description, entreprise.email_contact, entreprise.telephone, entreprise.image_illustration, ville.nom_ville, count(DISTINCT offre.titre) AS nombre_offres, count(candidater.id_utilisateur) AS nombre_candidatures
        FROM $table
        INNER JOIN situer ON entreprise.id_entreprise = situer.id_entreprise
        INNER JOIN ville ON situer.id_ville = ville.id_ville
        INNER JOIN offre ON entreprise.id_entreprise = offre.id_entreprise
        INNER JOIN candidater ON offre.id_offre = candidater.id_offre
        WHERE entreprise.id_entreprise = $id_ent AND ville.id_ville = $id_ville";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateEntreprise($id_entreprise, $entreprise_titre, $id_ville, $presentation, $tel, $mail, $image)
    {

        $sql = "UPDATE entreprise
                    SET
                        nom = :nom,
                        description = :description,
                        email_contact = :email_contact,
                        telephone = :telephone,
                        image_illustration = :image_illustration
                    WHERE entreprise.id_entreprise = :id_entreprise";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nom' => $entreprise_titre,
            ':description' => $presentation,
            ':email_contact' => $mail,
            ':telephone' => $tel,
            ':image_illustration' => $image,
            ':id_entreprise' => $id_entreprise
        ]);

        $sql_situ = "INSERT INTO situer (id_ville, id_entreprise) 
                         VALUES (:id_ville, :id_entreprise)
                         ON DUPLICATE KEY UPDATE id_ville = :id_ville";

        $stmt_situ = $this->pdo->prepare($sql_situ);
        $stmt_situ->execute([
            ':id_ville' => $id_ville,
            ':id_entreprise' => $id_entreprise
        ]);
    }

    public function rechercherOffres($rechercheGenerale, $ville)
    {
        $motsCles = explode(" ", trim($rechercheGenerale));

        $criteres = [];
        $params = [];

        // Recherche par mots-clés individuels
        foreach ($motsCles as $mot) {
            if (empty($mot)) continue;
            
            $subCriteres = [];
            
            // Vérifier si le mot correspond à une entreprise
            $stmt = $this->pdo->prepare("SELECT id_entreprise FROM entreprise WHERE nom LIKE ?");
            $stmt->execute(["%$mot%"]);
            if ($stmt->fetch()) {
                $subCriteres[] = "entreprise.nom LIKE ?";
                $params[] = "%$mot%";
            }

            // Vérifier si le mot correspond à une compétence
            $stmt = $this->pdo->prepare("SELECT id_competence FROM competence WHERE competence LIKE ?");
            $stmt->execute(["%$mot%"]);
            if ($stmt->fetch()) {
                $subCriteres[] = "competence.competence LIKE ?";
                $params[] = "%$mot%";
            }

            // Toujours chercher dans titre/description de l'offre
            $subCriteres[] = "(offre.titre LIKE ? OR offre.description LIKE ?)";
            $params[] = "%$mot%";
            $params[] = "%$mot%";

            // Combiner les sous-critères avec OR
            if (!empty($subCriteres)) {
                $criteres[] = "(" . implode(" OR ", $subCriteres) . ")";
            }
        }

        // Recherche par terme complet (en plus des mots individuels)
        if (!empty($rechercheGenerale)) {
            $criteres[] = "(offre.titre LIKE ? OR offre.description LIKE ?)";
            $params[] = "%$rechercheGenerale%";
            $params[] = "%$rechercheGenerale%";

            $criteres[] = "competence.competence LIKE ?";
            $params[] = "%$rechercheGenerale%";

            $criteres[] = "entreprise.nom LIKE ?";
            $params[] = "%$rechercheGenerale%";

            $criteres[] = "offre.remuneration LIKE ?";
            $params[] = "%$rechercheGenerale%";
        }

        // Construction de la requête SQL
        $sql = "SELECT 
                    offre.id_offre, offre.titre, offre.description, offre.remuneration, offre.mise_en_ligne, 
                    entreprise.nom AS nom_entreprise, 
                    ville.nom_ville, GROUP_CONCAT(DISTINCT competence.competence SEPARATOR ', ') AS competences
                FROM offre
                JOIN entreprise ON offre.id_entreprise = entreprise.id_entreprise
                JOIN situer ON entreprise.id_entreprise = situer.id_entreprise
                JOIN ville ON situer.id_ville = ville.id_ville
                LEFT JOIN associer ON offre.id_offre = associer.id_offre
                LEFT JOIN competence ON associer.id_competence = competence.id_competence";

        // Ajout des conditions WHERE
        if (!empty($criteres)) {
            $sql .= " WHERE " . implode(" OR ", $criteres);
        }

        // Filtre par ville
        if ($ville) {
            $sql .= empty($criteres) ? " WHERE " : " AND ";
            $sql .= "ville.nom_ville LIKE ?";
            $params[] = "%$ville%";
        }

        $sql .= " GROUP BY offre.id_offre, offre.titre, offre.description, offre.remuneration, offre.mise_en_ligne, entreprise.nom, ville.nom_ville";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gestion des erreurs
            error_log("Erreur de recherche: " . $e->getMessage());
            return [];
        }
    }

    public function nbr_offre()
    {
        $sql = "SELECT count(offre.id_offre) FROM offre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result[0];
    }

    public function nbr_personne($id_offre)
    {
        $sql = "SELECT count(*) FROM candidater WHERE id_offre = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_offre]);
        $result = $stmt->fetch();
        return $result[0];
    }

    public function nbr_utilisateur($role)
    {
        $sql = "SELECT count(utilisateur.id_utilisateur) FROM utilisateur INNER JOIN role ON utilisateur.id_role = role.id_role WHERE nom_role = :nom_role";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nom_role' => $role]);
        $result = $stmt->fetch();
        return $result[0];
    }

    public function statistique($id_etudiant)
    {
        $sql = "
            SELECT 
                (SELECT COUNT(id_log) FROM log WHERE id_utilisateur = :id) AS total_logs,
                (SELECT COUNT(DISTINCT o.id_offre) FROM candidater c 
                    LEFT JOIN offre o ON c.id_offre = o.id_offre
                    WHERE c.id_utilisateur = :id) AS total_offres,
                (SELECT COUNT(DISTINCT o.id_offre) FROM souhaiter s
                    LEFT JOIN offre o ON s.id_offre = o.id_offre
                    WHERE s.id_utilisateur = :id) AS total_wishlist,
                u.id_utilisateur,
                u.nom_utilisateur,
                u.prenom_utilisateur,
                u.email
            FROM utilisateur u
            WHERE u.id_utilisateur = :id;
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id_etudiant]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function repartitionParCompetence()
    {
        $sql = "
            SELECT c.competence, COUNT(a.id_offre) AS nombre_offres
            FROM associer a
            INNER JOIN competence c ON a.id_competence = c.id_competence
            GROUP BY c.competence
            ORDER BY nombre_offres DESC;
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecordOffresDashboard($id_utilisateur, $relation)
    {
        $sql = "SELECT offre.titre, entreprise.nom, offre.mise_en_ligne, offre.id_offre
            FROM utilisateur
            INNER JOIN `$relation` ON `$relation`.id_utilisateur = utilisateur.id_utilisateur
            INNER JOIN offre ON `$relation`.id_offre = offre.id_offre
            INNER JOIN entreprise ON offre.id_entreprise = entreprise.id_entreprise
            WHERE utilisateur.id_utilisateur = $id_utilisateur";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function repartitionParDuree()
    {
        $sql = "
        SELECT 
            CASE 
                WHEN DATEDIFF(o.date_fin, o.date_debut) <= 30 THEN 'Moins d\'1 mois'
                WHEN DATEDIFF(o.date_fin, o.date_debut) BETWEEN 31 AND 90 THEN '1 à 3 mois'
                WHEN DATEDIFF(o.date_fin, o.date_debut) BETWEEN 91 AND 180 THEN '3 à 6 mois'
                ELSE 'Plus de 6 mois'
            END AS duree_stage,
            COUNT(o.id_offre) AS nombre_offres
        FROM offre o
        GROUP BY duree_stage
        ORDER BY nombre_offres DESC;
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCV($id_utilisateur)
    {
        $sql = "SELECT cv.cv, utilisateur.id_utilisateur
                FROM utilisateur
                INNER JOIN cv ON cv.id_utilisateur = utilisateur.id_utilisateur
                WHERE utilisateur.id_utilisateur = :id_utilisateur";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function topOffresWishlist($limit = 5)
    {
        $sql = "
        SELECT o.titre, e.nom AS entreprise, COUNT(s.id_utilisateur) AS nombre_wishlist
        FROM souhaiter s
        INNER JOIN offre o ON s.id_offre = o.id_offre
        INNER JOIN entreprise e ON o.id_entreprise = e.id_entreprise
        GROUP BY o.id_offre, o.titre, e.nom
        ORDER BY nombre_wishlist DESC
        LIMIT :limit;
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function nombreEntreprisesParVille()
    {
        // Requête SQL pour compter le nombre d'entreprises par ville
        $sql = "
        SELECT v.nom_ville, COUNT(e.id_entreprise) AS nombre_entreprises
        FROM ville v
        JOIN situer s ON v.id_ville = s.id_ville
        JOIN entreprise e ON s.id_entreprise = e.id_entreprise
        GROUP BY v.id_ville;
    ";

        // Préparation et exécution de la requête
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        // Récupération des résultats
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retourner les résultats
        return $result;
    }

    public function nombreEntreprises()
    {
        // Requête SQL pour compter le nombre d'entreprises par ville
        $sql = "
        SELECT COUNT(entreprise.id_entreprise) AS nombre_entreprises
        FROM entreprise";

        // Préparation et exécution de la requête
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        // Récupération des résultats
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retourner les résultats
        return $result[0];
    }

    public function getRecordEntreprise()
    {
        $sql = "SELECT e.nom, COUNT(DISTINCT o.id_offre) AS nombre_offres, COUNT(DISTINCT c.id_utilisateur) AS nombre_candidatures
                FROM entreprise e
                INNER JOIN situer s ON e.id_entreprise = s.id_entreprise
                INNER JOIN ville v ON s.id_ville = v.id_ville
                INNER JOIN offre o ON e.id_entreprise = o.id_entreprise
                INNER JOIN candidater c ON o.id_offre = c.id_offre
                GROUP BY e.id_entreprise;";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateSouhaiter($id_utilisateur, $id_offre)
    {
        try {
            $sql = 'INSERT INTO souhaiter (id_utilisateur, id_offre)
                VALUES (:id_utilisateur, :id_offre)';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam('id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
            $stmt->bindParam('id_offre', $id_offre, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            $sql = 'DELETE FROM souhaiter WHERE id_utilisateur = :id_utilisateur AND id_offre = :id_offre';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam('id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
            $stmt->bindParam('id_offre', $id_offre, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }

    public function addCandidater($id_utilisateur, $id_offre, $lettre_motivation, $message_recruteur)
    {
        try {
            $sql = 'INSERT INTO candidater (id_utilisateur, id_offre, date_candidature, lettre_motivation, message_recruteur)
                VALUES (:id_utilisateur, :id_offre, :date_candidature, :lettre_motivation, :message_recruteur)';

            $date_candidature = date('Y-m-d H:i:s'); // Date actuelle

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam('id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
            $stmt->bindParam('id_offre', $id_offre, PDO::PARAM_INT);
            $stmt->bindParam('date_candidature', $date_candidature, PDO::PARAM_STR);
            $stmt->bindParam('lettre_motivation', $lettre_motivation, PDO::PARAM_STR);
            $stmt->bindParam('message_recruteur', $message_recruteur, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function checkCandidature($id_utilisateur, $id_offre)
    {
        try {
            $sql = 'SELECT COUNT(*) FROM candidater WHERE id_utilisateur = :id_utilisateur AND id_offre = :id_offre';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam('id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
            $stmt->bindParam('id_offre', $id_offre, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn() > 0; // Retourne true si le candidat a déjà postulé, sinon false
        } catch (PDOException $e) {
            return false; // En cas d'erreur, on retourne false (ou on peut gérer l'erreur différemment selon les besoins)
        }
    }

    public function insertLog($id_utilisateur, $date_connexion)
    {
        try {
            $sql = 'INSERT INTO log (id_utilisateur, date_connexion)
                VALUES (:id_utilisateur, :date_connexion)';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam('id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
            $stmt->bindParam('date_connexion', $date_connexion, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function insertNote(int $idUtilisateur, int $idEntreprise, float $note, string $commentaire): bool {
        $sql = "INSERT INTO evaluer (id_utilisateur, id_entreprise, note, commentaire) 
                VALUES (:id_utilisateur, :id_entreprise, :note, :commentaire)
                ON DUPLICATE KEY UPDATE note = :note, commentaire = :commentaire";
    
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_utilisateur' => $idUtilisateur,
            ':id_entreprise' => $idEntreprise,
            ':note' => $note,
            ':commentaire' => htmlspecialchars($commentaire, ENT_QUOTES, 'UTF-8')
        ]);
    }

    public function getDerniersCommentaires(int $idEntreprise) {
        $sql = "SELECT commentaire, note, id_utilisateur 
                FROM evaluer 
                WHERE id_entreprise = :id_entreprise 
                ORDER BY id_utilisateur DESC 
                LIMIT 5";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_entreprise' => $idEntreprise]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getmoynote(int $idEntreprise) {
        $sql = "SELECT count(note) as total, sum(note) as somme_notes, id_entreprise, commentaire
                FROM evaluer 
                WHERE id_entreprise = :id_entreprise
                GROUP BY id_entreprise, commentaire
                ORDER BY id_entreprise DESC";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_entreprise' => $idEntreprise]);
    
        // Récupérer les résultats
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Si des résultats sont trouvés, retourner la somme des notes
        if ($result) {
            return $result['somme_notes']; // Retourne la somme des notes
        }
    
        return 0; // Si aucun résultat trouvé, retourner 0
    }
    public function getPDO(): PDO
    {
        return $this->pdo;
    }
}
?>