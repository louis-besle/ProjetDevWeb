<?php

namespace App\Controllers;

use App\Models\SearchModel;
use Exception;

class SearchController extends Controller
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
            $this->model = new SearchModel();
            $this->templateEngine = $templateEngine;
        } catch (Exception $e) {
            error_log("Erreur d'initialisation du contrôleur: " . $e->getMessage());
            die("Erreur pendant l'initialisation");
        }
    }

    /**
     * Affiche la page de recherche avec les filtres
     */
    public function _Page_Recherche()
    {
        try {
            $ville = isset($_GET['ville']) ? htmlspecialchars($_GET['ville']) : 'Toutes';
            $entreprise = isset($_GET['entreprise']) ? htmlspecialchars($_GET['entreprise']) : 'Toutes';

            $bouton_filtre = [
                'entreprise' => $this->model->getEntreprise(),
                'ville' => $this->model->getVille()
            ];
            $page_actuelle = $this->model->getPageActuelle();
            $offres = $this->model->getOffreRecherche($page_actuelle, $ville, $entreprise);
            $entreprises = $this->model->getVillesEntreprises($page_actuelle, $ville, $entreprise);

            $offres_count = isset($offres[1]) ? $offres[1] : 0;
            $entreprises_count = isset($entreprises[1]) ? $entreprises[1] : 0;

            $nbpages = $this->model->getNbPages($offres_count, $entreprises_count);
            if (empty($nbpages)) {
                $nbpages = 1;
            }

            $nombre_offres = $this->model->nombre_offre();

            echo $this->templateEngine->render('_recherche.twig.html', [
                'offres' => isset($offres[0]) ? $offres[0] : [],
                'entreprises' => isset($entreprises[0]) ? $entreprises[0] : [],
                'page_actuelle' => $page_actuelle,
                'nb_pages' => $nbpages,
                'filtres' => $bouton_filtre,
                'filtre_ville' => $ville,
                'filtre_entreprise' => $entreprise,
                'nombre_offres' => $nombre_offres
            ]);
        } catch (Exception $e) {
            error_log("Erreur page recherche: " . $e->getMessage());
            echo "Une erreur est survenue lors de la recherche";
        }
    }

    /**
     * Affiche la page de détails d'une entreprise
     */
    public function _Page_EntrepriseOnClick()
    {
        $entreprise = $this->model->getEntrepriseClick();
        $idEntreprise = $entreprise['id_entreprise'];
        $com = $this->model->lastcom($idEntreprise);
        $moynote = $this->model->moynote($idEntreprise) / count($com);
        $moynote = round($moynote, 1);
        echo $this->templateEngine->render('_entreprise_onclick.twig.html', [
            "entreprise" => $entreprise, 'com'=>$com, 'moynote' => $moynote
        ]);
    }

    /**
     * Affiche la page de détails d'une offre
     * @return void
     */
    public function _Page_OffreOnClick()
    {
        if (isset($_GET['id'])) {
            $offerId = intval($_GET['id']);
        } else {
            $offerId = null;
        }

        if ($offerId) {
            $competence = $this->model->getCompetenceByOffer($offerId);
            $offres = $this->model->getInfosOffres($offerId); 
            $nombre = $this->model->nombre_personne($offerId);
            $postuler = $this->model->a_candidater($_SESSION['user']['id'],$offerId);
            echo $this->templateEngine->render('_offre_onclick.twig.html', [
                "offre" => $this->model->getOffreclick(),
                "competence" => $competence,
                "duree" => $offres['duree'],
                "entreprise" => $offres['entreprise'],
                "id_offre" => $offerId,
                "nombre" => $nombre,
                "postuler" => $postuler,
                "role" => $_SESSION['user']['role'],
            ]);
        } else {
            echo "ID de l'offre manquant ou invalide.";
        }
    }
    /**
     * Affiche la page de résultats de recherche
     * @return void
     */
    public function _Page_Resultat_Recherche()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rechercheGenerale = isset($_POST['quoi']) ? trim($_POST['quoi']) : null;
            $ville = isset($_POST['ou']) ? trim($_POST['ou']) : null;

            $resultats = $this->model->recherche($rechercheGenerale, $ville);

            echo $this->templateEngine->render('_resultat_recherche.twig.html', ['resultats' => $resultats]);
        }
    }
    /**
     * Permet d'ajouter une offre à la wishlist
     * @return void
     */
    public function _Ajout_Wishlist(){
        $this->model->ajout_wishlist($_SESSION['user']['id'], $_POST['id_offre']);
        if(isset($_GET['page'])) {
            if(isset($_GET['id'])) {
                header('Location: /?uri=' . $_GET['page'].'&id=' . $_GET['id']);
            } else {
                header('Location: /?uri='. $_GET['page']);
            }
        } else {
            header('Location: /?uri=accueil');
        }
    }
    /**
     * Permet de noter une entreprise
     * @return void
     */
    public function noter_entreprise() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idUtilisateur = $_SESSION['user']['id'] ?? null;
            $idEntreprise = $_POST['id_entreprise'] ?? null;
    
            $starId = $_POST['rating'] ?? null;
    
            $note = null;
            if ($starId) {
                $note = (int)str_replace('star', '', $starId);
            }

    
            $commentaire = htmlspecialchars($_POST['comments'] ?? '');
            
            if ($idUtilisateur && $idEntreprise && $note !== null) {
                $this->model->noter($idUtilisateur, $idEntreprise, (float)$note, $commentaire);
                header('Location: /?uri=entreprise');
            }
        }
    }
}
?>