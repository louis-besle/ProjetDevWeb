<?php

namespace App\Controllers;

use App\Models\DashboardModel;
use Exception;

class DashboardController extends Controller
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
            $this->model = new DashboardModel();
            $this->templateEngine = $templateEngine;
        } catch (Exception $e) {
            error_log("Erreur d'initialisation du contrôleur: " . $e->getMessage());
            die("Erreur pendant l'initialisation");
        }
    }
    public function _Page_Dashboard()
    {
        $nombre_pilote = $this->model->nombre_utilisateur('Pilote');
        $nombre_etudiant = $this->model->nombre_utilisateur('Étudiant');
        if ($_SESSION['user']['role'] === 'Administrateur') {
            echo $this->templateEngine->render('a_dashboard.twig.html', ['nombre_pilote' => $nombre_pilote, 'nombre_etudiant' => $nombre_etudiant]);
        } else if ($_SESSION['user']['role'] === 'Pilote') {
            echo $this->templateEngine->render('p_dashboard.twig.html', ['nombre_etudiant' => $nombre_etudiant]);
        } else if ($_SESSION['user']['role'] === 'Étudiant') {
            echo $this->templateEngine->render('e_dashboard.twig.html');
        }
    }
}

?>