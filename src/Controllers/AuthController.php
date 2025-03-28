<?php 
namespace App\Controllers;

use App\Models\FileDatabase;

class AuthController extends Controller {
    private $connection;
    public function __construct($connection = null) {
        if(is_null($connection)) {
            $this->connection = new FileDatabase('','','','');
        } else {
            $this->connection = $connection;
        }
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $motDePasse = $_POST['motDePasse'];

            // Vérification de l'utilisateur
            $user = $this->connection->getAllRecords('utilisateurs');

            if ($email === $user['email'] && $motDePasse === $user['motDePasse']) {
                // Stocker l'utilisateur en session
                $_SESSION['user'] = [
                    'id' => $user['id_utilisateurs'],
                    'nom' => $user['email'],
                    'role' => $user['role'],
                    'dateConnexion' => date('Y-m-d H:i:s')
                ];

                // Rediriger selon le rôle
                header("Location: ?uri=role");
                exit();
            } else {
                header("Location: ?uri=connexion");
            }
        } else {
            header("Location: ?uri=connexion");
        }
    }

    public function logout() {
        session_destroy();
        header("Location: ?uri=connexion");
        exit();
    }
}