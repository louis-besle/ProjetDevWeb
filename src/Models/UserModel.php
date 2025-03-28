<?php

namespace App\Models;

class UserModel extends Model
{
    public function __construct($connection = null)
    {
        if (is_null($connection)) {
            $this->connection = new FileDatabase('localhost', 'stageup', 'root', '');
        } else {
            $this->connection = $connection;
        }
    }

    public function getUserByEmail($email)
    {
        $users = $this->connection->getAllRecords('Utilisateurs');
        foreach ($users as $user) {
            if ($email === $user['email']) {
                return $user;
            }
        }
        return null;
    }

    public function getRoleById($roleId)
    {
        return $this->connection->getRecordById('Role', $roleId)['nom_role'] ?? null;
    }
}
