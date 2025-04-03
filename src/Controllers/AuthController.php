<?php

namespace App\Controllers;

use App\Models\AuthModel;
use Exception;

class AuthController extends Controller {
    protected $model;
    protected $templateEngine;

    /**
     * Constructeur du contrôleur
     * @param mixed $templateEngine Moteur de template
     */
    public function __construct($templateEngine)
    {
        try {
            $this->model = new AuthModel();
            $this->templateEngine = $templateEngine;
        } catch (Exception $e) {
            error_log("Erreur d'initialisation du contrôleur: " . $e->getMessage());
            die("Erreur pendant l'initialisation");
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $motDePasse = $_POST['password'];
            if ($this->model->connexion($email,$motDePasse)) {
                header("Location: ?uri=accueil");
                exit();
            } else {
                header("Location: /");
            } 
        } else {
            header("Location: /");
        }
        header("Location: /");
    }

    public function logout()
    {
        session_destroy();
        header("Location: /");
        exit();
    }
}
