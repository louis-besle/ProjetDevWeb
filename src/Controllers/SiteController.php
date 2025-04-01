<?php

namespace App\Controllers;

use App\Models\SiteModel;
use Exception;

class SiteController extends Controller
{
    protected $model;
    protected $templateEngine;

    /**
     * Constructeur du contrôleur
     * @param mixed $templateEngine Moteur de template
     */
    public function __construct($templateEngine)
    {
        try {
            $this->model = new SiteModel();
            $this->templateEngine = $templateEngine;
        } catch (Exception $e) {
            error_log("Erreur d'initialisation du contrôleur: " . $e->getMessage());
            die("Erreur pendant l'initialisation");
        }
    }

    /**
     * Affiche la page de connexion
     */
    public function _Page_Connexion()
    {
        try {
            echo $this->templateEngine->render('_connexion.twig.html');
        } catch (Exception $e) {
            error_log("Erreur page connexion: " . $e->getMessage());
            echo "Erreur pendant l'affichage de la page";
        }
    }

    /**
     * Affiche la page d'accueil avec les offres et entreprises
     */
    public function _Page_Accueil()
    {
        try {
            $offres = $this->model->getOffresAccueil();
            $entreprises = $this->model->getEntreprisesAccueil($offres);
            
            echo $this->templateEngine->render('_accueil.twig.html', ['offres' => $offres, 'entreprises' => $entreprises]);
        } catch (Exception $e) {
            error_log("Erreur page accueil: " . $e->getMessage());
            echo "Erreur pendant le chargement de la page d'accueil";
        }
    }
    /**
     * Affiche la page de recherche avec les filtres
     */
    public function _Page_Recherche()
    {
        try {
            // Récupération des paramètres de filtrage
            if(isset($_GET['entreprise']) && isset($_GET['ville'])){
                $ville = htmlspecialchars($_GET['ville']);
                $entreprise = htmlspecialchars($_GET['entreprise']);
            } else {
                $ville = 'Toutes';
                $entreprise = 'Toutes';
            }

            // Récupération des données pour la page
            $bouton_filtre = [
                'entreprise' => $this->model->getEntreprise(),
                'ville' => $this->model->getVille()
            ];
            $page_actuelle = $this->model->getPageActuelle();
            $offres = $this->model->getOffreRecherche($page_actuelle, $ville, $entreprise);
            $entreprises = $this->model->getVillesEntreprises($page_actuelle, $ville, $entreprise);
            $nbpages = $this->model->getNbPages($offres[1], $entreprises[1]);

            echo $this->templateEngine->render('_recherche.twig.html', ['offres' => $offres[0], 'entreprises' => $entreprises[0], 'page_actuelle' => $page_actuelle, 'nb_pages' => $nbpages, 'filtres' => $bouton_filtre, 'filtre_ville' => $ville, 'filtre_entreprise' => $entreprise]);
        } catch (Exception $e) {
            error_log("Erreur page recherche: " . $e->getMessage());
            echo "Une erreur est survenue lors de la recherche";
        }
    }
    /**
     * Affiche la page de détails d'une offre
     */
    public function _Page_OffreOnClick()
    {
        echo $this->templateEngine->render('_offre_onclick.twig.html');
    }

    /**
     * Affiche la page de détails d'une entreprise
     */
    public function _Page_EntrepriseOnClick()
    {
        echo $this->templateEngine->render('_entreprise_onclick.twig.html', ["entreprise" => $this->model->getEntrepriseClick()]);
    }

    public function _Page_Dashboard()
    {
        if ($_SESSION['user']['role'] === 'Administrateur') {
            echo $this->templateEngine->render('a_dashboard.twig.html');
        } else if ($_SESSION['user']['role'] === 'Pilote') {
            echo $this->templateEngine->render('p_dashboard.twig.html');
        } else if ($_SESSION['user']['role'] === 'Etudiant') {
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
        
        if ($_SESSION['user']['role'] === 'Administrateur') {
            $utilisateur = $this->model->getUtilisateurs($_SESSION['user']['role']);
            echo $this->templateEngine->render('a_add_account.twig.html', ['utilisateur' => $utilisateur]);
        } else if ($_SESSION['user']['role'] === 'Pilote') {
            $utilisateur = $this->model->getUtilisateurs($_SESSION['user']['role']);
            echo $this->templateEngine->render('p_add_account.twig.html', ['utilisateur' => $utilisateur]);
        }
    }

    public function _Page_Ajouter_Entreprise()
    {
        $ville = $this->model->getVille();
        echo $this->templateEngine->render('_add_enterprise.twig.html', ['ville' => $ville]);
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


            $data = array_merge((array)$competence, (array)$niveau);

            $this->model->insertoffer($offer_title, $entreprise, $data, $start, $end, $remuneration, $job_description);
            header('Location: /?uri=recherche');
        }
    }

    public function formulaire_entreprise()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre_entreprise = htmlspecialchars(trim($_POST['company_name'] ?? ''));
            $ville = filter_var($_POST['city'] ?? null, FILTER_VALIDATE_INT);
            $presentation = htmlspecialchars(trim($_POST['company_description'] ?? ''));
            $tel = htmlspecialchars(trim($_POST['phone'] ?? ''));
            $mail = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL) ? $_POST['email'] : null;

            if (!$titre_entreprise || !$ville || !$presentation || !$tel || !$mail) {
                echo "Veuillez remplir tous les champs obligatoires.";
                return;
            }
            $image = 'default.jpg';

            if (!empty($_FILES['company_image']['name'])) {
                $upload_dir = 'uploads/';
                $image_name = time() . '_' . basename($_FILES['company_image']['name']);
                $image_path = $upload_dir . $image_name;

                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                if (in_array($_FILES['company_image']['type'], $allowed_types) && move_uploaded_file($_FILES['company_image']['tmp_name'], $image_path)) {
                    $image = $image_name;
                }
            }

            $this->model->insertentreprise($titre_entreprise, $ville, $image, $presentation, $tel, $mail);
            header('Location: /?uri=recherche');
        }
    }


    public function formulaire_compte()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_utilisateur = htmlspecialchars(trim($_POST['nom'] ?? ''));
            $prenom_utilisateur = htmlspecialchars(trim($_POST['prenom'] ?? ''));
            $email = filter_var($_POST['courriel'] ?? '', FILTER_VALIDATE_EMAIL) ? $_POST['courriel'] : null;
            $password = $_POST['password'] ?? '';

            $password_hash = password_hash($password,PASSWORD_DEFAULT);
            if ($_POST['account_type'] === null) {
                $role = 3;
            } else {
                $role = $_POST['account_type'];
            }
            if (!$nom_utilisateur || !$prenom_utilisateur || !$email || !$password || !$role) {
                echo "Veuillez remplir tous les champs obligatoires.";
                return;
            }

            $this->model->insertutilisateur($nom_utilisateur, $prenom_utilisateur, $email, $password_hash, $role);
            header('Location: /?uri=ajouter_compte');
        }
    }

}
