<?php

namespace App\Controllers;

use App\Models\StatistiqueModel;
use Exception;

class StatistiqueController extends Controller
{
    protected $model;
    protected $templateEngine;

    /**
     * Constructeur du contrôleur
     * @param mixed $templateEngine Moteur de template
     */
    public function __construct($templateEngine)
    {
        try {
            $this->model = new StatistiqueModel();
            $this->templateEngine = $templateEngine;
        } catch (Exception $e) {
            error_log("Erreur d'initialisation du contrôleur: " . $e->getMessage());
            die("Erreur pendant l'initialisation");
        }
    }
    /**
     * Affiche la page de statistiques des étudiants
     * @return void
     */
    public function _Page_Statistique_Etudiant()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_etudiant = intval($_POST['voir']);
            $resultats = $this->model->statistique_utilisateur($id_etudiant);
            echo $this->templateEngine->render('ap_statistique.twig.html', ['resultat' => $resultats]);
        }
    }
    /**
     * Affiche la page de statistiques des offres
     * @return void
     */
    public function _Page_Statistique_Offre()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $competence = $this->model->rep_competence();
            $duree = $this->model->rep_duree();
            $wishlist = $this->model->rep_wishlist();
            $offre_postes =  $this->model->nombre_offre();
            echo $this->templateEngine->render('_statistique_offre.twig.html', ['competence' => $competence, 'duree' => $duree, 'wishlist' => $wishlist, 'offre' => $offre_postes]);
        }
    }
    /**
     * Affiche la page de statistiques des entreprises
     * @return void
     */
    public function _Page_Statistique_Entreprise()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selection = $this->model->entrepriseVille();
            $total = $this->model->entreprisetotal();
            $of_ent = $this->model->entreprise();
            echo $this->templateEngine->render('_statistique_entreprise.twig.html', ['selection' => $selection, 'total' => $total, 'off' => $of_ent]);
        }
    }
}
?>