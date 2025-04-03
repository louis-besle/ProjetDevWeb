<?php
session_start();
require "vendor/autoload.php"; // Chargement des dépendances

// Importation de la classe SiteController
use App\Controllers\SiteController;
// Importation de la classe AuthController
use App\Controllers\AuthController;
// Importation de la classe SearchController
use App\Controllers\SearchController;
// Importation de la classe DashboardController
use App\Controllers\DashboardController;
// Importation de la classe StatistiqueController
use App\Controllers\StatistiqueController;

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
$authController = new AuthController($twig);
$searchController = new SearchController($twig);
$dashboardController = new DashboardController($twig);
$statistiqueController = new StatistiqueController($twig);

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
            $searchController->_Page_Recherche();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'resultat_recherche':
        if ($isConnect) {
            $searchController->_Page_Resultat_Recherche();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'offre':
        if ($isConnect) {
            $searchController->_Page_OffreOnClick();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'entreprise':
        if ($isConnect) {
            $searchController->_Page_EntrepriseOnClick();
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
            $dashboardController->_Page_Dashboard();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'wishlist':
        if ($isConnect) {
            $dashboardController->_Page_Wishlist();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'cv':
        if ($isConnect) {
            $dashboardController->_Page_CV();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'offres_postulees':
        if ($isConnect) {
            $dashboardController->_Page_OffrePostulees();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'ajouter_offre':
        if ($isConnect) {
            $dashboardController->_Page_Ajouter_Offre();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'formulaire_offre':
        if ($isConnect) {
            $dashboardController->formulaire_offre();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'page_modifier_offre':
        if ($isConnect) {
            $dashboardController->_Page_Modifier_Offre();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'modifier_offre':
        if ($isConnect) {
            $dashboardController->modifier_offre();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'ajouter_compte':
        if ($isConnect) {
            $dashboardController->_Page_Ajouter_Compte();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'formulaire_compte':
        if ($isConnect) {
            $dashboardController->formulaire_compte();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'compte':
        if ($isConnect) {
            $dashboardController->_Page_Modifier_Compte();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'modifier_compte':
        if ($isConnect) {
            $dashboardController->modifier_compte();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'postuler':
        if ($isConnect) {
            $controller->_Page_Postuler();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'ajouter_entreprise':
        if ($isConnect) {
            $dashboardController->_Page_Ajouter_Entreprise();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'formulaire_entreprise':
        if ($isConnect) {
            $dashboardController->formulaire_entreprise();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'page_modifier_entreprise':
        if ($isConnect) {
            $dashboardController->_Page_Modifier_Entreprise();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'modifier_entreprise':
        if ($isConnect) {
            $dashboardController->modifier_entreprise();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'statistique_etudiant':
        if ($isConnect) {
            $statistiqueController->_Page_Statistique_Etudiant();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'statistique_offre':
        if ($isConnect) {
            $statistiqueController->_Page_Statistique_Offre();
        }
        else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'ajout_wishlist':
        if ($isConnect) {
            $searchController->_Ajout_Wishlist();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    case 'statistique_entreprise':
        if ($isConnect) {
            $statistiqueController->_Page_Statistique_Entreprise();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;

    case 'note_entreprise':
        if ($isConnect) {
            $searchController->noter_entreprise();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit();
        }
        break;
    default:
        echo '404 Not Found';
        break;
}
