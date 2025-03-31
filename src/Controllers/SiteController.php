<?php

namespace App\Controllers;

use App\Models\SiteModel;

class SiteController extends Controller
{

    public function __construct($templateEngine)
    {
        $this->model = new SiteModel();
        $this->templateEngine = $templateEngine;
    }

    public function _Page_Connexion()
    {
        echo $this->templateEngine->render('_connexion.twig.html');
    }

    public function _Page_Accueil()
    {
        echo $this->templateEngine->render('_accueil.twig.html');
    }
    public function _Page_Recherche()
    {
        echo $this->templateEngine->render('_recherche.twig.html');
    }
    public function _Page_OffreOnClick()
    {
        echo $this->templateEngine->render('_offre_onclick.twig.html');
    }
    public function _Page_EntrepriseOnClick()
    {
        echo $this->templateEngine->render('_entreprise_onclick.twig.html');
    }

    public function _Page_Dashboard()
    {
        if ($_SESSION['user']['role'] === 'administrateur') {
            echo $this->templateEngine->render('a_dashboard.twig.html');
        } else if ($_SESSION['user']['role'] === 'pilote') {
            echo $this->templateEngine->render('p_dashboard.twig.html');
        } else if ($_SESSION['user']['role'] === 'etudiant') {
            echo $this->templateEngine->render('e_dashboard.twig.html');
        }
    }
    public function _Page_Wishlist()
    {
        echo $this->templateEngine->render('e_wishlist.twig.html');
    }
    public function _Page_CV()
    {
        echo $this->templateEngine->render('e_cv.twig.html');
    }
    public function _Page_OffrePostulees()
    {
        echo $this->templateEngine->render('e_offre_postule.twig.html');
    }


    public function _Page_Ajouter_Offre()
    {
        $selection = $this->model->getEntrepriseByVille();
        $competence = $this->model->getCompetence();
        $niveau = $this->model->getNiveau();

        echo $this->templateEngine->render('_add_offer.twig.html', ['selection' => $selection, 'competence' => $competence, 'niveau' => $niveau]);
    }


    public function _Page_Ajouter_Compte()
    {
        if ($_SESSION['user']['role'] === 'administrateur') {
            echo $this->templateEngine->render('a_add_account.twig.html');
        } else if ($_SESSION['user']['role'] === 'pilote') {
            echo $this->templateEngine->render('p_add_account.twig.html');
        }
    }
    public function _Page_Ajouter_Entreprise()
    {
        echo $this->templateEngine->render('_add_enterprise.twig.html');
    }


    public function formulaire_offre()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $offer_title = isset($_POST['offer_title']) ? htmlspecialchars($_POST['offer_title'], ENT_QUOTES, 'UTF-8') : '';
            $entreprise = isset($_POST['entreprise']) ? htmlspecialchars($_POST['entreprise'], ENT_QUOTES, 'UTF-8') : '';
            $competence = isset($_POST['competence']) ? $_POST['competence'] : [];
            $start = isset($_POST['duration_start']) ? htmlspecialchars($_POST['duration_start'], ENT_QUOTES, 'UTF-8') : '';
            $end = isset($_POST['duration_end']) ? htmlspecialchars($_POST['duration_end'], ENT_QUOTES, 'UTF-8') : '';
            $remuneration = isset($_POST['remuneration']) ? htmlspecialchars($_POST['remuneration'], ENT_QUOTES, 'UTF-8') : '';
            $niveau = isset($_POST['niveau']) ? $_POST['niveau'] : [];
            $job_description = isset($_POST['job_description']) ? htmlspecialchars($_POST['job_description'], ENT_QUOTES, 'UTF-8') : '';


            $data = array_merge($competence, $niveau);

            $this->model->insertoffer($offer_title, $entreprise, $data, $start, $end, $remuneration, $job_description);
            header('Location: /?uri=recherche');
        }
    }
}
