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

    public function getAllRecords($table)
    {
        $sql = $this->pdo->query("SELECT * FROM {$table}");
        return $sql->fetchAll();
    }

    public function getRecordById($table, $id)
    {
        $sql = $this->pdo->query("SELECT * FROM {$table} WHERE id_{$table} = {$id}");
        return $sql->fetch();
    }

    public function getRecordBetweenTableEntrepriseVille($table1, $relation, $table2)
    {
        $sql = "SELECT entreprise.id_entreprise, entreprise.nom, ville.nom_ville 
                FROM `$table1`
                INNER JOIN `$relation` ON `$table1`.id_{$table1} = `$relation`.id_{$table1}
                INNER JOIN `$table2` ON `$relation`.id_{$table2} = `$table2`.id_{$table2}";

        $requete = $this->pdo->prepare($sql);
        $requete->execute();

        return $requete->fetchAll(PDO::FETCH_ASSOC);
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
