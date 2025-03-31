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
        $offres = $this->model->getOffresAccueil();
        $entreprises = $this->model->getEntreprisesAccueil($offres);
        echo $this->templateEngine->render('_accueil.twig.html', ['offres' => $offres,'entreprises' => $entreprises]);
    }
    public function _Page_Recherche(){
        $page_actuelle = $this->model->getPageActuelle();
        $nbpages = $this->model->getNbPages();
        $entreprises = $this->model->getEntreprisesRecherche($page_actuelle);
        $offres = $this->model->getOffreRecherche($page_actuelle);
        $entreprises = $this->model->getVillesEntreprises($page_actuelle);
        echo $this->templateEngine->render('_recherche.twig.html', ['offres' => $offres,'entreprises' => $entreprises,'page_actuelle' => $page_actuelle, 'nb_pages' => $nbpages]);
    }
    public function _Page_OffreOnClick(){
        echo $this->templateEngine->render('_offre_onclick.twig.html');
    }
    public function _Page_EntrepriseOnClick(){
        echo $this->templateEngine->render('_entreprise_onclick.twig.html');
    }
}
