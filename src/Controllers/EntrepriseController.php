<?php

require_once 'Entreprise.php';

class EntrepriseController
{
    private PDO $pdo;
    private \Twig\Environment $twig;

    public function __construct(PDO $pdo, \Twig\Environment $twig)
    {
        $this->pdo = $pdo;
        $this->twig = $twig;
    }

    public function afficherEntreprises(): void
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM entreprises");
            
            if ($stmt === false) {
                throw new Exception("Erreur lors de la récupération des entreprises.");
            }

            $entreprisesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($entreprisesData)) {
                echo "Aucune entreprise trouvée.";
                return;
            }

            $entreprises = [];
            foreach ($entreprisesData as $data) {
                $entreprises[] = new Entreprise($data['id'], $data['nom'], $data['ville'], $data['miseenligne'], $data['logo']);
            }

            echo $this->twig->render('_recherche.twig.html', [
                'entreprises' => $entreprises
            ]);
        } catch (Exception $e) {
            echo "Une erreur est survenue : " . $e->getMessage();
        }
    }
}

