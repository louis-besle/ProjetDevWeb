<?php
use App\Models\StatistiqueModel;
use App\Models\FileDatabase;
use PHPUnit\Framework\TestCase;

class StatistiqueModelTest extends TestCase
{
    private $statModel;
    private $mockDb;

    protected function setUp(): void
    {
        $this->mockDb = $this->createMock(FileDatabase::class);
        $this->statModel = new StatistiqueModel($this->mockDb);
    }

    public function testStatistiqueUtilisateur()
    {
        $mockData = [['total_logs' => 5, 'total_offres' => 3]];
        $this->mockDb->method('statistique')
            ->with(1)
            ->willReturn($mockData);

        $result = $this->statModel->statistique_utilisateur(1);
        $this->assertEquals($mockData, $result);
    }

    public function testRepartitionCompetences()
    {
        $mockData = [['competence' => 'PHP', 'nombre_offres' => 10]];
        $this->mockDb->method('repartitionParCompetence')
            ->willReturn($mockData);

        $result = $this->statModel->rep_competence();
        $this->assertEquals($mockData, $result);
    }

    public function testTopWishlist()
    {
        $mockData = [['titre' => 'Offre populaire', 'nombre_wishlist' => 15]];
        $this->mockDb->method('topOffresWishlist')
            ->willReturn($mockData);

        $result = $this->statModel->rep_wishlist();
        $this->assertEquals($mockData, $result);
    }

    public function testEntrepriseParVille()
    {
        $mockData = [['nom_ville' => 'Paris', 'nombre_entreprises' => 20]];
        $this->mockDb->method('nombreEntreprisesParVille')
            ->willReturn($mockData);

        $result = $this->statModel->entrepriseVille();
        $this->assertEquals($mockData, $result);
    }
}
?>