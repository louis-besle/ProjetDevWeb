<?php

namespace App\Models;

class EntrepriseModel extends Model
{
    public int $id;
    public string $nom;
    public string $ville;
    public string $misenligne;

    public function __construct(int $id, string $nom, string $ville, string $miseenligne)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->ville = $ville;
        $this->miseenligne = $miseenligne;
    }
}

