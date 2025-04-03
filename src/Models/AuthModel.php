<?php

namespace App\Models;

class AuthModel extends Model
{
    public function __construct($connection = null)
    {
        if (is_null($connection)) {
            $this->connection = new FileDatabase('172.201.220.97','stageup','azureuser','#Cesi2024');
            //$this->connection = new FileDatabase('localhost','stageup','root','');
        } else {
            $this->connection = $connection;
        }
    }

    public function connexion($email,$motDePasse) {
        $isvalid = false;
        $users = $this->connection->getAllRecords('utilisateur');
        foreach ($users as $user){
            if($email === $user['email'] && password_verify($motDePasse, $user['mot_de_passe'])) {
                $_SESSION['user'] = [
                    'id' => $user['id_utilisateur'],
                    'nom' => $user['nom_utilisateur'],
                    'prenom' => $user['prenom_utilisateur'],
                    'email' => $user['email'],
                    'role' => $this->connection->getRecordById('role',$user['id_role'])['nom_role'],
                    'dateConnexion' => date('Y-m-d H:i:s')
                ];
                $isvalid = true;
                $this->connection->insertLog($_SESSION['user']['id'], $_SESSION['user']['dateConnexion']);
            }
        }
        return $isvalid;
    }
}