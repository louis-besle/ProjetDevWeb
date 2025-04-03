<?php
use App\Models\SiteModel;
use App\Models\FileDatabase;
use PHPUnit\Framework\TestCase;

class SiteModelTest extends TestCase
{
    private $siteModel;
    private $mockDb;

    protected function setUp(): void
    {
        $this->mockDb = $this->createMock(FileDatabase::class);
        $this->siteModel = new SiteModel($this->mockDb);
        
        // Initialisation de session pour les tests
        $_SESSION['user'] = [
            'id' => 1,
            'nom' => 'Test',
            'email' => 'test@example.com'
        ];
    }

    public function testGetInfos()
    {
        $result = $this->siteModel->getInfos();
        $this->assertEquals($_SESSION['user'], $result);
    }

    public function testGetOffresAccueil()
    {
        $mockOffres = [['id_offre' => 1, 'titre' => 'Offre Test']];
        $this->mockDb->method('getLastRecord')
            ->willReturn($mockOffres);

        $result = $this->siteModel->getOffresAccueil();
        $this->assertEquals($mockOffres, $result);
    }

    public function testAjoutCandidature()
    {
        $this->mockDb->expects($this->once())
            ->method('addCandidater')
            ->with(1, 1, 'lettre', 'message')
            ->willReturn(true);

        $result = $this->siteModel->ajout_candidater(1, 1, 'lettre', 'message');
        $this->assertTrue($result);
    }

    protected function tearDown(): void
    {
        unset($_SESSION['user']);
    }
}
?>