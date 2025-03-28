<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends Controller
{
    private $userModel;

    public function __construct($connection = null)
    {
        $this->userModel = new UserModel($connection);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $motDePasse = $_POST['password'];

            $user = $this->userModel->getUserByEmail($email);

            if ($user && $motDePasse === $user['mot_de_passe']) {
                $_SESSION['user'] = [
                    'id' => $user['id_utilisateur'],
                    'nom' => $user['nom_utilisateur'],
                    'prenom' => $user['prenom_utilisateur'],
                    'role' => $this->userModel->getRoleById($user['id_role']),
                    'dateConnexion' => date('Y-m-d H:i:s')
                ];
                header("Location: ?uri=accueil");
                exit();
            }
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
