<?php
session_start();
require "vendor/autoload.php"; // Chargement des dépendances

// Importation de la classe SiteController
use App\Controllers\SiteController;
// Importation de la classe SiteController
use App\Controllers\AuthController;

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
$authController = new AuthController();

switch ($uri) {
    case '/':
        $controller->_Page_Connexion();
        break;
    case 'accueil':
        $controller->_Page_Accueil();
        break;
    case 'recherche':
        $controller->_Page_Recherche();
        break;
    case 'offre':
        $controller->_Page_OffreOnClick();
        break;
    case 'entreprise':
        $controller->_Page_EntrepriseOnClick();
        break;
    case 'login':
        $authController->login();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'dashboard':
        $controller->_Page_Dashboard();
        break;
    case 'wishlist':
        $controller->_Page_Wishlist();
        break;
    case 'cv':
        $controller->_Page_CV();
        break;
    case 'offres_postulees':
        $controller->_Page_OffrePostulees();
        break;


    case 'ajouter_offre':
        $controller->_Page_Ajouter_Offre();
        break;
    case 'ajouter_compte':
        $controller->_Page_Ajouter_Compte();
        break;
    case 'ajouter_entreprise':
        $controller->_Page_Ajouter_Entreprise();
        break;


    default:
        echo '404 Not Found';
        break;
}
