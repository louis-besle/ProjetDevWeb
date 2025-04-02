<?php
namespace App\Controllers;

abstract class Controller {

    protected $model = null; // Modèle associé au contrôleur

    protected $templateEngine = null; // Moteur de template utilisé par le contrôleur
}