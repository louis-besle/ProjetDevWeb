<?php
session_start();
require "vendor/autoload.php"; // Chargement des dépendances

// Importation de la classe SiteController
use App\Controllers\SiteController;
// Importation de la classe SiteController
use App\Controllers\AuthController;

use function PHPUnit\Framework\isEmpty;

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

$isConnect = !empty($_SESSION['user']['role']);

switch ($uri) {
    case '/':
        $controller->_Page_Connexion();
        break;
    case 'accueil':
        if ($isConnect) {
            $controller->_Page_Accueil();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'recherche':
        if ($isConnect) {
            $controller->_Page_Recherche();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'offre':
        if ($isConnect) {
            $controller->_Page_OffreOnClick();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'entreprise':
        if ($isConnect) {
            $controller->_Page_EntrepriseOnClick();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'login':
        $authController->login();
        break;
    case 'logout':
        if ($isConnect) {
            $authController->logout();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'dashboard':
        if ($isConnect) {
            $controller->_Page_Dashboard();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'wishlist':
        if ($isConnect) {
            $controller->_Page_Wishlist();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'cv':
        if ($isConnect) {
            $controller->_Page_CV();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'offres_postulees':
        if ($isConnect) {
            $controller->_Page_OffrePostulees();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;


    case 'ajouter_offre':
        if ($isConnect) {
            $controller->_Page_Ajouter_Offre();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;

    case 'formulaire_offre':
        if ($isConnect) {
            $controller->formulaire_offre();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'page_modifier_offre':
        if ($isConnect) {
            $controller->_Page_Modifier_Offre();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'modifier_offre':
        if ($isConnect) {
            $controller->modifier_offre();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;



    case 'ajouter_compte':
        if ($isConnect) {
            $controller->_Page_Ajouter_Compte();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'formulaire_compte':
        if ($isConnect) {
            $controller->formulaire_compte();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'compte':
        if ($isConnect) {
            $controller->_Page_Modifier_Compte();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'modifier_compte':
        if ($isConnect) {
            $controller->modifier_compte();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'ajouter_entreprise':
        if ($isConnect) {
            $controller->_Page_Ajouter_Entreprise();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'formulaire_entreprise':
        if ($isConnect) {
            $controller->formulaire_entreprise();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;

    case 'page_modifier_entreprise':
        if ($isConnect) {
            $controller->_Page_Modifier_Entreprise();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'modifier_entreprise':
        if ($isConnect) {
            $controller->modifier_entreprise();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'mentions':
        $controller->mentions();
        break;
    case 'cgu':
        $controller->cgu();
        break;
    case 'politique':
        $controller->politiqueConfidentialite();
        break;
    case 'cookies':
        $controller->cookies();
        break;
    case 'contact':
        $controller->contact();
        break;
        
    default:
        echo '404 Not Found';
        break;
}
