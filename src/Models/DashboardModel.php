<?php

namespace App\Models;

class DashboardModel extends Model
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

    public function nombre_utilisateur($role){
        return $this->connection->nbr_utilisateur($role);
    }
    
}
?>