<?php 
namespace App\Controllers;

use App\Models\SiteModel;

class SiteController extends Controller {

    public function __construct($templateEngine) {
        $this->model = new SiteModel();
        $this->templateEngine = $templateEngine;
    }

    public function _Page_Connexion(){
        echo $this->templateEngine->render('_connexion.twig.html');
    }

    public function _Page_Accueil(){
        echo $this->templateEngine->render('_accueil.twig.html');
    }
    public function _Page_Recherche(){
        echo $this->templateEngine->render('_recherche.twig.html');
    }
    public function _Page_OffreOnClick(){
        echo $this->templateEngine->render('_offre_onclick.twig.html');
    }
    public function _Page_EntrepriseOnClick(){
        echo $this->templateEngine->render('_entreprise_onclick.twig.html');
    }
}
