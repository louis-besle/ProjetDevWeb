<?php

namespace App\Controllers;

use App\Models\SiteModel;
use Exception;

class SiteController extends Controller
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
            $this->model = new SiteModel();
            $this->templateEngine = $templateEngine;
        } catch (Exception $e) {
            error_log("Erreur d'initialisation du contrôleur: " . $e->getMessage());
            die("Erreur pendant l'initialisation");
        }
    }

    /**
     * Affiche la page de connexion
     */
    public function _Page_Connexion()
    {
        try {
            echo $this->templateEngine->render('_connexion.twig.html');
        } catch (Exception $e) {
            error_log("Erreur page connexion: " . $e->getMessage());
            echo "Erreur pendant l'affichage de la page";
        }
    }

    /**
     * Affiche la page d'accueil avec les offres et entreprises
     */
    public function _Page_Accueil()
    {
        try {
            $offres = $this->model->getOffresAccueil();
            $entreprises = $this->model->getEntreprisesAccueil($offres);

            echo $this->templateEngine->render('_accueil.twig.html', ['offres' => $offres, 'entreprises' => $entreprises]);
        } catch (Exception $e) {
            error_log("Erreur page accueil: " . $e->getMessage());
            echo "Erreur pendant le chargement de la page d'accueil";
        }
    }

    public function _Page_Postuler() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_FILES['lettre_motivation']['name'])) {
                $upload_dir = 'static/uploads/lettres_motivation/';
                $image_name = time() . '_' . basename($_FILES['lettre_motivation']['name']);
                $image_path = $upload_dir . $image_name;

                $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                if (in_array($_FILES['lettre_motivation']['type'], $allowed_types) && move_uploaded_file($_FILES['lettre_motivation']['tmp_name'], $image_path)) {
                    $image = $image_name;
                }
            }
            echo $this->model->ajout_candidater($_SESSION['user']['id'], $_POST['id_offre'], $image, $_POST['message_recruteur']);
            header('Location: /?uri=accueil');
        }
        exit;
    }

    public function mentions() {
        echo $this->templateEngine->render('mentions.twig.html');

    }
    public function cgu() {
        echo $this->templateEngine->render('cgu.twig.html');
    }
    public function politiqueConfidentialite() {
        echo $this->templateEngine->render('politique_confidentialites.twig.html');
    }
    public function cookies() {
    echo $this->templateEngine->render('Cookies.twig.html');
    }
    public function contact() {
        echo $this->templateEngine->render('contact.twig.html');
    }
}
?>