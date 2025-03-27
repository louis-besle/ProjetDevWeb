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
}
