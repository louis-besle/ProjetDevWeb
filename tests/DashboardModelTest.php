<?php
use App\Models\DashboardModel;
use App\Models\FileDatabase;
use PHPUnit\Framework\TestCase;

class DashboardModelTest extends TestCase
{
    private $dashboardModel;
    private $mockDb;

    protected function setUp(): void
    {
        $this->mockDb = $this->createMock(FileDatabase::class);
        $this->dashboardModel = new DashboardModel($this->mockDb);
    }

    public function testGetUtilisateurs()
    {
        $mockData = [['id_utilisateur' => 1, 'nom_role' => 'Etudiant']];
        $this->mockDb->method('getRecordUtilisateur')->willReturn($mockData);

        $result = $this->dashboardModel->getUtilisateurs('Etudiant');
        $this->assertEquals($mockData, $result);
    }

    public function testInsertOffre()
    {
        $this->mockDb->expects($this->once())->method('InsertRecordIntoOffre');

        $this->dashboardModel->insertoffer(
            'Titre', 
            1, 
            [1, 2], 
            '2023-01-01', 
            '2023-06-01', 
            '1000', 
            'Description'
        );
    }
}
?>