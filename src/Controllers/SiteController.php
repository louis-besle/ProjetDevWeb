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
        if ($_SESSION['user']['role'] === 'admin') {
            echo $this->templateEngine->render('a_dashboard.twig.html');
        } 
        else if ($_SESSION['user']['role'] === 'pilote') {
            echo $this->templateEngine->render('p_dashboard.twig.html');
        } 
        else if ($_SESSION['user']['role'] === 'etudiant') {
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
        echo $this->templateEngine->render('_add_offer.twig.html');
    }
    public function _Page_Ajouter_Compte()
    {
        if ($_SESSION['user']['role'] === 'admin') {
            echo $this->templateEngine->render('a_add_account.twig.html');
        } 
        else if ($_SESSION['user']['role'] === 'pilote') {
            echo $this->templateEngine->render('p_add_account.twig.html');
        } 
    }
    public function _Page_Ajouter_Entreprise()
    {
        echo $this->templateEngine->render('_add_enterprise.twig.html');
    }

}
