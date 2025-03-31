<?php

namespace App\Controllers;

use App\Models\AuthModel;

class AuthController extends Controller {
    public function __construct() {
        $this->model = new AuthModel();
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
