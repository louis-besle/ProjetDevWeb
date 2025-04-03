<?php
use App\Models\SearchModel;
use App\Models\FileDatabase;
use PHPUnit\Framework\TestCase;

class SearchModelTest extends TestCase
{
    private $searchModel;
    private $mockDb;

    protected function setUp(): void
    {
        $this->mockDb = $this->createMock(FileDatabase::class);
        $this->searchModel = new SearchModel($this->mockDb);
    }

    public function testRechercheOffres()
    {
        $mockResults = [['titre' => 'Offre Test']];
        $this->mockDb->method('rechercherOffres')
            ->willReturn($mockResults);

        $result = $this->searchModel->recherche('Test', 'Paris');
        $this->assertEquals($mockResults, $result);
    }
}
?>