<?php

session_start();
require "vendor/autoload.php"; // Chargement des dépendances

// Importation de la classe SiteController
use App\Controllers\SiteController;

// Initialisation de Twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);

// Gestion et de l'URL pour par la suite récupérer l'action associée
if (isset($_GET['uri'])) {
    $uri = $_GET['uri'];
} else {
    $uri = '/';
}

$controller = new SiteController($twig);

switch ($uri) {
    case '/':
        $controller->_Page_Connexion();
        break;
    default:
        echo '404 Not Found';
        break;
}
