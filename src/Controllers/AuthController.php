<?php 
namespace App\Controllers;

use App\Models\FileDatabase;

class AuthController extends Controller {
    private $connection;
    public function __construct($connection = null) {
        if(is_null($connection)) {
            $this->connection = new FileDatabase('172.201.220.97','stageup','azureuser','#Cesi2024');
        } else {
            $this->connection = $connection;
        }
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $motDePasse = $_POST['password'];
            $isvalid = false;
            // Vérification de l'utilisateur
            $users = $this->connection->getAllRecords('Utilisateurs');
            foreach ($users as $user){
                if($email === $user['email'] && $motDePasse === $user['mot_de_passe']) {
                    // Stocker l'utilisateur en session
                    $_SESSION['user'] = [
                        'id' => $user['id_utilisateurs'],
                        'nom' => $user['nom'],
                        'role' => $user['role'],
                        'dateConnexion' => date('Y-m-d H:i:s')
                    ];
                    $isvalid = true;
                }
            }
            if ($isvalid) {
                header("Location: ?uri=accueil");
                exit();
            } else {
                echo $motDePasse;
                echo $user['mot_de_passe'];
            }
        } else {
            header("Location: /full.php");
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /hdtp.php");
        exit();
    }
}